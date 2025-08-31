<?php

namespace App\Jobs;

use App\Helpers\Robots\ModelsRobots;
use App\Jobs\JobToJoinSchoolDataToCurrentSubscription;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToQueueSubscriptionApprobation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public ?User $admin_validator, public Subscription $subscription)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        self::__runJob();
    }

    public function __runJob()
    {

        $admin_validator = $this->admin_validator;

        $today = now();

        $subscriber = $this->subscription->subscriber;

        DB::beginTransaction();

        try {

            $current_subscription = $subscriber->current_subscription;

            $has_expired_unclosed_sub = $subscriber->hasOne(Subscription::class)->whereNotNull('validate_at')->where('will_closed_at', '<', now())->latest('will_closed_at');

            if($has_expired_unclosed_sub && $has_expired_unclosed_sub->is_active){

                if($has_expired_unclosed_sub->hasPlannedDelayedTask(config('app.subcriptions_task_report'))) : 

                    $has_expired_unclosed_sub->deletePlannedTask(config('app.subcriptions_task_report'));

                endif;

                $has_expired_unclosed_sub->update(['is_active' => false]);

            }


            if($current_subscription){

                if($current_subscription->will_closed_at < $today){

                    if($current_subscription->hasPlannedDelayedTask(config('app.subcriptions_task_report'))) : 

                        $current_subscription->deletePlannedTask(config('app.subcriptions_task_report'));

                    endif;

                    $current_subscription->update(['is_active' => false]);

                }

            }

            $subscription_data = [
                'free_days' => 3,
                'validate_at' => $today,
                'will_closed_at' => Carbon::now()->addMonths($this->subscription->months),
                'payment_status' => "Payé",
                'is_active' => true,
            ];

            $payment_data = [
                'email' => $this->subscription->email,
                'contacts' => $this->subscription->contacts,
                'amount' => $this->subscription->amount,
                'observation' => $this->subscription->observation,
                'user_id' => $this->subscription->user_id,
                'school_id' => $this->subscription->school_id,
                'pack_id' => $this->subscription->pack_id,
                'subscription_id' => $this->subscription->id,
                'payment_status' => $this->subscription->payment_status,
                'validate' => true,
                'payed_at' => $today,
            ];

            $this->subscription->update($subscription_data);

            $payment = Payment::create($payment_data);

            DB::commit();

            DB::afterCommit(function() use ($payment, $subscriber, $admin_validator){

                $message = "Votre demande d'abonnement ref:{$this->subscription->ref_key} au pack {$this->subscription->pack->name} a été approuvé et activé avec succès. Votre abonnement est à présent actif!";

                if($payment && $this->subscription->is_active){

                    JobToJoinSchoolDataToCurrentSubscription::dispatch($this);
                }

                Notification::sendNow([$subscriber], new RealTimeNotification($message));

                $lien = $subscriber->to_subscribes_route();

                $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

                JobToSendSimpleMailMessageTo::dispatch($subscriber->email, $greating, $message, "SOUSCRIPTION " . $this->subscription->ref_key . " VALIDEE - ABONNEMENT ACTIVE ", null, $lien);

                $message_to_admins = "L'abonnement ref:{$this->subscription->ref_key} du pack {$this->subscription->pack->name} fait par {$subscriber->getFullName()} a été validé avec succès!";

                if($admin_validator){

                    Notification::sendNow([auth_user()], new RealTimeNotification($message_to_admins));

                }
                else{

                    $admins = ModelsRobots::getAllAdmins();

                    if(!empty($admins)){

                        Notification::sendNow($admins, new RealTimeNotification($message_to_admins));
                    }
                }
                return $payment;

            });
            

        } catch (\Throwable $th) {

            DB::rollBack();

            if($admin_validator) : 

                Notification::sendNow([$admin_validator], new RealTimeNotification("La validation de l'abonnement ref:{$this->subscription->ref_key} du pack {$this->subscription->pack->name} fait par {$this->subscription->user->getFullName()} a échoué! : " . $th->getMessage()));

                return false;

            else :
                $admins = ModelsRobots::getAllAdmins();

                if(!empty($admins)){

                    Notification::sendNow($admins, new RealTimeNotification("La validation de l'abonnement ref:{$this->subscription->ref_key} du pack {$this->subscription->pack->name} fait par {$this->subscription->user->getFullName()} a échoué! : " . $th->getMessage()));
                }

                return false;

            endif;
        }
    }


    public function middleware() : array
    {
        return [
            Skip::when(!$this->subscription->exists),
            Skip::when($this->subscription->is_active),
        ];
    }
}
