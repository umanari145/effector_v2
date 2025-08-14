<?php

use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Home;
use App\Livewire\DynamicContents;

# 静的サイト
Route::get('/', Home::class)->name('home');
Route::get('/about', DynamicContents::class)->name('about');
Route::get('/company', DynamicContents::class)->name('company');
Route::get('/contact', [ContactFormController::class, 'index'])->name('contact.form');
Route::post('/contact/confirm', [ContactFormController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/complete', [ContactFormController::class, 'complete'])->name('contact.complete');

Route::get('/natural-structure', DynamicContents::class)->name('natural-structure');
Route::get('/fermented-foods', DynamicContents::class)->name('fermented-foods');
Route::get('/natural-power', DynamicContents::class)->name('natural-power');
Route::get('/plant-power', DynamicContents::class)->name('plant-power');
Route::get('/bio', DynamicContents::class)->name('bio');
Route::get('/sukuaramin', DynamicContents::class)->name('sukuaramin');
Route::get('/qa', DynamicContents::class)->name('qa');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
