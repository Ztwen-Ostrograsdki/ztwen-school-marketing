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

class JobToGiveFreeSubscription implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $receiver, public School $school, public Pack $pack, public User $admin_validator, public ?array $data = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        self::runJob();
    }


    public function runJob(): void
    {
        $data = $this->data;

        $name = $this->pack->name;

        $receiver_name = $this->receiver->getFullName();

        $school_name = $this->school->name;

        try {

            DB::beginTransaction();

            $ref_code = generateRandomNumber();


            Subscription::create([
                'unique_price' => $this->pack->price,
                'months' => $data['months'],
                'validate_at' => now(),
                'will_closed_at' => $data['will_closed_at'],
                'duration' => $data['duration'],
                'privileges' => $this->pack->privileges,
                'max_images' => $this->pack->max_images,
                'max_stats' => $this->pack->max_stats,
                'max_infos' => $this->pack->max_infos,
                'max_bests' => $this->pack->max_bests,
                'max_assistants' => $this->pack->max_assistants,
                'on_page' => $this->pack->on_page,
                'amount' => null,
                'notify_by_email' => $this->pack->notify_by_email,
                'notify_by_sms' => $this->pack->notify_by_sms,
                'discount' => null,
                'promoting' => $this->pack->promoting,
                'is_active' => true,
                'is_free' => true,
                'user_id' => $this->receiver->id,
                'school_id' => $this->school->id,
                'pack_id' => $this->pack->id,
                'payment_status' => 'Payé',
                'ref_key' => $ref_code,
            ]);

            DB::commit();

            DB::afterCommit(function() use ($name, $receiver_name, $school_name){

                Notification::sendNow([$this->admin_validator], new RealTimeNotification("Le processus d'attribution d'un pack {$name} à l'utilisateur {$receiver_name} pour son école {$school_name} s'est bien déroulé!"));

            });

        } catch (\Throwable $th) {

            $message = "Le processus d'attribution d'un pack {$name} à l'utilisateur {$receiver_name} pour son école {$school_name} a échoué! Veuillez réessayer!";

            DB::rollBack();

            Notification::sendNow([$this->admin_validator], new RealTimeNotification($message));
            
        }
    }

}
