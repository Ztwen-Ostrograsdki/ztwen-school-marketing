<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Payment;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'payment_status',
        'validate',

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
}
