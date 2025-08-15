<?php

namespace App\Livewire\Shopping;

use Livewire\Component;
use App\Services\CartService;
use App\Services\CustomerService;
use App\Services\ShoppingSessionService;
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

    public $prefectures = [];

    public function mount()
    {
        $cartService = app(CartService::class);
        $customerService = app(CustomerService::class);
        $sessionService = app(ShoppingSessionService::class);

        $this->formRequest = new CustomerFormRequest();
        $this->items = $cartService->getAllItems();
        $this->prefectures = $customerService->getPrefectures();
        $this->quantities = $sessionService->getCartQuantities();

        if (empty($this->quantities)) {
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
        $cartService = app(CartService::class);
        $cartData = $cartService->calculateCartData($this->items, $this->quantities);

        $this->cartItems = $cartData['cartItems'];
        $this->totalPrice = $cartData['totalPrice'];
    }

    public function loadCustomerInfoFromSession()
    {
        $customerService = app(CustomerService::class);
        $sessionService = app(ShoppingSessionService::class);

        // 購入者情報をセッションから復元
        $customerInfo = $sessionService->getCustomerInfo();
        if (!empty($customerInfo)) {
            $restoredCustomer = $customerService->restoreCustomerFromSession($customerInfo);
            $this->name = $restoredCustomer['name'];
            $this->kana = $restoredCustomer['kana'];
            $this->email = $restoredCustomer['email'];
            $this->tel = $restoredCustomer['tel'];
            $this->zip = $restoredCustomer['zip'];
            $this->prefecture = $restoredCustomer['prefecture'];
            $this->city = $restoredCustomer['city'];
            $this->address = $restoredCustomer['address'];
            $this->building = $restoredCustomer['building'];
        }

        // 配送先情報をセッションから復元
        $shippingInfo = $sessionService->getShippingInfo();
        if (!empty($shippingInfo)) {
            $restoredShipping = $customerService->restoreShippingFromSession($shippingInfo);
            $this->same_as_customer = $restoredShipping['same_as_customer'];

            // 配送先が購入者と異なる場合のみ配送先情報を復元
            if (!$this->same_as_customer) {
                $this->shipping_name = $restoredShipping['shipping_name'];
                $this->shipping_kana = $restoredShipping['shipping_kana'];
                $this->shipping_tel = $restoredShipping['shipping_tel'];
                $this->shipping_zip = $restoredShipping['shipping_zip'];
                $this->shipping_prefecture = $restoredShipping['shipping_prefecture'];
                $this->shipping_city = $restoredShipping['shipping_city'];
                $this->shipping_address = $restoredShipping['shipping_address'];
                $this->shipping_building = $restoredShipping['shipping_building'];
            } else {
                // 購入者と同じ場合は配送先情報を購入者情報で上書き
                $this->toggleShippingAddress();
            }
        }
    }

    public function toggleShippingAddress()
    {
        if ($this->same_as_customer) {
            $customerService = app(CustomerService::class);
            $customerData = [
                'name' => $this->name,
                'kana' => $this->kana,
                'tel' => $this->tel,
                'zip' => $this->zip,
                'prefecture' => $this->prefecture,
                'city' => $this->city,
                'address' => $this->address,
                'building' => $this->building
            ];

            $shippingData = $customerService->copyCustomerToShipping($customerData);
            $this->shipping_name = $shippingData['shipping_name'];
            $this->shipping_kana = $shippingData['shipping_kana'];
            $this->shipping_tel = $shippingData['shipping_tel'];
            $this->shipping_zip = $shippingData['shipping_zip'];
            $this->shipping_prefecture = $shippingData['shipping_prefecture'];
            $this->shipping_city = $shippingData['shipping_city'];
            $this->shipping_address = $shippingData['shipping_address'];
            $this->shipping_building = $shippingData['shipping_building'];
        }
    }

    public function submit()
    {
        $this->resetErrorBag();
        $customerService = app(CustomerService::class);
        $sessionService = app(ShoppingSessionService::class);

        $formRequest = new CustomerFormRequest();

        // サービスを使用してフォームデータを準備
        $customerInfo = $customerService->prepareCustomerData([
            'name' => $this->name,
            'kana' => $this->kana,
            'email' => $this->email,
            'tel' => $this->tel,
            'zip' => $this->zip,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'address' => $this->address,
            'building' => $this->building
        ]);

        $shippingInfo = $customerService->prepareShippingData([
            'shipping_name' => $this->shipping_name,
            'shipping_kana' => $this->shipping_kana,
            'shipping_tel' => $this->shipping_tel,
            'shipping_zip' => $this->shipping_zip,
            'shipping_prefecture' => $this->shipping_prefecture,
            'shipping_city' => $this->shipping_city,
            'shipping_address' => $this->shipping_address,
            'shipping_building' => $this->shipping_building,
        ]);

        $data = array_merge(
            $customerInfo,
            ['same_as_customer' => $this->same_as_customer],
            $shippingInfo
        );

        // バリデーション
        $validator = Validator::make($data, $formRequest->rules(), $formRequest->messages());

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }
            return;
        }

        // セッションに保存
        $sessionService->saveCustomerInfo($customerInfo);

        if ($this->same_as_customer) {
            // 購入者と同じ場合は購入者情報をコピー
            $shippingInfo = array_merge($shippingInfo, $customerService->copyCustomerToShipping($customerInfo));
        }

        $shippingInfo['same_as_customer'] = $this->same_as_customer;
        $sessionService->saveShippingInfo($shippingInfo);

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
