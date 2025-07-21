<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
        return Subscription::where('id', $this->subscription_id)->first();
    }
}
