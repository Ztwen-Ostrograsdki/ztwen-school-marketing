<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Models\SubscriptionUpgradeRequest;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToUpgradeSubscription implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $subscriber, public Subscription $subscription, public array $data
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            DB::beginTransaction();

            $ref_code = generateRandomNumber();

            SubscriptionUpgradeRequest::create([
                'unique_price' => $this->data['unique_price'],
                'months' => $this->data['months'],
                'amount' => $this->data['total'],
                'discount' => $this->data['discount'],
                'is_active' => false,
                'user_id' => $this->subscriber->id,
                'subscription_id' => $this->subscription->id,
                'payment_status' => 'En attente',
                'ref_key' => $ref_code,
            ]);

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            $key = $this->subscription->ref_key;

            Notification::sendNow([$this->subscriber], new RealTimeNotification("Le processus de demande de réabonnement de votre souscription {$key} a échoué! Veuillez renseigner " . $th->getMessage()));
            
        }
    }
}
