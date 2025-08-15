<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'shipping_id',
        'total_price'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 顧客との関連
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * 配送先との関連
     */
    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    /**
     * カート詳細との関連
     */
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }
}