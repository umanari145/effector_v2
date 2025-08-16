<?php

namespace Tests\Feature\Livewire\Shopping;

use Tests\TestCase;
use App\Livewire\Shopping\Customer;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Session;

class CustomerTest extends TestCase
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

    public function test_component_mounts_with_cart_quantities()
    {
        // Set up session data
        session(['cart_quantities' => [1 => 2, 2 => 1]]);

        // プロパティの確認
        Livewire::test(Customer::class)
            ->assertSet('quantities.1', 2)
            ->assertSet('quantities.2', 1)
            ->assertSet('totalPrice', 4000) // (1000 * 2) + (2000 * 1)
            ->assertCount('prefectures', 47)
            ->assertSet('prefectures.0', '北海道');
    }

    public function test_component_redirects_when_empty_quantities()
    {
        // Empty session - should redirect to shopping.cart
        session(['cart_quantities' => []]);

        Livewire::test(Customer::class)
            ->assertRedirect(route('shopping.cart'));
    }

    /**
     * @dataProvider customerInfoProvider
     */
    public function test_component_restores_customer_info_from_session($customerInfo, $shippingInfo)
    {
        // Set up session data
        session([
            'cart_quantities' => [1 => 1],
            'customer_info' => $customerInfo,
            'shipping_info' => $shippingInfo
        ]);

        $component = Livewire::test(Customer::class);

        if (!empty($customerInfo)) {
            $component->assertSet('name', $customerInfo['name'] ?? '');
            $component->assertSet('email', $customerInfo['email'] ?? '');
        }

        if (!empty($shippingInfo)) {
            $component->assertSet('same_as_customer', $shippingInfo['same_as_customer'] ?? false);
        }
    }

    public function test_toggle_shipping_address_when_same_as_customer()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', '03-1234-5678')
            ->set('zip', '100-0001')
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('building', 'テストビル101')
            ->set('same_as_customer', true)
            ->assertSet('shipping_name', '田中太郎')
            ->assertSet('shipping_kana', 'タナカタロウ')
            ->assertSet('shipping_tel', '03-1234-5678')
            ->assertSet('shipping_zip', '100-0001')
            ->assertSet('shipping_prefecture', '東京都')
            ->assertSet('shipping_city', '千代田区')
            ->assertSet('shipping_address', '霞が関1-1-1')
            ->assertSet('shipping_building', 'テストビル101');
    }

    /**
     * @dataProvider validationProvider
     */
    public function test_form_validation($formData, $expectedErrors)
    {
        session(['cart_quantities' => [1 => 1]]);

        $component = Livewire::test(Customer::class);

        foreach ($formData as $field => $value) {
            $component->set($field, $value);
        }

        $component->call('submit');

        if (empty($expectedErrors)) {
            $component->assertHasNoErrors();
            $component->assertRedirect(route('shopping.order'));
        } else {
            foreach ($expectedErrors as $field) {
                $component->assertHasErrors($field);
            }
        }
    }

    public function test_successful_form_submission_saves_to_session()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', '03-1234-5678')
            ->set('email', 'tanaka@example.com')
            ->set('zip', '100-0001')
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('building', 'テストビル101')
            ->set('same_as_customer', true)
            ->call('submit')
            ->assertRedirect(route('shopping.order'));

        // Verify session data was saved
        $this->assertEquals('田中太郎', session('customer_info.name'));
        $this->assertEquals('tanaka@example.com', session('customer_info.email'));
        $this->assertEquals('田中太郎', session('shipping_info.shipping_name'));
        $this->assertTrue(session('shipping_info.same_as_customer'));
    }

    public function test_successful_form_submission_with_different_shipping()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', '03-1234-5678')
            ->set('email', 'tanaka@example.com')
            ->set('zip', '100-0001')
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('building', '')
            ->set('same_as_customer', false)
            ->set('shipping_name', '佐藤花子')
            ->set('shipping_kana', 'サトウハナコ')
            ->set('shipping_tel', '06-9876-5432')
            ->set('shipping_zip', '530-0001')
            ->set('shipping_prefecture', '大阪府')
            ->set('shipping_city', '大阪市北区')
            ->set('shipping_address', '梅田1-1-1')
            ->set('shipping_building', '')
            ->call('submit')
            ->assertRedirect(route('shopping.order'));

        // Verify customer and shipping data are different
        $this->assertEquals('田中太郎', session('customer_info.name'));
        $this->assertEquals('佐藤花子', session('shipping_info.shipping_name'));
        $this->assertFalse(session('shipping_info.same_as_customer'));
    }

    public function test_back_to_cart_redirects_properly()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->call('backToCart')
            ->assertRedirect(route('shopping.cart'));
    }

    public function test_form_validation_with_missing_required_fields()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '') // Missing required field
            ->set('email', '') // Missing required field
            ->set('same_as_customer', false)
            ->set('shipping_name', '') // Missing when different shipping
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'shipping_name']);
    }

    public function test_form_validation_with_invalid_email()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', '03-1234-5678')
            ->set('email', 'invalid-email-format')
            ->set('zip', '100-0001')
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('same_as_customer', true)
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    public function test_form_validation_with_invalid_phone_number()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', 'invalid-phone')
            ->set('email', 'tanaka@example.com')
            ->set('zip', '100-0001')
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('same_as_customer', true)
            ->call('submit')
            ->assertHasErrors(['tel']);
    }

    public function test_form_validation_with_invalid_zip_code()
    {
        session(['cart_quantities' => [1 => 1]]);

        Livewire::test(Customer::class)
            ->set('name', '田中太郎')
            ->set('kana', 'タナカタロウ')
            ->set('tel', '03-1234-5678')
            ->set('email', 'tanaka@example.com')
            ->set('zip', '123456') // Invalid format (should be 123-4567)
            ->set('prefecture', '東京都')
            ->set('city', '千代田区')
            ->set('address', '霞が関1-1-1')
            ->set('same_as_customer', true)
            ->call('submit')
            ->assertHasErrors(['zip']);
    }

    public function test_session_restoration_with_existing_data()
    {
        // Set up session with existing customer and shipping info
        session([
            'cart_quantities' => [1 => 2, 2 => 1],
            'customer_info' => [
                'name' => '高橋一郎',
                'kana' => 'タカハシイチロウ',
                'tel' => '03-0000-0000',
                'email' => 'takahashi@example.com',
                'zip' => '150-0001',
                'prefecture' => '東京都',
                'city' => '渋谷区',
                'address' => '神宮前1-1-1',
                'building' => 'マンション101'
            ],
            'shipping_info' => [
                'same_as_customer' => false,
                'shipping_name' => '山田次郎',
                'shipping_kana' => 'ヤマダジロウ',
                'shipping_tel' => '06-1111-2222',
                'shipping_zip' => '550-0001',
                'shipping_prefecture' => '大阪府',
                'shipping_city' => '大阪市西区',
                'shipping_address' => '土佐堀1-1-1',
                'shipping_building' => 'ビル202'
            ]
        ]);

        Livewire::test(Customer::class)
            // Verify customer info is restored
            ->assertSet('name', '高橋一郎')
            ->assertSet('kana', 'タカハシイチロウ')
            ->assertSet('email', 'takahashi@example.com')
            ->assertSet('prefecture', '東京都')
            ->assertSet('building', 'マンション101')
            // Verify shipping info is restored
            ->assertSet('same_as_customer', false)
            ->assertSet('shipping_name', '山田次郎')
            ->assertSet('shipping_kana', 'ヤマダジロウ')
            ->assertSet('shipping_prefecture', '大阪府')
            ->assertSet('shipping_building', 'ビル202');
    }

    public function test_cart_items_calculation_from_session()
    {
        session(['cart_quantities' => [1 => 3, 2 => 2]]);

        Livewire::test(Customer::class)
            ->assertSet('totalPrice', 7000) // (1000 * 3) + (2000 * 2)
            ->assertCount('cartItems', 2);
    }

    public static function customerInfoProvider()
    {
        return [
            'with customer info' => [
                ['name' => '田中太郎', 'email' => 'tanaka@example.com'],
                ['same_as_customer' => false]
            ],
            'empty session' => [
                [null],
                [null]
            ],
            'same as customer' => [
                ['name' => '佐藤花子', 'email' => 'sato@example.com'],
                ['same_as_customer' => true]
            ]
        ];
    }

    public static function validationProvider()
    {
        return [
            'valid data same as customer' => [
                [
                    'name' => '田中太郎',
                    'kana' => 'タナカタロウ',
                    'tel' => '03-1234-5678',
                    'email' => 'tanaka@example.com',
                    'zip' => '100-0001',
                    'prefecture' => '東京都',
                    'city' => '千代田区',
                    'address' => '霞が関1-1-1',
                    'building' => 'テストビル101',
                    'same_as_customer' => true
                ],
                []
            ],
            'valid data different shipping' => [
                [
                    'name' => '田中太郎',
                    'kana' => 'タナカタロウ',
                    'tel' => '03-1234-5678',
                    'email' => 'tanaka@example.com',
                    'zip' => '100-0001',
                    'prefecture' => '東京都',
                    'city' => '千代田区',
                    'address' => '霞が関1-1-1',
                    'building' => '',
                    'same_as_customer' => false,
                    'shipping_name' => '佐藤花子',
                    'shipping_kana' => 'サトウハナコ',
                    'shipping_tel' => '06-9876-5432',
                    'shipping_zip' => '530-0001',
                    'shipping_prefecture' => '大阪府',
                    'shipping_city' => '大阪市北区',
                    'shipping_address' => '梅田1-1-1',
                    'shipping_building' => ''
                ],
                []
            ],
            'missing required fields' => [
                [
                    'name' => '',
                    'email' => '',
                    'same_as_customer' => false,
                    'shipping_name' => ''
                ],
                ['name', 'email', 'shipping_name']
            ],
            'invalid email' => [
                [
                    'name' => '田中太郎',
                    'email' => 'invalid-email',
                    'same_as_customer' => true
                ],
                ['email']
            ]
        ];
    }
}
