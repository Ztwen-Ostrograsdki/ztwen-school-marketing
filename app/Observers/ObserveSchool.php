<?php

namespace App\Observers;

use App\Events\NewSchoolCreatedEvent;
use App\Events\SchoolDataUpdatedEvent;
use App\Helpers\Robots\ModelsRobots;
use App\Models\School;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ObserveSchool
{

    public function creating(School $school): void
    {
        $school->uuid = Str::uuid();

        $school->is_active = false;

        $school->likes = generateRandomNumber(2);

        $school->slug = Str::slug($school->name) . '-' . generateRandomNumber();
    }
    /**
     * Handle the School "created" event.
     */
    public function created(School $school): void
    {
        NewSchoolCreatedEvent::dispatch($school);

        $admins = ModelsRobots::getUserAdmins();

        if(!empty($admins)){

            $msg_to_admins = "Une nouvelle école du nom " . $school->name . " a été créée! Veuillez proccéder à la validation de son profil afin que cette école soit visible sur la plateforme";

            if($school->user_id && findUser($school->user_id)){

                $user = findUser($school->user_id);

                $msg_to_admins = "Une nouvelle école du nom " . $school->name . " a été créée par un utilisateur dont le nom et l'adresse mail sont " . $user->getFullName() . ' (' . $user->email . '). Veuillez proccéder à la validation de son profil afin que cette école soit visible sur la plateforme';
            }

            Notification::sendNow($admins, new RealTimeNotification($msg_to_admins));

            
        }

        if($school->user){

            $msg = "Votre école " . $school->name . " a été créée avec succès! Vous pouvez assurer sa gestion à votre guise! Elle sera visible par les autres que lorsque vous aurez fait un abonnement! Parcourer, les packs pour choisir un abonnement";

            Notification::sendNow([$school->user], new RealTimeNotification($msg));
        }
    }

    /**
     * Handle the School "updated" event.
     */
    public function updated(School $school): void
    {
        broadcast(new SchoolDataUpdatedEvent());
        
        $admins = ModelsRobots::getUserAdmins(false);

        if(count($admins) > 0){

            $msg_to_admins = "Des données de l'école " . $school->name . " ont été mises à jour!";

            Notification::sendNow($admins, new RealTimeNotification($msg_to_admins));
        }

    }

    /**
     * Handle the School "deleting" event.
     */
    public function deleting(School $school): void
    {
        broadcast(new SchoolDataUpdatedEvent());

        $admins = ModelsRobots::getUserAdmins(false);

        if(!empty($admins)){

            $msg_to_admins = "L'école " . $school->name . " a été supprimée!";

            if($school->user_id && findUser($school->user_id)){

                $user = findUser($school->user_id);

                $msg_to_admins = "L'école " . $school->name . " créée par l'utilisateur dont le nom et l'adresse mail sont " . $user->getFullName() . ' (' . $user->email . ') a été supprimée';
            }

            Notification::sendNow($admins, new RealTimeNotification($msg_to_admins));
            
        }
    }

    /**
     * Handle the School "restored" event.
     */
    public function restored(School $school): void
    {
        //
    }

    /**
     * Handle the School "force deleted" event.
     */
    public function forceDeleted(School $school): void
    {
        //
    }
}
