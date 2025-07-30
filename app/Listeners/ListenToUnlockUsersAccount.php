<?php

namespace App\Listeners;

use App\Events\InitProcessToUnlockUsersAccountEvent;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Jobs\JobToUnlockUserAccount;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToUnlockUsersAccount
{
    /**
     * Handle the event.
     */
    public function handle(InitProcessToUnlockUsersAccountEvent $event): void
    {
        $jobs = [];

        $users = [];

        $users_targets_ids = $event->users_targets_ids;

       
        if(!empty($users_targets_ids)){

            $users = User::whereIn('id', $users_targets_ids)->get();

            if(count($users) > 0){

                foreach($users as $user){

                    $jobs[] = new JobToUnlockUserAccount($user, $event->delay);

                }

            }
        }
        elseif($event->just_unblock_all_users_acounts){

            $users = User::where('blocked', true)->get();
    
            if(count($users) > 0){

                foreach($users as $user){

                    if($user){

                        $jobs[] = new JobToUnlockUserAccount($user, $event->delay);
                    }

                }

            }
        }

        if(empty($jobs)){

            $message = "Le processus de déblocage des comptes a été avorté car aucun compte bloqué n'a été trouvé afin d'éxécuter un déblocage!";
                        
            Notification::sendNow([$event->admin_generator], new RealTimeNotification($message));

        }
        else{
            $batch = Bus::batch($jobs)
                ->then(function(Batch $batch) use ($event, $users){

                    if(count($users)){
                        
                        $message = "Les comptes ont été débloqués avec succès!";
                            
                        Notification::sendNow([$event->admin_generator], new RealTimeNotification("Le processus est terminé: " . $message));

                    }
                })
                ->catch(function(Batch $batch, Throwable $er) use ($event){

                    $message = "Le processus de déblocage de compte lancé à échoué!";
                            
                    Notification::sendNow([$event->admin_generator], new RealTimeNotification($message));
                    
                })

                ->finally(function(Batch $batch){

                    
                }

            )->name('users_unlocking')->dispatch();

        }
    }
}
