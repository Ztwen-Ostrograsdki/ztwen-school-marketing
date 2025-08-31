<?php

namespace App\Observers;

use App\Events\NewRequestToUpgradeSubscriptionCreatedEvent;
use App\Events\RequestToUpgradeSubscriptionUpdatedEvent;
use App\Jobs\JobToSendSimpleMailMessageToAdmins;
use App\Models\SubscriptionUpgradeRequest;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;

class ObserveSubscriptionUpgradeRequest
{
    /**
     * Handle the SubscriptionUpgradeRequest "created" event.
     */
    public function created(SubscriptionUpgradeRequest $subscriptionUpgradeRequest): void
    {
        $name = $subscriptionUpgradeRequest->subscription->pack->name;

        Notification::sendNow([$subscriptionUpgradeRequest->user], new RealTimeNotification("Le code à renseigner en référence lors du payement par dépôt afin de valider votre ré-abonnement au pack {$name} est : {$subscriptionUpgradeRequest->ref_key}!"));

        $subscriptionUpgradeRequest->__sendSubcriptionDetailsToSubscriber();

        JobToSendSimpleMailMessageToAdmins::dispatch("L'utilisateur {$subscriptionUpgradeRequest->user->getFullName()} vient de faire une demande de ré-abonnement au pack {$name} pour son école {$subscriptionUpgradeRequest->subscription->school->name}", "REABONNEMENT", null, route('admin.packs.subscriptions.list'));

        broadcast(new NewRequestToUpgradeSubscriptionCreatedEvent($subscriptionUpgradeRequest));
    }

    /**
     * Handle the SubscriptionUpgradeRequest "updated" event.
     */
    public function updated(SubscriptionUpgradeRequest $subscriptionUpgradeRequest): void
    {
        broadcast(new RequestToUpgradeSubscriptionUpdatedEvent($subscriptionUpgradeRequest));
    }

    /**
     * Handle the SubscriptionUpgradeRequest "deleted" event.
     */
    public function deleted(SubscriptionUpgradeRequest $subscriptionUpgradeRequest): void
    {
        broadcast(new RequestToUpgradeSubscriptionUpdatedEvent($subscriptionUpgradeRequest));
    }

    /**
     * Handle the SubscriptionUpgradeRequest "restored" event.
     */
    public function restored(SubscriptionUpgradeRequest $subscriptionUpgradeRequest): void
    {
        //
    }

    /**
     * Handle the SubscriptionUpgradeRequest "force deleted" event.
     */
    public function forceDeleted(SubscriptionUpgradeRequest $subscriptionUpgradeRequest): void
    {
        //
    }
}
