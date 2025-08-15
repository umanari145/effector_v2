<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;
use App\Services\ShoppingSessionService;

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
        $cartService = app(CartService::class);
        $sessionService = app(ShoppingSessionService::class);

        // セッションから商品情報を取得
        $this->items = $cartService->getAllItems();
        $this->quantities = $sessionService->getCartQuantities();

        // カート内容がない場合はカート画面にリダイレクト
        if ($sessionService->isCartEmpty()) {
            return redirect()->route('shopping.cart');
        }

        // 購入者情報を取得
        $this->customerInfo = $sessionService->getCustomerInfo();
        if (empty($this->customerInfo)) {
            return redirect()->route('shopping.customer');
        }

        // 配送先情報を取得
        $this->shippingInfo = $sessionService->getShippingInfo();
        if (empty($this->shippingInfo)) {
            return redirect()->route('shopping.customer');
        }

        $this->message = 'ご注文内容をご確認ください';
        $this->getCartItems();
    }

    public function getCartItems()
    {
        $cartService = app(CartService::class);
        $cartData = $cartService->calculateCartData($this->items, $this->quantities);

        $this->cartItems = $cartData['cartItems'];
        $this->totalPrice = $cartData['totalPrice'];
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
        try {
            $cartService = app(CartService::class);

            // カート内容を準備
            $cartItems = [];
            foreach ($this->items as $item) {
                $quantity = (int)($this->quantities[$item->id] ?? 0);
                if ($quantity > 0) {
                    $cartItems[] = [
                        'item_id' => $item->id,
                        'name' => $item->name,
                        'quantity' => $quantity,
                        'unit_price' => $item->price,
                        'price' => $quantity * $item->price
                    ];
                }
            }

            // 配送先が購入者と同じかどうかを判定
            $sameAsCustomer = $this->shippingInfo['same_as_customer'] ?? false;

            // 注文を完了
            $success = $cartService->completeOrder(
                $this->customerInfo,
                $this->shippingInfo,
                $cartItems,
                $sameAsCustomer
            );

            if ($success) {
                session()->flash('message', 'ご注文ありがとうございました。確認メールをお送りしました。');
                // セッションをクリア
                $sessionService = app(ShoppingSessionService::class);
                $sessionService->clearShoppingSession();
                return redirect()->route('home');
            } else {
                session()->flash('error', '注文処理中にエラーが発生しました。お手数ですが、もう一度お試しください。');
                return;
            }
        } catch (\Exception $e) {
            \Log::error('Order confirmation failed: ' . $e->getMessage());
            session()->flash('error', '注文処理中にエラーが発生しました。お手数ですが、もう一度お試しください。');
            return;
        }
    }

    public function render()
    {
        return view('livewire.shopping.order');
    }
}
