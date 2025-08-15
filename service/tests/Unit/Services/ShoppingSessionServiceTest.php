<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ShoppingSessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class ShoppingSessionServiceTest extends TestCase
{
    use RefreshDatabase;

    private ShoppingSessionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ShoppingSessionService();
        Session::start();
    }

    protected function tearDown(): void
    {
        Session::flush();
        parent::tearDown();
    }

    /**
     * @dataProvider sessionDataProvider
     */
    public function test_cart_quantities_operations($quantities)
    {
        // Test save and get
        $this->service->saveCartQuantities($quantities);
        $this->assertEquals($quantities, $this->service->getCartQuantities());
    }

    /**
     * @dataProvider sessionDataProvider
     */
    public function test_customer_info_operations($data)
    {
        // Test save and get
        $this->service->saveCustomerInfo($data);
        $this->assertEquals($data, $this->service->getCustomerInfo());
    }

    /**
     * @dataProvider sessionDataProvider
     */
    public function test_shipping_info_operations($data)
    {
        // Test save and get
        $this->service->saveShippingInfo($data);
        $this->assertEquals($data, $this->service->getShippingInfo());
    }

    public function test_get_empty_session_returns_empty_array()
    {
        $this->assertEquals([], $this->service->getCartQuantities());
        $this->assertEquals([], $this->service->getCustomerInfo());
        $this->assertEquals([], $this->service->getShippingInfo());
    }

    /**
     * @dataProvider cartEmptyProvider
     */
    public function test_is_cart_empty($quantities, $expected)
    {
        $this->service->saveCartQuantities($quantities);
        $this->assertEquals($expected, $this->service->isCartEmpty());
    }

    public function test_clear_shopping_session()
    {
        // Setup test data
        $this->service->saveCartQuantities([1 => 2, 2 => 3]);
        $this->service->saveCustomerInfo(['name' => 'Test User']);
        $this->service->saveShippingInfo(['shipping_name' => 'Test User']);

        // Clear session
        $this->service->clearShoppingSession();

        // Assert all data is cleared
        $this->assertEquals([], $this->service->getCartQuantities());
        $this->assertEquals([], $this->service->getCustomerInfo());
        $this->assertEquals([], $this->service->getShippingInfo());
    }

    public static function sessionDataProvider()
    {
        return [
            'empty array' => [[]],
            'single item' => [['key' => 'value']],
            'multiple items' => [['name' => 'Test', 'email' => 'test@example.com']],
            'cart quantities' => [[1 => 2, 2 => 3, 3 => 1]],
        ];
    }

    public static function cartEmptyProvider()
    {
        return [
            'empty array' => [[], true],
            'all zero quantities' => [[1 => 0, 2 => 0], true],
            'has quantities' => [[1 => 2, 2 => 3], false],
            'mixed quantities' => [[1 => 0, 2 => 3], false],
        ];
    }
}
