<?php

namespace App\Jobs;

use App\Helpers\Robots\ModelsRobots;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToDelayedSubscription implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Subscription $subscription, public ?User $admin_validator = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if($this->subscription->is_active && $this->subscription->will_closed_at < now()){

            self::runner();

        }
        else{

            if($this->subscription->hasPlannedDelayedTask()){

                $message = "L'abonnement ref:{$this->subscription->ref_key} du pack {$this->subscription->pack->name} a déjà une tâche de désactivation plannifiée!";

                Notification::sendNow([$this->subscription->user], new RealTimeNotification($message));

                return ;
            }
            else{

                self::runner();
            }
        }
    }


    public function runner()
    {
        $subscription = $this->subscription;

        $admin_validator = $this->admin_validator;
        
        if($subscription->is_active){

            DB::beginTransaction();

            $subscriber = $subscription->subscriber;

            try {

                $subscription_data = [
                    'is_active' => false,
                ];

                $subscription->update($subscription_data);

                DB::commit();

                DB::afterCommit(function() use ($subscription, $subscriber, $admin_validator){

                    $subscription->deletePlannedTask(config('app.subcriptions_task_report'));

                    $message = "Votre abonnement ref:{$subscription->ref_key} du pack {$subscription->pack->name} a expiré. Votre abonnement est à présent inactif!";

                    Notification::sendNow([$subscription->user], new RealTimeNotification($message));

                    $lien = $subscriber->to_subscribes_route();

                    $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

                    JobToSendSimpleMailMessageTo::dispatch($subscriber->email, $greating, $message, "SOUSCRIPTION " . $subscription->ref_key . " EXPIREE - ABONNEMENT DESACTIVE ", null, $lien);

                    $message_to_admins = "L'abonnement ref:{$subscription->ref_key} du pack {$subscription->pack->name} fait par {$subscription->user->getFullName()} a été désactivé avec succès!";

                    if($admin_validator){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message_to_admins));

                    }
                    else{

                        $admins = ModelsRobots::getAllAdmins();

                        if(!empty($admins)){

                            Notification::sendNow($admins, new RealTimeNotification($message_to_admins));
                        }
                    }

                });
                

            } catch (\Throwable $th) {

                DB::rollBack();

                if($admin_validator) : 

                    Notification::sendNow([$admin_validator], new RealTimeNotification("La désactivation de l'abonnement ref:{$subscription->ref_key} du pack {$subscription->pack->name} fait par {$subscription->user->getFullName()} a échoué! : " . $th->getMessage()));

                    return false;

                else :
                    $admins = ModelsRobots::getAllAdmins();

                    if(!empty($admins)){

                        Notification::sendNow($admins, new RealTimeNotification("La désactivation de l'abonnement ref:{$subscription->ref_key} du pack {$subscription->pack->name} fait par {$subscription->user->getFullName()} a échoué! : " . $th->getMessage()));
                    }

                    return false;

                endif;
            }
        }
        else{


        }
    }


    public function middleware() : array
    {
        return [
            Skip::when(!$this->subscription->exists),
            Skip::when($this->subscription->is_active && $this->subscription->will_closed_at > now() && $this->subscription->hasPlannedDelayedTask()),
        ];
    }
}
