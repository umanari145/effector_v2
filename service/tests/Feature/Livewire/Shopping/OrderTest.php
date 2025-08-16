<?php

namespace Tests\Feature\Livewire\Shopping;

use Tests\TestCase;
use App\Livewire\Shopping\Order;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test items
        Item::factory()->create(['id' => 1, 'name' => 'Item 1', 'price' => 1000]);
        Item::factory()->create(['id' => 2, 'name' => 'Item 2', 'price' => 2000]);

        // Start session for testing
        Session::start();
    }

    protected function tearDown(): void
    {
        Session::flush();
        parent::tearDown();
    }

    public function test_component_mounts_successfully_with_complete_data()
    {
        $this->setUpCompleteSessionData();

        Livewire::test(Order::class)
            ->assertSet('message', 'ご注文内容をご確認ください')
            ->assertSet('totalPrice', 4000) // (1000 * 2) + (2000 * 1)
            ->assertCount('cartItems', 2);
    }

    /**
     * @dataProvider redirectConditionsProvider
     */
    public function test_component_redirects_when_required_data_missing($quantities, $customerInfo, $shippingInfo, $expectedRoute)
    {
        // Set up session data based on test scenario
        session([
            'cart_quantities' => $quantities,
            'customer_info' => $customerInfo,
            'shipping_info' => $shippingInfo
        ]);

        if (empty($quantities) || array_sum($quantities) === 0) {
            // Should redirect to cart
            Livewire::test(Order::class)
                ->assertRedirect(route('shopping.cart'));
        } elseif (empty($customerInfo)) {
            // Should redirect to customer
            Livewire::test(Order::class)
                ->assertRedirect(route('shopping.customer'));
        } elseif (empty($shippingInfo)) {
            // Should redirect to customer
            Livewire::test(Order::class)
                ->assertRedirect(route('shopping.customer'));
        }
    }

    public function test_get_cart_items_calculates_correctly()
    {
        $this->setUpCompleteSessionData();

        $component = Livewire::test(Order::class);

        // Call the method directly to test calculation
        $component->call('getCartItems')
            ->assertSet('totalPrice', 4000)
            ->assertCount('cartItems', 2);

        // Verify cart item details
        $cartItems = $component->get('cartItems');
        $this->assertEquals('Item 1', $cartItems[0]['name']);
        $this->assertEquals(2, $cartItems[0]['quantity']);
        $this->assertEquals(1000, $cartItems[0]['unit_price']);
        $this->assertEquals(2000, $cartItems[0]['price']);

        $this->assertEquals('Item 2', $cartItems[1]['name']);
        $this->assertEquals(1, $cartItems[1]['quantity']);
        $this->assertEquals(2000, $cartItems[1]['unit_price']);
        $this->assertEquals(2000, $cartItems[1]['price']);
    }

    public function test_back_to_customer_redirects_properly()
    {
        $this->setUpCompleteSessionData();

        Livewire::test(Order::class)
            ->call('backToCustomer')
            ->assertRedirect(route('shopping.customer'));
    }

    public function test_back_to_cart_redirects_properly()
    {
        $this->setUpCompleteSessionData();

        Livewire::test(Order::class)
            ->call('backToCart')
            ->assertRedirect(route('shopping.cart'));
    }

    public function test_confirm_order_success_different_shipping()
    {
        Mail::fake();

        // Set up session with different shipping address
        session([
            'cart_quantities' => [1 => 2, 2 => 3],
            'customer_info' => [
                'name' => '田中太郎',
                'kana' => 'タナカタロウ',
                'tel' => '03-1234-5678',
                'email' => 'tanaka@example.com',
                'zip' => '100-0001',
                'prefecture' => '東京都',
                'city' => '千代田区',
                'address' => '霞が関1-1-1',
                'building' => ''
            ],
            'shipping_info' => [
                'same_as_customer' => false,
                'shipping_name' => '佐藤花子',
                'shipping_kana' => 'サトウハナコ',
                'shipping_tel' => '06-9876-5432',
                'shipping_zip' => '530-0001',
                'shipping_prefecture' => '大阪府',
                'shipping_city' => '大阪市北区',
                'shipping_address' => '梅田1-1-1',
                'shipping_building' => ''
            ]
        ]);

        Livewire::test(Order::class)
            ->call('confirmOrder')
            ->assertRedirect(route('home'));

        // Verify different customer and shipping records
        $this->assertDatabaseHas('customers', [
            'name' => '田中太郎',
            'email' => 'tanaka@example.com',
            'tel' => '03-1234-5678',
            'email' => 'tanaka@example.com',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1',
            'building' => ''
        ]);

        $this->assertDatabaseHas('shippings', [
            'shipping_name' => '佐藤花子',
            'shipping_kana' => 'サトウハナコ',
            'shipping_tel' => '06-9876-5432',
            'shipping_zip' => '530-0001',
            'shipping_prefecture' => '大阪府',
            'shipping_city' => '大阪市北区',
            'shipping_address' => '梅田1-1-1',
            'shipping_building' => ''
        ]);

        // Verify cart total
        $this->assertDatabaseHas('carts', [
            'total_price' => 8000
        ]);

        // Verify cart details
        $this->assertDatabaseHas('cart_details', [
            'quantity' => 2,
            'price' => 2000
        ]);

        $this->assertDatabaseHas('cart_details', [
            'quantity' => 3,
            'price' => 6000
        ]);

        Mail::assertSent(\App\Mail\OrderConfirmationMail::class);
    }

    public function test_confirm_order_handles_service_failure()
    {
        Mail::fake();

        // Set up session with invalid customer data to trigger service failure
        session([
            'cart_quantities' => [1 => 1],
            'customer_info' => [
                'name' => '', // Invalid empty name
                'email' => 'invalid-email'
            ],
            'shipping_info' => [
                'same_as_customer' => true
            ]
        ]);

        $component = Livewire::test(Order::class)
            ->call('confirmOrder');

        // Should not redirect on failure
        $component->assertNoRedirect();

        // Should not create any database records
        $this->assertDatabaseCount('customers', 0);
        $this->assertDatabaseCount('carts', 0);

        // Should not send email
        Mail::assertNothingSent();
    }

    public function test_component_displays_correct_order_summary()
    {
        $this->setUpCompleteSessionData();

        $component = Livewire::test(Order::class);

        // Test that customer info is properly displayed
        $customerInfo = $component->get('customerInfo');
        $this->assertEquals('田中太郎', $customerInfo['name']);
        $this->assertEquals('tanaka@example.com', $customerInfo['email']);

        // Test that shipping info is properly displayed
        $shippingInfo = $component->get('shippingInfo');
        $this->assertTrue($shippingInfo['same_as_customer']);

        // Test cart summary
        $this->assertEquals(4000, $component->get('totalPrice'));
        $this->assertCount(2, $component->get('cartItems'));
    }

    private function setUpCompleteSessionData()
    {
        session([
            'cart_quantities' => [1 => 2, 2 => 1],
            'customer_info' => [
                'name' => '田中太郎',
                'kana' => 'タナカタロウ',
                'tel' => '03-1234-5678',
                'email' => 'tanaka@example.com',
                'zip' => '100-0001',
                'prefecture' => '東京都',
                'city' => '千代田区',
                'address' => '霞が関1-1-1',
                'building' => 'テストビル101'
            ],
            'shipping_info' => [
                'same_as_customer' => true
            ]
        ]);
    }

    public static function redirectConditionsProvider()
    {
        return [
            'empty cart' => [
                'quantities' => [],
                'customerInfo' => ['name' => 'Test'],
                'shippingInfo' => ['same_as_customer' => true],
                'expectedRoute' => 'shopping.cart'
            ],
            'zero quantities' => [
                'quantities' => [1 => 0, 2 => 0],
                'customerInfo' => ['name' => 'Test'],
                'shippingInfo' => ['same_as_customer' => true],
                'expectedRoute' => 'shopping.cart'
            ],
            'missing customer info' => [
                'quantities' => [1 => 2],
                'customerInfo' => [],
                'shippingInfo' => ['same_as_customer' => true],
                'expectedRoute' => 'shopping.customer'
            ],
            'missing shipping info' => [
                'quantities' => [1 => 2],
                'customerInfo' => ['name' => 'Test'],
                'shippingInfo' => [],
                'expectedRoute' => 'shopping.customer'
            ]
        ];
    }
}
