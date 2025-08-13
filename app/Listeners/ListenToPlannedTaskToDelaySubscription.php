<?php

namespace App\Listeners;

use App\Events\PlannedTaskToDelayedSubscriptionEvent;
use App\Jobs\JobToDelayedSubscription;
use App\Models\Subscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToPlannedTaskToDelaySubscription
{
    /**
     * Handle the event.
     */
    public function handle(PlannedTaskToDelayedSubscriptionEvent $event): void
    {
        $jobs = [];

        $subscriptions = Subscription::whereIn('id', $event->subscriptions_id)->get();
        
        foreach($subscriptions as $subscription){

            if($subscription->will_closed_at->isPast()){

                $jobs[] = new JobToDelayedSubscription($subscription, $event->admin_validator);

            }
            else{

                $jobs[] = (new JobToDelayedSubscription($subscription, $event->admin_validator))->delay(Carbon::parse($subscription->will_closed_at)->addHour());

                $subscription->definePlannedTask();
            }

        }

        Bus::batch($jobs)
            ->progress(function(Batch $batch) use ($event){

            })
            ->then(function(Batch $batch) use ($event){

                $message_to_creator = "Les tâches de désactivation des souscriptions expirées ont été plannifiées avec succès!";

                Notification::sendNow([$event->admin_validator], new RealTimeNotification($message_to_creator));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La plannification des tâches de désactivation des souscriptions expirées a échoué";                

                Notification::sendNow([$event->admin_validator], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('subscriptions_tasks_delayed')->dispatch();
    }
}
