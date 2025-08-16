<?php

namespace Tests\Feature\Livewire\Shopping;

use Tests\TestCase;
use App\Livewire\Shopping\Cart;
use App\Models\Item;
use App\Services\ShoppingSessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test items
        // ダミーでこのようにセット
        Item::factory()->create(['id' => 1, 'name' => 'Item 1', 'price' => 1000]);
        Item::factory()->create(['id' => 2, 'name' => 'Item 2', 'price' => 2000]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_component_loads_quantities_from_session()
    {
        $sessionService = Mockery::mock(ShoppingSessionService::class);
        $sessionService->shouldReceive('getCartQuantities')
            ->once()
            ->andReturn([1 => 2, 2 => 1]);

        $this->app->instance(ShoppingSessionService::class, $sessionService);

        Livewire::test(Cart::class)
            // プロパティの確認
            ->assertSet('quantities.1', 2)
            ->assertSet('quantities.2', 1)
            ->assertSet('totalPrice', 4000); // (1000 * 2) + (2000 * 1)
    }

    /**
     * @dataProvider quantityUpdateProvider
     */
    public function test_quantities_update_triggers_calculation($quantities, $expectedTotal)
    {
        Livewire::test(Cart::class)

            ->set('quantities', $quantities)
            ->assertSet('totalPrice', $expectedTotal);
    }

    /**
     * @dataProvider addToCartButtonStateProvider
     */
    public function test_add_to_cart_button_state($totalPrice, $expectedCanAdd, $expectedCartProp)
    {
        $component = Livewire::test(Cart::class)
            ->set('totalPrice', $totalPrice)
            // refrection的なメソッド
            ->call('detectAddCart');

        $component->assertSet('canAddCart', $expectedCanAdd)
                  ->assertSet('cartProp', $expectedCartProp);
    }

    public function test_add_to_cart_with_empty_quantities_shows_error()
    {
            Livewire::test(Cart::class)
                ->set('quantities', [1 => 0, 2 => 0])
                ->call('addToCart')
                // redirectしない
                ->assertNoRedirect();
    }

    public function test_add_to_cart_with_valid_quantities_redirects()
    {
        $sessionService = Mockery::mock(ShoppingSessionService::class);
        // mountの中にあるメソッドなのでかいておく。Mockeyを定義しておく場合エラーが出る
        $sessionService->shouldReceive('getCartQuantities')->andReturn([]);
        $sessionService->shouldReceive('saveCartQuantities')->once()->with([1 => 2, 2 => 1]);

        $this->app->instance(ShoppingSessionService::class, $sessionService);

        Livewire::test(Cart::class)
            ->set('quantities', [1 => 2, 2 => 1])
            ->call('addToCart')
            // 正常系での成功
            ->assertSet('totalPrice', 4000)
            ->assertRedirect(route('shopping.customer'));
    }

    public static function quantityUpdateProvider()
    {
        return [
            'multiple items' => [[1 => 1, 2 => 1], 3000], // (1000 * 1) + (2000 * 1)
            'mixed quantities' => [[1 => 3, 2 => 2], 7000], // (1000 * 3) + (2000 * 2)
        ];
    }

    public static function addToCartButtonStateProvider()
    {
        return [
            'zero total' => [0, 'disabled="true"', 'disabled:bg-green-200'],
            'positive total' => [1000, '', ''],
            'large total' => [50000, '', ''],
        ];
    }
}
