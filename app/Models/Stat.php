<?php

namespace App\Models;

use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\ObserveStat;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveStat::class)]
class Stat extends Model
{
    protected $fillable = [
        'stat_value',
        'exam',
        'title',
        'user_id',
        'school_id',
        'subscription_id',
        'year',
        'is_active',
    ];

    protected $casts = [
        'stat_value' => 'decimal:2'
    ];

    public static function booted()
    {
        static::created(function ($stat){

            


        });

        static::updating(function ($stat){

            
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

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    
}
