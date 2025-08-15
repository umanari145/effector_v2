<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Item;
use App\Models\Customer;
use App\Models\Shipping;

class CartRepository
{
    /**
     * 全商品を取得
     */
    public function getAllItems()
    {
        return Item::all();
    }

    /**
     * カートを作成
     */
    public function createCart(Customer $customer, Shipping $shipping, int $totalPrice): Cart
    {
        return Cart::create([
            'customer_id' => $customer->id,
            'shipping_id' => $shipping->id,
            'total_price' => $totalPrice
        ]);
    }

    /**
     * カート詳細を作成
     */
    public function createCartDetail(Cart $cart, int $itemId, int $quantity, int $price): CartDetail
    {
        return CartDetail::create([
            'cart_id' => $cart->id,
            'item_id' => $itemId,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }
}
