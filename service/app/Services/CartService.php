<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderConfirmationMail;

class CartService
{
    private CartRepository $cartRepository;
    private CustomerRepository $customerRepository;

    public function __construct(
        CartRepository $cartRepository,
        CustomerRepository $customerRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * 全商品を取得
     */
    public function getAllItems()
    {
        return $this->cartRepository->getAllItems();
    }

    /**
     * カート内容と価格を計算
     */
    public function calculateCartData($items, array $quantities): array
    {
        $cartItems = [];
        $itemPrices = [];
        $totalPrice = 0;

        foreach ($items as $item) {
            $quantity = (int)($quantities[$item->id] ?? 0);
            $price = $quantity * $item->price;

            $itemPrices[$item->id] = $price;
            $totalPrice += $price;

            if ($quantity > 0) {
                $cartItems[] = [
                    'item_id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $quantity,
                    'unit_price' => $item->price,
                    'price' => $price
                ];
            }
        }

        return [
            'cartItems' => $cartItems,
            'itemPrices' => $itemPrices,
            'totalPrice' => $totalPrice
        ];
    }

    /**
     * カート追加可能かどうかを判定
     */
    public function canAddToCart(int $totalPrice): bool
    {
        return $totalPrice > 0;
    }

    /**
     * カート数量を検証
     */
    public function validateCartQuantities(array $quantities): bool
    {
        return array_sum($quantities) > 0;
    }

    /**
     * 注文を完了
     */
    public function completeOrder(array $customerData, array $shippingData, array $cartItems, bool $sameAsCustomer = false): bool
    {
        try {
            DB::beginTransaction();

            // 顧客情報を保存
            $customer = $this->customerRepository->createCustomer($customerData);

            // 配送先情報を保存
            if ($sameAsCustomer) {
                // 購入者と同じ住所の場合、顧客情報をコピー
                $shippingData = [
                    'shipping_name' => $customerData['name'],
                    'shipping_kana' => $customerData['kana'],
                    'shipping_tel' => $customerData['tel'],
                    'shipping_zip' => $customerData['zip'],
                    'shipping_prefecture' => $customerData['prefecture'],
                    'shipping_city' => $customerData['city'],
                    'shipping_address' => $customerData['address'],
                    'shipping_building' => $customerData['building'] ?? ''
                ];
            }
            $shipping = $this->customerRepository->createShipping($shippingData);

            // 合計金額を計算
            $totalPrice = array_sum(array_column($cartItems, 'price'));

            // カートを作成
            $cart = $this->cartRepository->createCart($customer, $shipping, $totalPrice);

            // カート詳細を作成
            foreach ($cartItems as $item) {
                $this->cartRepository->createCartDetail(
                    $cart,
                    $item['item_id'],
                    $item['quantity'],
                    $item['price']
                );
            }

            // 確認メール送信
            Mail::to($customer->email)->send(new OrderConfirmationMail($customer, $cart, $cartItems));

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order completion failed: ' . $e->getMessage());
            return false;
        }
    }
}
