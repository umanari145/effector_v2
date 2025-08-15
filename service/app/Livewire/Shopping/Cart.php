<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;
use App\Services\ShoppingSessionService;

// カート画面の金額計算ロジックをここで実装
class Cart extends Component
{
    public $items = [];
    public $quantities = [];
    public $itemPrices = [];
    public $totalPrice = 0;
    public $canAddCart = '';
    public $cartProp = '';
    public $message = '';

    protected $listeners = ['quantityUpdated' => 'calculatePrices'];

    public function mount()
    {
        $cartService = app(CartService::class);
        $sessionService = app(ShoppingSessionService::class);

        $this->items = $cartService->getAllItems();

        // セッションからカート数量を取得、なければ0で初期化
        $sessionQuantities = $sessionService->getCartQuantities();

        foreach ($this->items as $item) {
            $this->quantities[$item->id] = $sessionQuantities[$item->id] ?? 0;
        }

        $this->message = 'ご希望の商品数を入力後、画面右下の「カートにいれる」ボタンを押してください';
        $this->calculatePrices();
        $this->detectAddCart();
    }

    public function updatedQuantities()
    {
        $this->calculatePrices();
        $this->detectAddCart();
    }

    public function calculatePrices()
    {
        $cartService = app(CartService::class);
        $cartData = $cartService->calculateCartData($this->items, $this->quantities);

        $this->itemPrices = $cartData['itemPrices'];
        $this->totalPrice = $cartData['totalPrice'];
    }

    public function detectAddCart()
    {
        $cartService = app(CartService::class);
        $canAdd = $cartService->canAddToCart($this->totalPrice);

        if (!$canAdd) {
            $this->canAddCart = 'disabled="true"';
            $this->cartProp = 'disabled:bg-green-200';
        } else {
            $this->canAddCart = '';
            $this->cartProp = '';
        }
    }

    public function addToCart()
    {
        $cartService = app(CartService::class);
        $sessionService = app(ShoppingSessionService::class);

        // 数量チェック
        if (!$cartService->validateCartQuantities($this->quantities)) {
            session()->flash('error', 'ご希望の商品数を入力してください。');
            return;
        }

        // セッションに保存してリダイレクト
        $sessionService->saveCartQuantities($this->quantities);
        return redirect()->route('shopping.customer');
    }

    public function render()
    {
        return view('livewire.shopping.cart');
    }
}
