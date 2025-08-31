<?php

namespace App\Listeners;

use App\Events\UpgradingSubscriptionEvent;
use App\Jobs\JobToUpgradeSubscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToUpgradeSubscription
{
    /**
     * Handle the event.
     */
    public function handle(UpgradingSubscriptionEvent $event): void
    {
        $batch = Bus::batch([

                new JobToUpgradeSubscription($event->subscriber, $event->subscription, $event->data),

            ])->then(function(Batch $batch) use ($event){

                // $name = $event->pack->name;

                // Notification::sendNow([$event->subscriber], new RealTimeNotification("Le processus d'abonnement au pack {$name} s'est bien déroulé. Veuillez à présent utiliser le code de référence envoyé par mail pour faire le dépôt et pour valider votre abonnement!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use($event){

                $key = $event->subscription->ref_key;

                Notification::sendNow([$event->subscriber], new RealTimeNotification("Le processus de demande de réabonnement de votre souscription {$key} a échoué! Veuillez renseigner"));
                
            })

            ->finally(function(Batch $batch){


        })->name('upgrade_susbcription')->dispatch();
    }
}
