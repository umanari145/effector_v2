<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '田中太郎',
            'kana' => 'タナカタロウ',
            'tel' => '03-1234-5678',
            'email' => 'tanaka@example.com',
            'zip' => '100-0001',
            'prefecture' => '東京都',
            'city' => '千代田区',
            'address' => '霞が関1-1-1'
        ];
    }
}
