<?php

namespace App\Models;

use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\ObserveInfo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


#[ObservedBy(ObserveInfo::class)]
class Info extends Model
{

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'content',
        'is_active',
        'user_id',
        'school_id',
        'subscription_id',
        'target',
        'type',
        'subscription_id'
    ];

    public static function booted()
    {
        static::creating(function ($info){

            $info->uuid = Str::uuid();

            $info->slug = Str::slug($info->title) . '-' . generateRandomNumber();

        });
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    


}
