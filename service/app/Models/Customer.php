<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'zip',
        'address',
        'name_send',
        'kana_send',
        'zip_send',
        'address_send',
        'buy_time'
    ];

    protected $casts = [
        'buy_time' => 'datetime'
    ];
}
