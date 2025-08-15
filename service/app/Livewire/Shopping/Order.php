<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;

class Order extends Component
{
    public $items = [];
    public $quantities = [];
    public $totalPrice = 0;
    public $cartItems = [];
    public $customerInfo = [];
    public $shippingInfo = [];
    public $message = '';

    public function mount()
    {
        // セッションから商品情報を取得
        $cartService = app(CartService::class);
        $this->items = $cartService->getAllItems();
        $this->quantities = session()->get('cart_quantities', []);

        // カート内容がない場合はカート画面にリダイレクト
        if (empty($this->quantities) || array_sum($this->quantities) === 0) {
            return redirect()->route('shopping.cart');
        }

        // 購入者情報を取得
        $this->customerInfo = session()->get('customer_info', []);
        if (empty($this->customerInfo)) {
            return redirect()->route('shopping.customer');
        }

        // 配送先情報を取得
        $this->shippingInfo = session()->get('shipping_info', []);
        if (empty($this->shippingInfo)) {
            return redirect()->route('shopping.customer');
        }

        $this->message = 'ご注文内容をご確認ください';
        $this->getCartItems();
    }

    public function getCartItems()
    {
        $this->totalPrice = 0;
        $this->cartItems = [];

        foreach ($this->items as $item) {
            $quantity = (int)($this->quantities[$item->id] ?? 0);
            if ($quantity > 0) {
                $price = $quantity * $item->price;
                $this->totalPrice += $price;
                $this->cartItems[] = [
                    'name' => $item->name,
                    'quantity' => $quantity,
                    'unit_price' => $item->price,
                    'price' => $price
                ];
            }
        }
    }

    public function backToCustomer()
    {
        return redirect()->route('shopping.customer');
    }

    public function backToCart()
    {
        return redirect()->route('shopping.cart');
    }

    public function confirmOrder()
    {
        // 注文確定処理（後で実装）
        session()->flash('message', 'ご注文ありがとうございました。');
        // セッションをクリア
        session()->forget(['cart_quantities', 'customer_info', 'shipping_info']);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.shopping.order');
    }
}
