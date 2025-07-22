<?php

namespace App\Jobs;

use App\Helpers\Robots\ModelsRobots;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class JobToNotifyAdminsThatBlockedUserTryingToLogin implements ShouldQueue
{
    use Queueable, Batchable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        $since = __formatDateTime($user->blocked_at);

        $user = $this->user;

        $title = "Tentative de connexion.";

        $object = "Compte bloqué.";

        $content = "L'utilisateur " 
                   . $user->getFullName(true) . 
                   " a tenté de se connecter a son compte. Le compte de cet utilisateur dont l'adresse mail est " 
                   . $user->email . " a été bloqué depuis le " . $since ;
        
        ModelsRobots::notificationThatBlockedUserTriedToLogin($user, $title, $object, $content); //BY EMAIL

        $admins = ModelsRobots::getAllAdmins();

        Notification::sendNow($admins, new RealTimeNotification($content));
    }
}
