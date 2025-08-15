<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'id' => 1,
                'name' => 'スーパーバイオ21',
                'price' => 9720,
                'description' => 'スーパーバイオ21 - 自然の力を活用した健康補助食品です。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'スクアラミンプルミエ',
                'price' => 12960,
                'description' => 'スクアラミン - 自然由来の成分を配合した健康補助食品です。',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['id' => $item['id']],
                $item
            );
        }
    }
}
