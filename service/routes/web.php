<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Company;
use App\Livewire\Bio;
use App\Livewire\Contact;
use App\Livewire\DynamicContents;

# 静的サイト
Route::get('/', Home::class)->name('home');
Route::get('/about', DynamicContents::class)->name('about');
Route::get('/company', DynamicContents::class)->name('company');
Route::get('/contact', Contact::class)->name('contact');

Route::get('/health-mechanism', DynamicContents::class)->name('health.mechanism');
Route::get('/fermentation', DynamicContents::class)->name('fermentation');
Route::get('/natural-power', DynamicContents::class)->name('natural.power');
Route::get('/plant-power', DynamicContents::class)->name('plant.power');
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
