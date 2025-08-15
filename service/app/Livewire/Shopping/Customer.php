<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;
use App\Http\Requests\CustomerFormRequest;

class Customer extends Component
{
    public $items = [];
    public $quantities = [];
    public $totalPrice = 0;
    public $cartItems = [];
    public $message = '';

    // 購入者情報
    public $name = '';
    public $name_kana = '';
    public $email = '';
    public $phone = '';
    public $postal_code = '';
    public $prefecture = '';
    public $city = '';
    public $address = '';
    public $building = '';

    // 配送先情報
    public $same_as_customer = false;
    public $shipping_name = '';
    public $shipping_name_kana = '';
    public $shipping_phone = '';
    public $shipping_postal_code = '';
    public $shipping_prefecture = '';
    public $shipping_city = '';
    public $shipping_address = '';
    public $shipping_building = '';

    public $prefectures = [
        '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
        '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
        '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
        '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
        '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
        '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
        '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
    ];

    public function mount()
    {
        $cartService = app(CartService::class);
        $this->items = $cartService->getAllItems();
        $this->quantities = session()->get('cart_quantities');
        if ($this->quantities === []) {
            redirect()->route('cart.index');
        }
        $this->message = 'ご希望の商確認画面';
        $this->getSeesionCart();
    }

    public function updated($propertyName)
    {
        // 配送先が購入者と同じ場合の処理
        if ($propertyName === 'same_as_customer') {
            $this->toggleShippingAddress();
        }
    }

    public function toggleShippingAddress()
    {
        if ($this->same_as_customer) {
            $this->shipping_name = $this->name;
            $this->shipping_name_kana = $this->name_kana;
            $this->shipping_phone = $this->phone;
            $this->shipping_postal_code = $this->postal_code;
            $this->shipping_prefecture = $this->prefecture;
            $this->shipping_city = $this->city;
            $this->shipping_address = $this->address;
            $this->shipping_building = $this->building;
        }
    }

    public function getSeesionCart()
    {
        $this->totalPrice = 0;
        foreach ($this->items as $item) {
            $name = $item->name;
            $quantity = (int)($this->quantities[$item->id] ?? 0);
            $price = $quantity * $item->price;
            $this->totalPrice += $price;
            $item = [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price
            ];
            $this->cartItems[] = $item;
        }
    }

    public function submit()
    {
        $request = app(CustomerFormRequest::class);
        $rules = $request->rules();
        $messages = $request->messages();

        $this->validate($rules, $messages);

        session()->put('customer_info', [
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'email' => $this->email,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'address' => $this->address,
            'building' => $this->building,
        ]);

        // 配送先情報の保存
        $shippingInfo = [
            'same_as_customer' => $this->same_as_customer,
        ];

        if ($this->same_as_customer) {
            // 購入者と同じ場合は購入者情報をコピー
            $shippingInfo = array_merge($shippingInfo, [
                'shipping_name' => $this->name,
                'shipping_name_kana' => $this->name_kana,
                'shipping_phone' => $this->phone,
                'shipping_postal_code' => $this->postal_code,
                'shipping_prefecture' => $this->prefecture,
                'shipping_city' => $this->city,
                'shipping_address' => $this->address,
                'shipping_building' => $this->building,
            ]);
        } else {
            // 配送先が異なる場合は配送先情報を使用
            $shippingInfo = array_merge($shippingInfo, [
                'shipping_name' => $this->shipping_name,
                'shipping_name_kana' => $this->shipping_name_kana,
                'shipping_phone' => $this->shipping_phone,
                'shipping_postal_code' => $this->shipping_postal_code,
                'shipping_prefecture' => $this->shipping_prefecture,
                'shipping_city' => $this->shipping_city,
                'shipping_address' => $this->shipping_address,
                'shipping_building' => $this->shipping_building,
            ]);
        }

        session()->put('shipping_info', $shippingInfo);
        session()->flash('message', '顧客情報を保存しました。');

        return redirect()->route('cart.order');
    }

    public function backToCart()
    {
        return redirect()->route('shopping.cart');
    }

    public function render()
    {
        return view('livewire.shopping.customer');
    }
}
