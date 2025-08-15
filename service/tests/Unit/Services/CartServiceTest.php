<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\CartService;
use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $service;
    private CartRepository $cartRepository;
    private CustomerRepository $customerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = new CartRepository();
        $this->customerRepository = new CustomerRepository();

        $this->service = new CartService(
            $this->cartRepository,
            $this->customerRepository
        );
    }

    public function test_get_all_items_returns_repository_result()
    {
        // Create test items in database
        $item1 = Item::factory()->create(['name' => 'Item 1', 'price' => 1000]);
        $item2 = Item::factory()->create(['name' => 'Item 2', 'price' => 2000]);

        $result = $this->service->getAllItems();

        $this->assertCount(2, $result);
        $this->assertEquals('Item 1', $result->first()->name);
        $this->assertEquals('Item 2', $result->last()->name);
    }

    /**
     * @dataProvider cartCalculationProvider
     */
    public function test_calculate_cart_data($items, $quantities, $expectedTotal, $expectedItemCount)
    {
        $result = $this->service->calculateCartData($items, $quantities);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('cartItems', $result);
        $this->assertArrayHasKey('itemPrices', $result);
        $this->assertArrayHasKey('totalPrice', $result);

        $this->assertEquals($expectedTotal, $result['totalPrice']);
        $this->assertCount($expectedItemCount, $result['cartItems']);
    }

    /**
     * @dataProvider canAddToCartProvider
     */
    public function test_can_add_to_cart($totalPrice, $expected)
    {
        $result = $this->service->canAddToCart($totalPrice);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider validateCartQuantitiesProvider
     */
    public function test_validate_cart_quantities($quantities, $expected)
    {
        $result = $this->service->validateCartQuantities($quantities);
        $this->assertEquals($expected, $result);
    }

    public function test_complete_order_success_same_as_customer()
    {
        Mail::fake();

        // Create test data
        $customerData = [
            'name' => '田中太郎',
            'kana' => 'タナカタロウ',
            'email' => 'tanaka@example.com',
            'tel' => '03-1234-5678',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1',
            'building' => 'テストビル101'
        ];

        $shippingData = [
            ''
        ];

        $item = Item::factory()->create([
            'name' => 'item1',
            'price' => 1000
        ]);
        $cartItems = [
            [
                'item_id' => $item->id,
                'name' => 'item1',
                'quantity' => 2,
                'unit_price' => 1000,
                'price' => 2000
            ]
        ];

        $result = $this->service->completeOrder($customerData, $shippingData, $cartItems, true);

        $this->assertTrue($result);

        // Verify data was saved to database
        $this->assertDatabaseHas('customers', [
            'name' => '田中太郎',
            'kana' => 'タナカタロウ',
            'email' => 'tanaka@example.com',
            'tel' => '03-1234-5678',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1',
            'building' => 'テストビル101'
        ]);

        $this->assertDatabaseHas('shippings', [
            'shipping_name' => '田中太郎',
            'shipping_kana' => 'タナカタロウ',
            'shipping_tel' => '03-1234-5678',
            'shipping_zip' => '100-0001',
            'shipping_prefecture' => '東京都',
            'shipping_city' => '千代田区',
            'shipping_address' => '霞が関1-1-1',
            'shipping_building' => 'テストビル101'
        ]);

        $this->assertDatabaseHas('carts', [
            'total_price' => 2000
        ]);

        $this->assertDatabaseHas('cart_details', [
            'item_id' => $item->id,
            'quantity' => 2,
            'price' => 2000
        ]);

        Mail::assertSent(\App\Mail\OrderConfirmationMail::class);
    }

    public function test_complete_order_success_different_shipping_address()
    {
        Mail::fake();

        // Create test data
        $customerData = [
            'name' => '田中太郎',
            'kana' => 'タナカタロウ',
            'email' => 'tanaka@example.com',
            'tel' => '03-1234-5678',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1',
            'building' => ''
        ];

        $shippingData = [
            'shipping_name' => '佐藤花子',
            'shipping_kana' => 'サトウハナコ',
            'shipping_tel' => '06-9876-5432',
            'shipping_zip' => '530-0001',
            'shipping_prefecture' => '大阪府',
            'shipping_city' => '大阪市北区',
            'shipping_address' => '梅田1-1-1',
            'shipping_building' => ''
        ];

        $item = Item::factory()->create([
            'name' => 'Item1',
            'price' => 1500
        ]);
        $cartItems = [
            [
                'item_id' => $item->id,
                'name' => 'Item1',
                'quantity' => 3,
                'unit_price' => 1500,
                'price' => 4500
            ]
        ];

        $result = $this->service->completeOrder($customerData, $shippingData, $cartItems, false);

        $this->assertTrue($result);

        // Verify customer and shipping data are different
        $this->assertDatabaseHas('customers', [
            'name' => '田中太郎',
            'email' => 'tanaka@example.com',
            'email' => 'tanaka@example.com',
            'tel' => '03-1234-5678',
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

        Mail::assertSent(\App\Mail\OrderConfirmationMail::class);
    }

    public function test_complete_order_failure_invalid_data()
    {
        Mail::fake();

        // Test with invalid customer data (missing required fields)
        $customerData = [
            'name' => '', // Empty name should cause failure
        ];

        $result = $this->service->completeOrder($customerData, [], [], false);

        $this->assertFalse($result);
        Mail::assertNothingSent();
    }

    public static function cartCalculationProvider()
    {
        return [
            'empty cart' => [
                'items' => collect([
                    (object)['id' => 1, 'name' => 'Item 1', 'price' => 1000],
                    (object)['id' => 2, 'name' => 'Item 2', 'price' => 2000]
                ]),
                'quantities' => [],
                'expectedTotal' => 0,
                'expectedItemCount' => 0
            ],
            'single item' => [
                'items' => collect([
                    (object)['id' => 1, 'name' => 'Item 1', 'price' => 1000],
                    (object)['id' => 2, 'name' => 'Item 2', 'price' => 2000]
                ]),
                'quantities' => [1 => 2, 2 => 0],
                'expectedTotal' => 2000,
                'expectedItemCount' => 1
            ],
            'multiple items' => [
                'items' => collect([
                    (object)['id' => 1, 'name' => 'Item 1', 'price' => 1000],
                    (object)['id' => 2, 'name' => 'Item 2', 'price' => 2000]
                ]),
                'quantities' => [1 => 2, 2 => 1],
                'expectedTotal' => 4000,
                'expectedItemCount' => 2
            ],
            'high quantities' => [
                'items' => collect([
                    (object)['id' => 1, 'name' => 'Item 1', 'price' => 500],
                    (object)['id' => 2, 'name' => 'Item 2', 'price' => 1500]
                ]),
                'quantities' => [1 => 10, 2 => 5],
                'expectedTotal' => 12500, // (500 * 10) + (1500 * 5)
                'expectedItemCount' => 2
            ]
        ];
    }

    public static function canAddToCartProvider()
    {
        return [
            'zero price' => [0, false],
            'positive price' => [1000, true],
            'large price' => [50000, true],
        ];
    }

    public static function validateCartQuantitiesProvider()
    {
        return [
            'empty quantities' => [[], false],
            'all zero quantities' => [[1 => 0, 2 => 0], false],
            'has positive quantities' => [[1 => 2, 2 => 0], true],
            'all positive quantities' => [[1 => 2, 2 => 3], true],
            'large quantities' => [[1 => 100, 2 => 200], true],
        ];
    }
}
