<?php

use App\Livewire\Auth\CreateSchool;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\SubscribePage;
use App\Livewire\Master\AssistantsListing;
use App\Livewire\Master\Dashboard;
use App\Livewire\Master\SchoolProfil;
use App\Livewire\Master\SchoolsListing;
use App\Livewire\Master\UsersListing;
use App\Livewire\Pages\AboutUs;
use App\Livewire\Pages\Home;
use App\Livewire\Shop\PackProfil;
use App\Livewire\Shop\PacksPage;
use App\Livewire\User\MyAssistantsListing;
use App\Livewire\User\MyProfil;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', Home::class)->name('home');

// Route::middleware('guest')->group(function () {
    
    
// });

Route::get('a-propos-de-' . Str::lower(Str::slug(str_replace('@', '', config('app.name')))), AboutUs::class)->name('about.us');

Route::get('inscription', RegisterPage::class)->name('register');

Route::get('administration', Dashboard::class)->name('admin');
Route::get('administration/les-utilisateurs', UsersListing::class)->name('admin.users.listing');
Route::get('administration/les-assistants', AssistantsListing::class)->name('admin.assistants.listing');
Route::get('administration/les-ecoles', SchoolsListing::class)->name('admin.schools.listing');
Route::get('ecole/u={uuid}', SchoolProfil::class)->name('school.profil');

Route::get('Connexion', LoginPage::class)->name('login');
Route::get('mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
Route::get('boutique/packs-disponibles', PacksPage::class)->name('packs.page');
Route::get('boutique/u={uuid}/pack={slug}', PackProfil::class)->name('pack.profil');
Route::get('boutique/u={uuid}/pack={slug}/tok={token}/validation-souscription', SubscribePage::class)->name('subscribe.confirmation');

Route::get('profil/u={uuid}/ajout-nouvelle-ecole', CreateSchool::class)->name('create.school');
Route::get('profil/q={uuid}/mon-profil', MyProfil::class)->name('user.profil');

Route::get('profil/u={uuid}/mes-assistants', MyAssistantsListing::class)->name('my.assistants');

// Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');


Route::get('/403', function () {
    abort(403);
})->name('error.403');

Route::get('/419', function () {
    abort(419);
})->name('error.419');

Route::get('/410', function () {
    abort(410);
})->name('error.410');


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

