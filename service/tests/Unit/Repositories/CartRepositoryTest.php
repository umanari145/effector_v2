<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\CartRepository;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CartRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CartRepository();
    }

    public function test_get_all_items_returns_all_items()
    {
        // Create test items
        $item1 = Item::factory()->create(['name' => 'Item 1', 'price' => 1000]);
        $item2 = Item::factory()->create(['name' => 'Item 2', 'price' => 2000]);

        $result = $this->repository->getAllItems();

        $this->assertCount(2, $result);
        $this->assertEquals('Item 1', $result->first()->name);
        $this->assertEquals('Item 2', $result->last()->name);
    }

    /**
     * @dataProvider cartDataProvider
     */
    public function test_create_cart($totalPrice)
    {
        $customer = Customer::factory()->create();
        $shipping = Shipping::factory()->create();

        $cart = $this->repository->createCart($customer, $shipping, $totalPrice);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals($customer->id, $cart->customer_id);
        $this->assertEquals($shipping->id, $cart->shipping_id);
        $this->assertEquals($totalPrice, $cart->total_price);
        $this->assertDatabaseHas('carts', [
            'customer_id' => $customer->id,
            'shipping_id' => $shipping->id,
            'total_price' => $totalPrice
        ]);
    }

    /**
     * @dataProvider cartDetailDataProvider
     */
    public function test_create_cart_detail($quantity, $price)
    {
        $customer = Customer::factory()->create();
        $shipping = Shipping::factory()->create();

        $cart = Cart::factory()->create([
            'customer_id' => $customer->id,
            'shipping_id' => $shipping->id,
            'total_price' => 2000
        ]);

        $item = Item::factory()->create();

        $cartDetail = $this->repository->createCartDetail($cart, $item->id, $quantity, $price);

        $this->assertInstanceOf(CartDetail::class, $cartDetail);
        $this->assertEquals($cart->id, $cartDetail->cart_id);
        $this->assertEquals($item->id, $cartDetail->item_id);
        $this->assertEquals($quantity, $cartDetail->quantity);
        $this->assertEquals($price, $cartDetail->price);
        $this->assertDatabaseHas('cart_details', [
            'cart_id' => $cart->id,
            'item_id' => $item->id,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    public static function cartDataProvider()
    {
        return [
            'small amount' => [1000],
            'medium amount' => [5000],
            'large amount' => [50000],
            'zero amount' => [0],
        ];
    }

    public static function cartDetailDataProvider()
    {
        return [
            'single item' => [1, 1000],
            'multiple items' => [3, 3000],
            'expensive item' => [1, 10000],
            'bulk quantity' => [10, 5000],
        ];
    }
}
