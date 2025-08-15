<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Support\Facades\Validator;

class Customer extends Component
{
    public $items = [];
    public $quantities = [];
    public $totalPrice = 0;
    public $cartItems = [];
    public $message = '';

    // 購入者情報
    public $name = '';
    public $kana = '';
    public $email = '';
    public $tel = '';
    public $zip = '';
    public $prefecture = '';
    public $city = '';
    public $address = '';
    public $building = '';

    // 配送先情報
    public $same_as_customer = false;
    public $shipping_name = '';
    public $shipping_kana = '';
    public $shipping_tel = '';
    public $shipping_zip = '';
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
        $this->formRequest = new CustomerFormRequest();
        $this->items = $cartService->getAllItems();
        $this->quantities = session()->get('cart_quantities');
        if ($this->quantities === []) {
            redirect()->route('shopping.cart');
        }

        // セッションから既存の顧客情報を復元
        $this->loadCartInfoFromSession();
        $this->loadCustomerInfoFromSession();
    }

    public function updated($propertyName)
    {
        // 配送先が購入者と同じ場合の処理
        if ($propertyName === 'same_as_customer') {
            $this->toggleShippingAddress();
        }
    }

    public function loadCartInfoFromSession()
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

    public function loadCustomerInfoFromSession()
    {
        // 購入者情報をセッションから復元
        $customerInfo = session()->get('customer_info', []);
        if (!empty($customerInfo)) {
            $this->name = $customerInfo['name'] ?? '';
            $this->kana = $customerInfo['kana'] ?? '';
            $this->email = $customerInfo['email'] ?? '';
            $this->tel = $customerInfo['tel'] ?? '';
            $this->zip = $customerInfo['zip'] ?? '';
            $this->prefecture = $customerInfo['prefecture'] ?? '';
            $this->city = $customerInfo['city'] ?? '';
            $this->address = $customerInfo['address'] ?? '';
            $this->building = $customerInfo['building'] ?? '';
        }

        // 配送先情報をセッションから復元
        $shippingInfo = session()->get('shipping_info', []);
        if (!empty($shippingInfo)) {
            $this->same_as_customer = $shippingInfo['same_as_customer'] ?? false;

            // 配送先が購入者と異なる場合のみ配送先情報を復元
            if (!$this->same_as_customer) {
                $this->shipping_name = $shippingInfo['shipping_name'] ?? '';
                $this->shipping_kana = $shippingInfo['shipping_kana'] ?? '';
                $this->shipping_tel = $shippingInfo['shipping_tel'] ?? '';
                $this->shipping_zip = $shippingInfo['shipping_zip'] ?? '';
                $this->shipping_prefecture = $shippingInfo['shipping_prefecture'] ?? '';
                $this->shipping_city = $shippingInfo['shipping_city'] ?? '';
                $this->shipping_address = $shippingInfo['shipping_address'] ?? '';
                $this->shipping_building = $shippingInfo['shipping_building'] ?? '';
            } else {
                // 購入者と同じ場合は配送先情報を購入者情報で上書き
                $this->toggleShippingAddress();
            }
        }
    }

    public function toggleShippingAddress()
    {
        if ($this->same_as_customer) {
            $this->shipping_name = $this->name;
            $this->shipping_kana = $this->kana;
            $this->shipping_tel = $this->tel;
            $this->shipping_zip = $this->zip;
            $this->shipping_prefecture = $this->prefecture;
            $this->shipping_city = $this->city;
            $this->shipping_address = $this->address;
            $this->shipping_building = $this->building;
        }
    }

    public function submit()
    {
        $this->resetErrorBag();
        $formRequest = new CustomerFormRequest();
        $customerInfo = [
            'name' => $this->name,
            'kana' => $this->kana,
            'email' => $this->email,
            'tel' => $this->tel,
            'zip' => $this->zip,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'address' => $this->address,
            'building' => $this->building
        ];

        // 現在のコンポーネントのデータを配列として準備
        $shippingInfo = [
            'shipping_name' => $this->shipping_name,
            'shipping_kana' => $this->shipping_kana,
            'shipping_tel' => $this->shipping_tel,
            'shipping_zip' => $this->shipping_zip,
            'shipping_prefecture' => $this->shipping_prefecture,
            'shipping_city' => $this->shipping_city,
            'shipping_address' => $this->shipping_address,
            'shipping_building' => $this->shipping_building,
        ];


        $data = array_merge(
            $customerInfo,
            ['same_as_customer' => $this->same_as_customer],
            $shippingInfo
        );
        // 配送先情報の保存
        $validator = Validator::make($data, $formRequest->rules(), $formRequest->messages());

        if ($validator->fails()) {
            // バリデーションエラーをLivewireに適用
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        session()->put('customer_info', $customerInfo);

        if ($this->same_as_customer) {
            // 購入者と同じ場合は購入者情報をコピー
            $shippingInfo = array_merge($shippingInfo, [
                'shipping_name' => $this->name,
                'shipping_kana' => $this->kana,
                'shipping_tel' => $this->tel,
                'shipping_zip' => $this->zip,
                'shipping_prefecture' => $this->prefecture,
                'shipping_city' => $this->city,
                'shipping_address' => $this->address,
                'shipping_building' => $this->building,
            ]);
        } else {
            // 配送先が異なる場合は配送先情報を使用
            $shippingInfo = array_merge($shippingInfo, [
                'shipping_name' => $this->shipping_name,
                'shipping_kana' => $this->shipping_kana,
                'shipping_tel' => $this->shipping_tel,
                'shipping_zip' => $this->shipping_zip,
                'shipping_prefecture' => $this->shipping_prefecture,
                'shipping_city' => $this->shipping_city,
                'shipping_address' => $this->shipping_address,
                'shipping_building' => $this->shipping_building,
            ]);
        }

        session()->put('shipping_info', $shippingInfo);
        session()->flash('message', '顧客情報を保存しました。');

        return redirect()->route('shopping.order');
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
