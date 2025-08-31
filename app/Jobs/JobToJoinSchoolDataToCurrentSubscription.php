<?php

namespace App\Jobs;

use App\Models\Subscription;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToJoinSchoolDataToCurrentSubscription implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Subscription $subscription, 
        public ?User $user
        )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            //code...

            $subscription = $this->subscription;

            $school = $subscription->school;

            $images = $school->images()->update(['subscription_id' => $subscription->id]);

            $videos = $school->videos()->update(['subscription_id' => $subscription->id]);

            $stats = $school->stats()->update(['subscription_id' => $subscription->id]);

            $infos = $school->infos()->update(['subscription_id' => $subscription->id]);

            $assistants = $school->assistant_requests()->update(['subscription_id' => $subscription->id]);

            DB::commit();

            DB::afterCommit(function(){

                $message = "Les données de votre école ont été liées à votre nouvel abonnement (# " . $this->subscription->ref_key . ") avec succès!";

                Notification::sendNow([$this->subscription->subscriber], new RealTimeNotification($message));

            });
            
        } catch (\Throwable $th) {

            DB::rollback();
            //throw $th;
        }
    }
}
