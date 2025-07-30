<?php

namespace App\Listeners;

use App\Events\InitProcessToBlockUserAccountEvent;
use App\Events\LogoutUserEvent;
use App\Events\UserAccountWasBlockedEvent;
use App\Jobs\JobToBlockUserAccount;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToBlockUserAccount
{
   
    /**
     * Handle the event.
     */
    public function handle(InitProcessToBlockUserAccountEvent $event): void
    {
        $jobs = [];

        $users = [];

        $users_targets_ids = $event->users_targets_ids;

        if($event->user && empty($users_targets_ids)){

            $jobs[] = new JobToBlockUserAccount($event->user);

        }
        if(!empty($users_targets_ids)){

            $users = User::whereIn('id', $users_targets_ids)->get();

            if(count($users) > 0){

                foreach($users as $user){

                    $jobs[] = new JobToBlockUserAccount($user, true);

                }

            }
        }
        elseif($event->just_block_all_users){

            $users = User::where('blocked', false)->get();
    
            if(count($users) > 0){

                foreach($users as $user){

                    if($user && !$user->isMaster()){

                        $jobs[] = new JobToBlockUserAccount($user, true);
                    }

                }

            }
        }


        $batch = Bus::batch($jobs)
            ->then(function(Batch $batch) use ($event, $users_targets_ids, $users){

                if($event->user && empty($users_targets_ids)){

                    LogoutUserEvent::dispatch($event->user);

                    UserAccountWasBlockedEvent::dispatch($event->user);

                    $message = "Le compte de l'utilisateur " . $event->user->getFullName() . " a été bloqué avec succès!";
                    
                    Notification::sendNow([$event->admin_generator], new RealTimeNotification("Le processus est terminé: " . $message));

                }
                if(count($users)){

                    foreach($users as $u){

                        LogoutUserEvent::dispatch($u);

                        UserAccountWasBlockedEvent::dispatch($u);

                        $message = "Le compte de l'utilisateur " . $u->getFullName() . " a été bloqué avec succès!";
                        
                        Notification::sendNow([$event->admin_generator], new RealTimeNotification("Le processus est terminé: " . $message));

                    }

                }
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message = "Le processus de blocage de compte lancé à échoué!";
                        
                Notification::sendNow([$event->admin_generator], new RealTimeNotification($message));
                
            })

            ->finally(function(Batch $batch){


        })->name('users_blocking')->dispatch();
    }
}
