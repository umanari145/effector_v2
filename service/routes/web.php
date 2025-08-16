<?php

use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;

# 静的サイト
Route::view('/', 'static.home')->name('home');
Route::view('/company', 'static.company')->name('company');
Route::view('/about', 'static.about')->name('about');

Route::view('/natural-structure', 'static.natural-structure')->name('natural-structure');
Route::view('/fermented-foods', 'static.fermented-foods')->name('fermented-foods');
Route::view('/natural-power', 'static.natural-power')->name('natural-power');
Route::view('/plant-power', 'static.plant-power')->name('plant-power');
Route::view('/bio', 'static.bio')->name('bio');
Route::view('/sukuaramin', 'static.sukuaramin')->name('sukuaramin');
Route::view('/qa', 'static.qa')->name('qa');

// お問い合わせフォームのルートをグループ化
Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
    Route::get('/', [ContactFormController::class, 'index'])->name('form');
    Route::post('/confirm', [ContactFormController::class, 'confirm'])->name('confirm');
    Route::post('/complete', [ContactFormController::class, 'complete'])->name('complete');
});

// ショッピング関連のルートをグループ化
Route::group(['prefix' => 'shopping', 'as' => 'shopping.'], function () {
    Route::get('/cart', function () {
        return view('shopping.cart');
    })->name('cart');

    Route::get('/customer', function () {
        return view('shopping.customer');
    })->name('customer');

    Route::get('/order', function () {
        return view('shopping.order');
    })->name('order');

    Route::get('/complete', function () {
        return view('shopping.complete');
    })->name('complete');
});

require __DIR__.'/auth.php';
