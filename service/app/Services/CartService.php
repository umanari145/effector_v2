<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Mail;
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
     * カート内容を取得
     */
    public function getCartContents(): array
    {
        $cartItems = $this->cartRepository->getCartItems();
        $totalSum = $this->calculateTotal($cartItems);

        return [
            'items' => $cartItems,
            'total' => $totalSum
        ];
    }

    /**
     * 商品をカートに追加
     */
    public function addProductsToCart(int $bioQuantity, int $sukuaraQuantity): array
    {
        $result = ['success' => true, 'message' => ''];

        // バイオ商品（item_id: 1）
        if ($bioQuantity > 0) {
            if (!$this->cartRepository->addToCart(1, $bioQuantity)) {
                $result['success'] = false;
                $result['message'] = 'バイオ商品の追加に失敗しました。';
                return $result;
            }
        }

        // スクアラミン商品（item_id: 2）
        if ($sukuaraQuantity > 0) {
            if (!$this->cartRepository->addToCart(2, $sukuaraQuantity)) {
                $result['success'] = false;
                $result['message'] = 'スクアラミン商品の追加に失敗しました。';
                return $result;
            }
        }

        if ($bioQuantity <= 0 && $sukuaraQuantity <= 0) {
            $result['success'] = false;
            $result['message'] = '商品数を選択してください。';
        }

        return $result;
    }

    /**
     * 商品IDごとにカートに追加
     */
    public function addProductsToCartByItems(array $itemQuantities): array
    {
        $result = ['success' => true, 'message' => ''];

        foreach ($itemQuantities as $itemId => $quantity) {
            $quantity = (int)$quantity;
            if ($quantity > 0) {
                if (!$this->cartRepository->addToCart($itemId, $quantity)) {
                    $result['success'] = false;
                    $result['message'] = '商品の追加に失敗しました。';
                    return $result;
                }
            }
        }

        $totalQuantity = array_sum($itemQuantities);
        if ($totalQuantity <= 0) {
            $result['success'] = false;
            $result['message'] = '商品数を選択してください。';
        }

        return $result;
    }

    /**
     * 購入金額を計算
     */
    public function calculatePurchaseAmount(int $bioQuantity, int $sukuaraQuantity): array
    {
        $bioPrice = $bioQuantity * 9720;
        $sukuaraPrice = $sukuaraQuantity * 12960;
        $totalPrice = $bioPrice + $sukuaraPrice;

        return [
            'bio_price' => $bioPrice,
            'sukuara_price' => $sukuaraPrice,
            'total_price' => $totalPrice
        ];
    }

    /**
     * 商品IDごとの購入金額を計算
     */
    public function calculatePurchaseAmountByItems(array $itemQuantities): array
    {
        $items = $this->getAllItems();
        $itemPrices = [];
        $totalPrice = 0;

        foreach ($items as $item) {
            $quantity = isset($itemQuantities[$item->id]) ? (int)$itemQuantities[$item->id] : 0;
            $price = $quantity * $item->price;

            if ($quantity > 0) {
                $itemPrices['item_' . $item->id . '_price'] = $price;
                $totalPrice += $price;
            }
        }

        $itemPrices['total_price'] = $totalPrice;
        return $itemPrices;
    }

    /**
     * 注文を完了
     */
    public function completeOrder(array $customerData, array $deliveryData = []): bool
    {
        try {
            // 顧客情報を保存
            $customer = $this->customerRepository->create($customerData, $deliveryData);

            // カート商品を購入済みに更新
            $this->cartRepository->markAsPurchased();

            // 確認メール送信
            Mail::to($customer->email)->send(new OrderConfirmationMail($customer));

            return true;
        } catch (\Exception $e) {
            \Log::error('Order completion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 合計金額を計算
     */
    /**
     * 全商品を取得
     */
    public function getAllItems()
    {
        return $this->cartRepository->getAllItems();
    }

    private function calculateTotal($cartItems): int
    {
        return $cartItems->sum('total');
    }
}
