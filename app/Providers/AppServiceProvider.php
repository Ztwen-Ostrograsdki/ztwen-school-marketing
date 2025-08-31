<?php

namespace App\Providers;

use App\Helpers\Services\SubscriptionsDelayedService;
use App\Helpers\Services\VisitorsRegisterService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/robots_functions/robots.php');

        Gate::define('is_self_user', function($auth, $user_id){

            return $user_id == $auth->id;
        });

        // Enregistrement des visiteurs
        VisitorsRegisterService::visitorRegistorManager();

        //Désactivation des souscriptions expirées active_upgrading_request

        SubscriptionsDelayedService::runner();
    }
}
