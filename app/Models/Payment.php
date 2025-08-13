<?php

namespace App\Models;

use App\Events\NewPaymentRegistredEvent;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\Pack;
use App\Models\School;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'uuid',
        'email',
        'contacts',
        'amount',
        'observation',
        'user_id',
        'school_id',
        'pack_id',
        'subscription_id',
        'payment_status',
        'validate',
        'payed_at',

    ];

    protected $casts = [
        'payed_at' => 'date'
    ];

    


    public static function booted()
    {
        static::creating(function ($payment){

            $payment->uuid = Str::uuid();

        });

        static::created(function ($payment){

            Notification::sendNow([$payment->subscription->user], new RealTimeNotification("Votre abonnement ref:{$payment->subscription->ref_key} du pack {$payment->pack->name} a été approuvé!"));

            $message = "Votre abonnement ref:{$payment->subscription->ref_key} du pack {$payment->pack->name} a été approuvé! Cet abonnement avec une durée de {$payment->subscription->months} mois, expire le " . __formatDateTime($payment->subscription->will_closed_at);

            $greating = $payment->user->greatingMessage($payment->user->getUserNamePrefix(true, false)) . ", ";

            $lien = $payment->user->to_subscribes_route();

            JobToSendSimpleMailMessageTo::dispatch($payment->email, $greating, $message, "DEMANDE ABONNEMENT APPROUVEE", null, $lien);

            NewPaymentRegistredEvent::dispatch($payment);

        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subscription()
    {
        return  $this->belongsTo(Subscription::class);
    }
}
