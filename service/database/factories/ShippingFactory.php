<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping>
 */
class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shipping_name' => '佐藤花子',
            'shipping_kana' => 'サトウハナコ',
            'shipping_tel' => '06-9876-5432',
            'shipping_zip' => '530-0001',
            'shipping_prefecture' => '大阪府',
            'shipping_city' => '大阪市北区',
            'shipping_address' => '梅田1-1-1'
        ];
    }
}
