<?php

namespace App\Listeners;

use App\Events\InitProcessToDeleteSpatieRolesEvent;
use App\Events\RolePermissionsWasUpdatedEvent;
use App\Events\RolesWasUpdatedEvent;
use App\Jobs\JobToDeleteSpatieRoles;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToDeleteSpatieRoles
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToDeleteSpatieRolesEvent $event): void
    {
        $batch = Bus::batch([

                new JobToDeleteSpatieRoles($event->roles_id, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La suppression des rôles administrateurs s'est déroulée avec succès!"));

                RolesWasUpdatedEvent::dispatch();

                RolePermissionsWasUpdatedEvent::dispatch();
            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La suppression des rôles administrateurs a échoué! Veuillez renseigner"));

                
            })

            ->finally(function(Batch $batch){


        })->name('roles_destroyer')->dispatch();
    }
}
