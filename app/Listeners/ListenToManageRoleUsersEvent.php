<?php

namespace App\Listeners;

use App\Events\InitProcessToManageRoleUsersEvent;
use App\Events\RolesWasUpdatedEvent;
use App\Jobs\JobToManageRoleUsers;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToManageRoleUsersEvent
{

    /**
     * Handle the event.
     */
    public function handle(InitProcessToManageRoleUsersEvent $event): void
    {
        $batch = Bus::batch([

                new JobToManageRoleUsers($event->role, $event->users_id, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                $role_name = __translateRoleName($event->role->name);

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La mise à jour des utilisateurs du rôle {$role_name} s'est déroulée avec succès!"));

                RolesWasUpdatedEvent::dispatch();
            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                $role_name = __translateRoleName($event->role->name);

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La mise à jour des utilisateurs du rôle {$role_name} a échoué! Veuillez renseigner"));

                
            })

            ->finally(function(Batch $batch){


        })->name('role_users_managing')->dispatch();
    }
}
