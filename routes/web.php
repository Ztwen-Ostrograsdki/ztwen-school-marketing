<?php

use App\Livewire\Auth\AssistantRequestedResponsePage;
use App\Livewire\Auth\CreateSchool;
use App\Livewire\Auth\EmailVerificationPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\SubscribePage;
use App\Livewire\Master\AssistantsListing;
use App\Livewire\Master\Dashboard;
use App\Livewire\Master\SchoolProfil;
use App\Livewire\Master\SchoolsListing;
use App\Livewire\Master\SpatieRoleProfilPage;
use App\Livewire\Master\SpatieRolesPage;
use App\Livewire\Master\UsersListing;
use App\Livewire\Pages\AboutUs;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\SchoolsPages;
use App\Livewire\Shop\PackModuleManager;
use App\Livewire\Shop\PackProfil;
use App\Livewire\Shop\PacksPage;
use App\Livewire\User\MyAssistantsListing;
use App\Livewire\User\MyNotifications;
use App\Livewire\User\MyProfil;
use App\Livewire\User\MyReceivedsAssistantRequestsPage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', Home::class)->name('home');


Route::middleware(['auth'])->group(function(){

    // ADMINS ROUTES
    Route::get('administration', Dashboard::class)->name('admin');

    Route::get('administration/les-utilisateurs', UsersListing::class)->name('admin.users.listing');

    Route::get('administration/les-assistants', AssistantsListing::class)->name('admin.assistants.listing');

    Route::get('administration/les-ecoles', SchoolsListing::class)->name('admin.schools.listing');

    Route::get('gestion/role-administrateurs', SpatieRolesPage::class)->name('admin.roles');

    Route::get('gestion/role-administrateurs/ID={role_id}', SpatieRoleProfilPage::class)->name('admin.role.profil');

    Route::get('gestion/packs/k={token}/creation-de-pack', PackModuleManager::class)->name('pack.create');

    Route::get('gestion/packs/k={token}/edition-de-pack/s={pack_slug}/u={pack_uuid}', PackModuleManager::class)->name('pack.update');




    // END ADMINS ROUTES

    Route::get('boutique/u={uuid}/pack={slug}/tok={token}/validation-souscription', SubscribePage::class)->name('subscribe.confirmation');

    Route::get('mon-profil/u={uuid}/edition-profil', RegisterPage::class)->name('user.profil.edition')->middleware(['user.self']);

    Route::get('mon-profil/u={user_uuid}/gestion/creation-ecole', CreateSchool::class)->name('create.school');

    Route::get('mon-profil/u={user_uuid}/s={school_slug}/is={school_id}/edition/edition-de-mon-ecole', CreateSchool::class)->name('school.edition');

    Route::get('profil/k={id}/u={uuid}/mon-profil', MyProfil::class)->name('user.profil');
    
    
    Route::get('profil/k={id}/u={uuid}/mes-notifications', MyNotifications::class)->name('my.notifications');

    Route::get('profil/k={id}/u={uuid}/mes-assistants', MyAssistantsListing::class)->name('my.assistants');

    Route::get('profil/k={id}/u={uuid}/gestion-ecoles/mes-demandes',  MyReceivedsAssistantRequestsPage::class)->name('my.assistants.requests');

    Route::get('/gestion/demande-assistance-gestion-ecole=reponse/v/ru={request_uuid}/au={assistant_uuid}/su={sender_uuid}', AssistantRequestedResponsePage::class)->name('assistant.request.response');

    Route::get('/gestion/demande-assistance-gestion-ecole=reponse/l/ru={request_uuid}/au={assistant_uuid}/su={sender_uuid}/tk={token}', AssistantRequestedResponsePage::class)->name('assistant.request.approved');
});


Route::get('a-propos-de-' . Str::lower(Str::slug(str_replace('@', '', config('app.name')))), AboutUs::class)->name('about.us');

Route::get('ecole/s={slug}/u={uuid}', SchoolProfil::class)->name('school.profil');

Route::get('boutique/packs-disponibles', PacksPage::class)->name('packs.page');

Route::get('ecoles/liste', SchoolsPages::class)->name('schools.page');

Route::get('boutique/u={uuid}/pack={slug}', PackProfil::class)->name('pack.profil');




Route::middleware(['guest'])->group(function(){

    Route::get('inscription', RegisterPage::class)->name('register');

    Route::get('Connexion', LoginPage::class)->name('login');

    Route::get('mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');

    Route::get('/verification-email/r={token}/email={email}/{key?}', EmailVerificationPage::class)->name('email.verification');

    Route::get('/mot-de-passe-oublie', ForgotPasswordPage::class)->name('password.forgot');
    
});

Route::get('/reinitialisation-mot-de-passe/token={token?}/email={email?}', ResetPasswordPage::class)->name('password.reset');

Route::get('/reinitialisation-mot-de-passe/par-email/email={email?}/{key?}', ResetPasswordPage::class)->name('password.reset.by.email');





Route::get('/403', function () {
    abort(403);
})->name('error.403');

Route::get('/419', function () {
    abort(419);
})->name('error.419');

Route::get('/410', function () {
    abort(410);
})->name('error.410');


// Route::get('/profil_photos/{path}', function($path){

//     if(Storage::disk('local')->exists($path)){

//         $full_path = 'profil_photos/' . $path;

//         $file = Storage::disk('local')->get($full_path);

//         $type = Storage::disk('local')->mimeType($full_path);

//         return response($file)->header("Content-Type", $type);

//     }
//     else{

//        return abort(404);
//     }

// })->where('path', '.*')->name('user.profil.photo');


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

