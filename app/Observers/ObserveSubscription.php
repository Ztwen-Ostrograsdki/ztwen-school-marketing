<?php

namespace App\Observers;

use App\Events\NewPackSubscriptionCreatedEvent;
use App\Events\PackSubscriptionWasUpdatedEvent;
use App\Jobs\JobToSendSimpleMailMessageToAdmins;
use App\Models\Subscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;

class ObserveSubscription
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        $name = $subscription->pack->name;

        Notification::sendNow([$subscription->user], new RealTimeNotification("Le code à renseigner en référence lors du payement par dépôt afin de valider votre abonnement au pack {$name} est : {$subscription->ref_key}!"));

        $subscription->__sendSubcriptionDetailsToSubscriber();

        JobToSendSimpleMailMessageToAdmins::dispatch("L'utilisateur {$subscription->user->getFullName()} vient de faire une nouvelle demande de souscription ou abonnement pour le pack {$name}  pour son école {$subscription->school->name}", "Nouvelle Souscription - Abonnement", null, route('admin.packs.subscriptions.list'));


        broadcast(new NewPackSubscriptionCreatedEvent($subscription));
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        broadcast(new PackSubscriptionWasUpdatedEvent($subscription));
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleting(Subscription $subscription): void
    {
        broadcast(new PackSubscriptionWasUpdatedEvent($subscription));
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }

    
}
