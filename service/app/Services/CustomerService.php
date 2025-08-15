<?php

namespace App\Services;

class CustomerService
{
    /**
     * 都道府県一覧を取得
     */
    public function getPrefectures(): array
    {
        return [
            '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
            '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
            '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
            '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
            '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
            '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
            '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
        ];
    }

    /**
     * 顧客情報配列を準備
     */
    public function prepareCustomerData(array $data): array
    {
        return [
            'name' => $data['name'],
            'kana' => $data['kana'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'zip' => $data['zip'],
            'prefecture' => $data['prefecture'],
            'city' => $data['city'],
            'address' => $data['address'],
            'building' => $data['building'] ?? ''
        ];
    }

    /**
     * 配送先情報配列を準備
     */
    public function prepareShippingData(array $data): array
    {
        return [
            'shipping_name' => $data['shipping_name'] ?? '',
            'shipping_kana' => $data['shipping_kana'] ?? '',
            'shipping_tel' => $data['shipping_tel'] ?? '',
            'shipping_zip' => $data['shipping_zip'] ?? '',
            'shipping_prefecture' => $data['shipping_prefecture'] ?? '',
            'shipping_city' => $data['shipping_city'] ?? '',
            'shipping_address' => $data['shipping_address'] ?? '',
            'shipping_building' => $data['shipping_building'] ?? ''
        ];
    }

    /**
     * 配送先を顧客情報と同じに設定
     */
    public function copyCustomerToShipping(array $customerData): array
    {
        return [
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

    /**
     * セッションデータから顧客情報を復元
     */
    public function restoreCustomerFromSession(array $sessionData): array
    {
        return [
            'name' => $sessionData['name'] ?? '',
            'kana' => $sessionData['kana'] ?? '',
            'email' => $sessionData['email'] ?? '',
            'tel' => $sessionData['tel'] ?? '',
            'zip' => $sessionData['zip'] ?? '',
            'prefecture' => $sessionData['prefecture'] ?? '',
            'city' => $sessionData['city'] ?? '',
            'address' => $sessionData['address'] ?? '',
            'building' => $sessionData['building'] ?? ''
        ];
    }

    /**
     * セッションデータから配送先情報を復元
     */
    public function restoreShippingFromSession(array $sessionData): array
    {
        return [
            'same_as_customer' => $sessionData['same_as_customer'] ?? false,
            'shipping_name' => $sessionData['shipping_name'] ?? '',
            'shipping_kana' => $sessionData['shipping_kana'] ?? '',
            'shipping_tel' => $sessionData['shipping_tel'] ?? '',
            'shipping_zip' => $sessionData['shipping_zip'] ?? '',
            'shipping_prefecture' => $sessionData['shipping_prefecture'] ?? '',
            'shipping_city' => $sessionData['shipping_city'] ?? '',
            'shipping_address' => $sessionData['shipping_address'] ?? '',
            'shipping_building' => $sessionData['shipping_building'] ?? ''
        ];
    }
}