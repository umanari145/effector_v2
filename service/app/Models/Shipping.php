<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_name',
        'shipping_kana',
        'shipping_tel',
        'shipping_zip',
        'shipping_prefecture',
        'shipping_city',
        'shipping_address',
        'shipping_building'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
