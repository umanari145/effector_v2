<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'item_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'buy_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * カートとの関連
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * 商品との関連
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
