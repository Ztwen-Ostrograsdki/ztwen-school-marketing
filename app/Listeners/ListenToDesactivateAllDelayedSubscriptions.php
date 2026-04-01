<?php

namespace App\Listeners;

use App\Events\DelayedSubscriptionsWasDisabledEvent;
use App\Events\InitProcessToDesactivateAllDelayedSubscriptionsEvent;
use App\Jobs\JobToDesactivateDelayedSubscriptions;
use App\Models\Subscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToDesactivateAllDelayedSubscriptions
{
   
    /**
     * Handle the event.
     */
    public function handle(InitProcessToDesactivateAllDelayedSubscriptionsEvent $event): void
    {
        $jobs = [];

        $delayeds = Subscription::whereNotNull('validate_at')->where('will_closed_at', '<', now())->where('expired', false)->get();
        
        foreach($delayeds as $subscription){

            if($subscription->hasPlannedDelayedTask() && ($subscription->is_active || !$subscription->expired) ){

                $subscription->deletePlannedTask();
                
            }

            $jobs[] = new JobToDesactivateDelayedSubscriptions($subscription, $event->admin_validator);

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "La désactivation des souscriptions expirées a été lancée avec succès!";

                Notification::sendNow([$event->admin_validator], new RealTimeNotification($message_to_creator));

                DelayedSubscriptionsWasDisabledEvent::dispatch($event->admin_validator);

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La désactivation des souscriptions expirées a échoué";                

                Notification::sendNow([$event->admin_validator], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('subscriptions_delayed_desactivation')->dispatch();
    }
    
}
