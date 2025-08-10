<?php

namespace App\Listeners;

use App\Events\InitNewPackSubscriptionEvent;
use App\Events\NewPackSubscriptionCreatedEvent;
use App\Jobs\JobToCreateOrUpdatePackSubscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToCreateOrUpdatePackSubscription
{
   
    /**
     * Handle the event.
     */
    public function handle(InitNewPackSubscriptionEvent $event): void
    {
        $batch = Bus::batch([

                new JobToCreateOrUpdatePackSubscription($event->subscriber, $event->school, $event->pack, $event->data),

            ])->then(function(Batch $batch) use ($event){

                // $name = $event->pack->name;

                // Notification::sendNow([$event->subscriber], new RealTimeNotification("Le processus d'abonnement au pack {$name} s'est bien déroulé. Veuillez à présent utiliser le code de référence envoyé par mail pour faire le dépôt et pour valider votre abonnement!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                $name = $event->pack->name;

                Notification::sendNow([$event->subscriber], new RealTimeNotification("Le processus d'abonnement au pack {$name} a échoué! Veuillez renseigner"));
                
            })

            ->finally(function(Batch $batch){


        })->name('subscribe_manage')->dispatch();
    }
}
