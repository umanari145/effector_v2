<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'num',
        'flg',
        'buy_time'
    ];

    protected $casts = [
        'buy_time' => 'datetime',
        'flg' => 'boolean'
    ];

    /**
     * 商品との関連
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     * カート内の商品を取得
     */
    public function scopeInCart($query)
    {
        return $query->where('flg', false);
    }

    /**
     * 購入済みの商品を取得
     */
    public function scopePurchased($query)
    {
        return $query->where('flg', true);
    }

    /**
     * 最新の買い物カートを取得
     */
    public function scopeLatestCart($query)
    {
        $latestBuyTime = self::max('buy_time');
        return $query->where('buy_time', $latestBuyTime);
    }
}