<?php

namespace App\Models;

use App\Events\NewPackSubscriptionCreatedEvent;
use App\Events\PackSubscriptionWasUpdatedEvent;
use App\Helpers\Robots\ModelsRobots;
use App\Helpers\Services\EmailTemplateBuilder;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Jobs\JobToSendSubcriptionDetailsToTheSubcriber;
use App\Mail\MailToSendSubscriptionRefCodeToUser;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\School;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use App\Observers\ObserveSubscription;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSubscription::class)]
class Subscription extends Model
{
            
    protected $fillable = [
        'uuid',
        'unique_price',
        'months',
        'free_days',
        'observation',
        'validate_at',
        'will_closed_at',
        'privileges',
        'max_images',
        'max_stats',
        'max_infos',
        'max_assistants',
        'on_page',
        'amount',
        'seen_by',
        'notify_by_email',
        'notify_by_sms',
        'discount',
        'promoting',
        'payment_status',
        'is_active',
        'user_id',
        'payment_id',
        'school_id',
        'pack_id',
        'validate',
        'ref_key',

    ];

    protected $casts = [
        'privileges' => 'array',
    ];

    public static function booted()
    {
        static::creating(function ($subscription){

            $subscription->uuid = Str::uuid();

        });
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subscriber()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function payment()
    {
        return Payment::where('id', $this->payment_id)->first();
    }


    public function __subcriptionApprobationManager(?User $admin_validator = null)
    {
        DB::beginTransaction();

        $today = now();

        $subscriber = $this->subscriber;

        try {

            $subscription_data = [
                'free_days' => 3,
                'validate_at' => $today,
                'will_closed_at' => Carbon::now()->addMonths($this->months),
                'payment_status' => "Payé",
                'is_active' => true,
            ];

            $payment_data = [
                'email' => $this->email,
                'contacts' => $this->contacts,
                'amount' => $this->amount,
                'observation' => $this->observation,
                'user_id' => $this->user_id,
                'school_id' => $this->school_id,
                'pack_id' => $this->pack_id,
                'subscription_id' => $this->id,
                'payment_status' => $this->payment_status,
                'validate' => true,
                'payed_at' => $today,
            ];

            $this->update($subscription_data);

            $payment = Payment::create($payment_data);

            DB::commit();

            DB::afterCommit(function() use ($payment, $subscriber){

                $message = "Votre demande d'abonnement ref:{$this->subscription->ref_key} du pack {$this->pack->name} a été approuvé et activé avec succès. Votre abonnement est à présent actif!";

                Notification::sendNow([$this->subscription->user], new RealTimeNotification($message));

                $lien = $subscriber->to_subscribes_route();

                $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

                JobToSendSimpleMailMessageTo::dispatch($subscriber->email, $greating, $message, "SOUSCRIPTION VALIDEE - ABONNEMENT ACTIVE" . $this->ref_key, null, $lien);

                return $payment;

            });
            

        } catch (\Throwable $th) {

            DB::rollBack();

            if($admin_validator) : 

                Notification::sendNow([$admin_validator], new RealTimeNotification("La validation de l'abonnement ref:{$this->subscription->ref_key} du pack {$this->pack->name} fait par {$this->user->getFullName()} a échoué!"));

                return false;

            else :
                $admins = ModelsRobots::getAllAdmins();

                if(!empty($admins)){

                    Notification::sendNow($admins, new RealTimeNotification("La validation de l'abonnement ref:{$this->subscription->ref_key} du pack {$this->pack->name} fait par {$this->user->getFullName()} a échoué!"));
                }

                return false;

            endif;
        }
    }


    public function __notifySubscriberToFinalyseSubscriptionByPayingToValidateIt(?User $admin_validator = null)
    {
        if(!$this->validated_at){

            $user = $this->subscriber;

            $lien = $user->to_subscribes_route();

            $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

            $message = "Vous avez lancé une demande d'abonnement pour le pack " . $this->pack->name . " pour votre école " . $this->school->name . " depuis le " . __formatDateTime($this->createdçat) . ". Afin de voir votre abonnement validé et actif, nous vous demandons de procéder au payement par dépôt électronique comme prévu! Un autre mail vous sera envoyé avec des détails du payement à effectuer!";

            JobToSendSimpleMailMessageTo::dispatch($user->email, $greating, $message, "DEMANDE DE VALIDATION DE LA SOUSCRIPTION " . $this->ref_key, null, $lien);

            $this->__sendSubcriptionDetailsToSubscriber();

            Notification::sendNow([$this->subscriber], new RealTimeNotification($message));

        }
    }

    public function __sendSubcriptionDetailsToSubscriber()
    {
        JobToSendSubcriptionDetailsToTheSubcriber::dispatch($this)->delay(now()->addMinutes(2));
    }


    public function __notifyAdminsThatPaymentHasBeenDone()
    {
        if(!$this->validated_at){

            $admins = ModelsRobots::getAllAdmins();

            $subscriber = $this->subscriber;

            $subscriber_name = $subscriber->getUserNamePrefix(true, false);

            $lien = route('admin.packs.subscriptions.list');

            $message = $subscriber_name . " reclame la validation de sa demande d'abonnement pour le pack " . $this->pack->name . " de son école école " . $this->school->name . " dont la référence est " . $this->ref_key . ". En effet, il a déjà effectuer le payement pour cette demande!";

            if(!empty($admins)){

                foreach($admins as $admin) :

                    $greating = $admin->greatingMessage($admin->getUserNamePrefix(true, false)) . ", ";

                    JobToSendSimpleMailMessageTo::dispatch($admin->email, $greating, $message, "RECLAMATION DE LA VALIDATION DE LA SOUSCRIPTION " . $this->ref_key, null, $lien);

                endforeach;

                Notification::sendNow($admins, new RealTimeNotification($message));
            }

        }
    }
}
