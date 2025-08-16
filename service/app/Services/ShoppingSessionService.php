<?php

namespace App\Services;

class ShoppingSessionService
{
    /**
     * カート数量をセッションから取得
     */
    public function getCartQuantities(): array
    {
        return session()->get('cart_quantities', []);
    }

    /**
     * カート数量をセッションに保存
     */
    public function saveCartQuantities(array $quantities): void
    {
        session()->put('cart_quantities', $quantities);
    }

    /**
     * 顧客情報をセッションから取得
     */
    public function getCustomerInfo(): array
    {
        return session()->get('customer_info', []);
    }

    /**
     * 顧客情報をセッションに保存
     */
    public function saveCustomerInfo(array $customerInfo): void
    {
        session()->put('customer_info', $customerInfo);
    }

    /**
     * 配送先情報をセッションから取得
     */
    public function getShippingInfo(): array
    {
        return session()->get('shipping_info', []);
    }

    /**
     * 配送先情報をセッションに保存
     */
    public function saveShippingInfo(array $shippingInfo): void
    {
        session()->put('shipping_info', $shippingInfo);
    }

    /**
     * ショッピング関連のセッションをクリア
     */
    public function clearShoppingSession(): void
    {
        session()->forget(['cart_quantities', 'customer_info', 'shipping_info']);
    }

    /**
     * カートが空かどうかをチェック
     */
    public function isCartEmpty(): bool
    {
        $quantities = $this->getCartQuantities();
        return empty($quantities) || array_sum($quantities) === 0;
    }
}
