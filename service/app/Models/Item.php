<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    protected $casts = [
        'price' => 'integer'
    ];

    /**
     * カートとの関連
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'item_id', 'id');
    }
}