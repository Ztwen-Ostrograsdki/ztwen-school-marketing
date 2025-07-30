<?php

namespace App\Listeners;

use App\Events\InitProcessToManageRolePermissionsEvent;
use App\Events\RolePermissionsWasUpdatedEvent;
use App\Jobs\JobToManageRolePermissions;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToManageSpatieRolePermissions
{
   
    /**
     * Handle the event.
     */
    public function handle(InitProcessToManageRolePermissionsEvent $event): void
    {
        
        $batch = Bus::batch([

                new JobToManageRolePermissions($event->role, $event->permissions_id, $event->admin_generator),

            ])->then(function(Batch $batch) use ($event){

                $role_name = __translateRoleName($event->role->name);

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La mise à jour des privilèges du rôle {$role_name} s'est déroulée avec succès!"));

                RolePermissionsWasUpdatedEvent::dispatch();
            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                $role_name = __translateRoleName($event->role->name);

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La mise à jour des privilèges du rôle {$role_name} a échoué! Veuillez renseigner"));

                
            })

            ->finally(function(Batch $batch){


        })->name('role_permissions_managing')->dispatch();
    }
}
