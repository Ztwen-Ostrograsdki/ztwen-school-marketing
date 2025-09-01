<?php

namespace App\Models;

use App\Helpers\Robots\ModelsRobots;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Jobs\JobToSendSubcriptionDetailsToTheSubcriber;
use App\Notifications\RealTimeNotification;
use App\Observers\ObserveSubscriptionUpgradeRequest;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSubscriptionUpgradeRequest::class)]
class SubscriptionUpgradeRequest extends Model
{
    protected $fillable = [
        'uuid',
        'unique_price',
        'months',
        'observation',
        'validate_at',
        'will_start_at',
        'will_closed_at',
        'locked_at',
        'amount',
        'discount',
        'promoting',
        'payment_status',
        'is_active',
        'user_id',
        'payment_id',
        'subscription_id',
        'validate',
        'ref_key',

    ];


    protected $casts = [
        'will_start_at' => 'datetime',
        'will_closed_at' => 'datetime',
        'validate_at' => 'datetime',
        'locked_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function ($req){

            $req->uuid = Str::uuid();

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
    
    public function payment() : Attribute
    {
        return Attribute::get(fn() => Payment::where('subscription_upgrading_request_id', $this->id)->first());
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

     public function __notifySubscriberToFinalyseSubscriptionUpgradeRequestByPayingToValidateIt(?User $admin_validator = null)
    {
        if(!$this->validated_at){

            $user = $this->subscriber;

            $lien = $user->to_subscribes_route();

            $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

            $message = "Vous avez lancé une demande de réabonnement pour le pack " . $this->pack->name . " pour votre école " . $this->school->name . " depuis le " . __formatDateTime($this->created_at) . ". Afin de voir votre réabonnement validé votre abonnement prolongé, nous vous demandons de procéder au payement par dépôt électronique comme prévu! Un autre mail vous sera envoyé avec des détails du payement à effectuer!";

            JobToSendSimpleMailMessageTo::dispatch($user->email, $greating, $message, "DEMANDE DE VALIDATION DE LA SOUSCRIPTION " . $this->ref_key, null, $lien);

            $this->__sendSubcriptionDetailsToSubscriber();

            Notification::sendNow([$this->subscriber], new RealTimeNotification($message));

        }
    }


    public function __sendSubcriptionDetailsToSubscriber()
    {
        JobToSendSubcriptionDetailsToTheSubcriber::dispatch($this->subscription)->delay(now()->addMinutes(2), true);
    }

    public function __notifyAdminsThatPaymentHasBeenDone()
    {
        if(!$this->validated_at){

            $admins = ModelsRobots::getAllAdmins();

            $subscriber = $this->subscriber;

            $subscriber_name = $subscriber->getUserNamePrefix(true, false);

            $lien = route('admin.packs.subscriptions.list');

            $message = $subscriber_name . " reclame la validation de sa demande de réabonnement au pack " . $this->pack->name . " de son école école " . $this->school->name . " dont la référence est " . $this->ref_key . ". En effet, il a déjà effectuer le payement pour cette demande!";

            if(!empty($admins)){

                foreach($admins as $admin) :

                    $greating = $admin->greatingMessage($admin->getUserNamePrefix(true, false)) . ", ";

                    JobToSendSimpleMailMessageTo::dispatch($admin->email, $greating, $message, "RECLAMATION DE LA VALIDATION DU REABONNEMENT DE LA SOUSCRIPTION " . $this->subscription->ref_key, null, $lien);

                endforeach;

                Notification::sendNow($admins, new RealTimeNotification($message));
            }

        }
    }


    public function __subcriptionUpgradeRequestApprobationManager(?User $admin_validator = null)
    {
        $today = now();

        $subscriber = $this->subscriber;

        $subscription = $this->subscription;

        try {

            $computed_will_closed_at = Carbon::parse($subscription->will_closed_at)->addMonths($this->months)->addDays(2);

            $subscription_request_data = [
                'will_start_at' => $subscription->will_closed_at,
                'validate_at' => $today,
                'will_closed_at' => $computed_will_closed_at,
                'payment_status' => "Payé",
                'is_active' => true,
            ];

            $subscription_data = [
                'will_closed_at' => $computed_will_closed_at,
                'payment_status' => "Payé",
                'is_active' => true,
            ];

            DB::beginTransaction();

            $payment_data = [
                'email' => $this->email,
                'contacts' => $this->contacts,
                'amount' => $this->amount,
                'observation' => $this->observation,
                'user_id' => $this->user_id,
                'school_id' => $subscription->school_id,
                'pack_id' => $subscription->pack->id,
                'subscription_id' => $subscription->id,
                'subscription_upgrading_request_id' => $this->id,
                'payment_status' => $this->payment_status,
                'validate' => true,
                'payed_at' => $today,
            ];

            $this->update($subscription_request_data);

            $subscription->update($subscription_data);

            $payment = Payment::create($payment_data);

            DB::commit();

            DB::afterCommit(function() use ($payment, $subscriber, $admin_validator, $subscription){

                $message = "Votre demande de réabonnement ref:{$this->ref_key} au pack {$subscription->pack->name} a été approuvé et activé avec succès. Votre abonnement est à été prolongé de {$this->months} mois!";

                Notification::sendNow([$this->user], new RealTimeNotification($message));

                $lien = $subscriber->to_subscribes_route();

                $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

                JobToSendSimpleMailMessageTo::dispatch($subscriber->email, $greating, $message, "REABONNEMENT " . $this->ref_key . " VALIDEE - ABONNEMENT PROLONGE ", null, $lien);

                $message_to_admins = "La demande de ré-abonnement ref:{$this->ref_key} fait par {$subscriber->getFullName()} a été validé avec succès!";

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

                Notification::sendNow([$admin_validator], new RealTimeNotification("La validation de du ré-abonnement ref:{$this->ref_key} de la souscription #{$subscription->ref_key} fait par {$subscriber->getFullName()} a échoué! : " . $th->getMessage()));

                return false;

            else :
                $admins = ModelsRobots::getAllAdmins();

                if(!empty($admins)){

                    Notification::sendNow($admins, new RealTimeNotification("La validation de du ré-abonnement ref:{$this->ref_key} de la souscription #{$subscription->ref_key} fait par {$subscriber->getFullName()} a échoué! : " . $th->getMessage()));
                }

                return false;

            endif;
        }
    }




}
