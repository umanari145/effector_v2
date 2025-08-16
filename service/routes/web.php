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

Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.form');
Route::post('/contact/confirm', [ContactFormController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/complete', [ContactFormController::class, 'complete'])->name('contact.complete');


Route::get('/shopping/cart', function () {
    return view('shopping.cart');
})->name('shopping.cart');

Route::get('/shopping/customer', function () {
    return view('shopping.customer');
})->name('shopping.customer');

Route::get('/shopping/order', function () {
    return view('shopping.order');
})->name('shopping.order');


/*Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});*/

require __DIR__.'/auth.php';
