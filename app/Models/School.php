<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class School extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'contacts',
        'simple_name',
        'user_id',
        'level',
        'slug',
        'system',
        'is_active',
        'department',
        'country',
        'city',
        'capacity',
        'quotes',
        'objectives',
        'images',
        'observation',
        'likes'

    ];

    protected $casts = [
        'objectives' => 'array',
        'images' => 'array',
    ];

    public function to_profil_route()
    {
        return route('school.profil', ['slug' => $this->slug, 'uuid' => $this->uuid]);
    }


    public static function booted()
    {
        static::creating(function ($school){

            $school->uuid = Str::uuid();

            $school->slug = Str::slug($school->name) . '-' . generateRandomNumber();

        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    public function current_subscription()
    {
        return $this->subscriptions()->where('is_active', true)->first();
    }

    public function current_payment()
    {
        return $this->payments()->where('is_active', true)->first();
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


}
