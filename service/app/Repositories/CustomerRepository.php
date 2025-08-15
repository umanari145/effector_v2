<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Shipping;

class CustomerRepository
{
    /**
     * 顧客情報を保存
     */
    public function createCustomer(array $customerData): Customer
    {
        return Customer::create([
            'name' => $customerData['name'],
            'kana' => $customerData['kana'],
            'tel' => $customerData['tel'],
            'email' => $customerData['email'],
            'zip' => $customerData['zip'],
            'prefecture' => $customerData['prefecture'],
            'city' => $customerData['city'],
            'address' => $customerData['address'],
            'building' => $customerData['building'] ?? ''
        ]);
    }

    /**
     * 配送先情報を保存
     */
    public function createShipping(array $shippingData): Shipping
    {
        return Shipping::create([
            'shipping_name' => $shippingData['shipping_name'],
            'shipping_kana' => $shippingData['shipping_kana'],
            'shipping_tel' => $shippingData['shipping_tel'],
            'shipping_zip' => $shippingData['shipping_zip'],
            'shipping_prefecture' => $shippingData['shipping_prefecture'],
            'shipping_city' => $shippingData['shipping_city'],
            'shipping_address' => $shippingData['shipping_address'],
            'shipping_building' => $shippingData['shipping_building'] ?? ''
        ]);
    }
}