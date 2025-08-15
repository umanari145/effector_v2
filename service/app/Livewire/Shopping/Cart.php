<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;

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
        $this->items = $cartService->getAllItems();

        // セッションからカート数量を取得、なければ0で初期化
        $sessionQuantities = session()->get('cart_quantities', []);

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
        $this->itemPrices = [];
        $this->totalPrice = 0;

        foreach ($this->items as $item) {
            $quantity = (int)($this->quantities[$item->id] ?? 0);
            $price = $quantity * $item->price;

            $this->itemPrices[$item->id] = $price;
            $this->totalPrice += $price;
        }
    }

    public function detectAddCart()
    {
        if ($this->totalPrice === 0) {
            $this->canAddCart = 'disabled="true"';
            $this->cartProp = 'disabled:bg-green-200';
        } else {
            $this->canAddCart = '';
            $this->cartProp = '';
        }
    }

    public function addToCart()
    {
        // 数量チェック
        $totalQuantity = array_sum($this->quantities);

        if ($totalQuantity === 0) {
            session()->flash('error', 'ご希望の商品数を入力してください。');
            return;
        }

        // セッションに保存してリダイレクト
        session()->put('cart_quantities', $this->quantities);
        return redirect()->route('shopping.customer');
    }

    public function render()
    {
        return view('livewire.shopping.cart');
    }
}
