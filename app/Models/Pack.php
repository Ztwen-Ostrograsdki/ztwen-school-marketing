<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pack extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'price',
        'discount',
        'privileges',
        'max_images',
        'max_assistants',
        'max_stats',
        'max_infos',
        'on_page',
        'seen_by',
        'notify_by_sms',
        'notify_by_email',
        'promoting',
        'promo_price',
        'subscribed'

    ];

    protected $casts = [
        'privileges' => 'array',
    ];

    public function to_profil_route()
    {
        return route('pack.profil', ['uuid' => $this->uuid, 'slug' => $this->slug]);
    }
    
    public function to_subscribing_route()
    {
        return route('subscribe.confirmation', ['uuid' => $this->uuid, 'slug' => $this->slug, 'token' => env('APP_MY_TOKEN')]);
    }

    public static function booted()
    {
        static::creating(function ($pack){

            $pack->uuid = Str::uuid();

        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

}
