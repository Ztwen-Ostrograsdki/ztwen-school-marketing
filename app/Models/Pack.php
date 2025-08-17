<?php

namespace App\Models;

use App\Events\PacksHasBeenUpdatedEvent;
use App\Helpers\Services\PacksManagerService;
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
        'subscribed',
        'is_active'

    ];

    protected $casts = [
        'privileges' => 'array',
    ];


    public function to_profil_route()
    {
        return route('pack.profil', ['pack_uuid' => $this->uuid, 'pack_slug' => $this->slug]);
    }

    
    public function to_admin_pack_profil_route()
    {
        return route('admin.pack.profil', ['token' => config('app.my_token'), 'pack_slug' => $this->slug, 'pack_uuid' => $this->uuid]);
    }

    public function to_pack_edition_route()
    {
        return route('pack.update', ['token' => config('app.my_token'), 'pack_slug' => $this->slug, 'pack_uuid' => $this->uuid]);
    }
    
    public function to_subscribing_route()
    {
        return route('subscribe.confirmation', ['token' => config('app.my_token'), 'pack_uuid' => $this->uuid, 'pack_slug' => $this->slug]);
    }

    public static function booted()
    {
        static::creating(function ($pack){

            $pack->uuid = Str::uuid();

            if($pack->discount > 0)  $pack->promoting = true;

            else $pack->promoting = false;

            $pack->slug = Str::slug($pack->name);

            $pack->on_page = true;

            $pack->notify_by_email = PacksManagerService::getDetails($pack->name)['notify_by_email'];

            $pack->notify_by_sms = PacksManagerService::getDetails($pack->name)['notify_by_sms'];

        });

        static::updating(function ($pack){

            if($pack->discount > 0)  $pack->promoting = true;

            else $pack->promoting = false;

            $pack->notify_by_email = PacksManagerService::getDetails($pack->name)['notify_by_email'];

            $pack->notify_by_sms = PacksManagerService::getDetails($pack->name)['notify_by_sms'];

        });

        static::created(function ($pack){

            if($pack->is_active){

                //Allow users that new pack dispatched


            }
        });

        static::updated(function ($pack){

            PacksHasBeenUpdatedEvent::dispatch();

        });
    }

    public function users()
    {
        return [];
    }
    
    public function schools() : ?array
    {
        $schools = [];

        $subscriptions = $this->subscriptions()->whereNotNull('subscriptions.validate_at')->orderBy('subscriptions.validate_at', 'desc')->get();

        foreach($subscriptions as $subscription):

            if($subscription->validate_at && $subscription->payment){

                $schools[] = $subscription->school;

            }

        endforeach;

        return $schools;
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
