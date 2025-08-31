<?php

namespace App\Models;

use App\Helpers\Robots\ModelsRobots;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Jobs\JobToSendSubcriptionDetailsToTheSubcriber;
use App\Notifications\RealTimeNotification;
use App\Observers\ObserveSubscriptionUpgradeRequest;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
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
    
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

     public function __notifySubscriberToFinalyseSubscriptionByPayingToValidateIt(?User $admin_validator = null)
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




}
