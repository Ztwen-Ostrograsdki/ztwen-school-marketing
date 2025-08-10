<?php

namespace App\Jobs;

use App\Models\Pack;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToCreateOrUpdatePackSubscription implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $subscriber, public School $school, public Pack $pack, public ?array $data = [])
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

            Subscription::create([
                'unique_price' => $this->data['unique_price'],
                'months' => $this->data['months'],
                'privileges' => $this->pack->privileges,
                'max_images' => $this->pack->max_images,
                'max_stats' => $this->pack->max_stats,
                'max_infos' => $this->pack->max_infos,
                'max_assistants' => $this->pack->max_assistants,
                'on_page' => $this->pack->on_page,
                'amount' => $this->data['total'],
                'notify_by_email' => $this->pack->notify_by_email,
                'notify_by_sms' => $this->pack->notify_by_sms,
                'discount' => $this->data['discount'],
                'promoting' => $this->pack->promoting,
                'is_active' => false,
                'user_id' => $this->subscriber->id,
                'school_id' => $this->school->id,
                'pack_id' => $this->pack->id,
                'payment_status' => 'En attente',
                'ref_key' => $ref_code,
            ]);

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            $name = $this->pack->name;

            Notification::sendNow([$this->subscriber], new RealTimeNotification("Le processus d'abonnement au pack {$name} a échoué! Veuillez renseigner"));
            
        }
    }

}
