<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware('guest')->group(function () {
    
    Route::get('inscription', RegisterPage::class)->name('register');

    Route::get('Connexion', LoginPage::class)->name('login');
    // Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    // Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

