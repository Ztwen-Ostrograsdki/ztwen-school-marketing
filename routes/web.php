<?php

use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\SubscribePage;
use App\Livewire\Pages\Home;
use App\Livewire\Shop\PackProfil;
use App\Livewire\Shop\PacksPage;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware('guest')->group(function () {
    
    Route::get('inscription', RegisterPage::class)->name('register');

    Route::get('Connexion', LoginPage::class)->name('login');
    Route::get('mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
    Route::get('boutique/packs-disponibles', PacksPage::class)->name('packs.page');
    Route::get('boutique/u={uuid}/pack={slug}', PackProfil::class)->name('pack.profil');
    Route::get('mes-abonnements', SubscribePage::class)->name('my.subscribes');
    // Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

