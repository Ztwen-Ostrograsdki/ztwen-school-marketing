<?php

namespace App\Listeners;

use App\Events\InitProcessToDeleteUserAccountEvent;
use App\Events\LogoutUserEvent;
use App\Events\UserAccountWasDeletedEvent;
use App\Jobs\JobToDeleteUserAccount;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToDeleteUserAccount
{
    /**
     * Handle the event.
     */
    public function handle(InitProcessToDeleteUserAccountEvent $event): void
    {
        $jobs = [];

        $users = User::whereIn('users.id', $event->users_id)->get();
        
        foreach($users as $user){

            $jobs[] = new JobToDeleteUserAccount($event->admin_generator, $user);

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "La suppression de comptes lancé s'est achevée!";

                UserAccountWasDeletedEvent::dispatch($event->admin_generator, $message_to_creator);

                Notification::sendNow([$event->admin_generator], new RealTimeNotification($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La suppression de compte de membres en masse a échoué";                

                Notification::sendNow([$event->admin_generator], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('users_account_deletion_process')->dispatch();
    
    }
}
