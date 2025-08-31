<?php

namespace App\Models;

use App\Events\SchoolDataHasBeenUpdatedEvent;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolImage extends Model
{
    protected $fillable = [
        'uuid',
        'subscription_id',
        'user_id',
        'school_id',
        'path',
        'title',
        'is_active',

    ];

    public static function booted()
    {
        static::creating(function ($image){
            
            $image->uuid = Str::uuid();

        });
        
        static::created(function ($image){
            
            SchoolDataHasBeenUpdatedEvent::dispatch($image->school);

            $image->school->update(['posts_counter' => $image->school->posts_counter + 1]);

        });

        static::updated(function ($image){
            
            SchoolDataHasBeenUpdatedEvent::dispatch($image->school);

            $image->school->update(['posts_counter' => $image->school->posts_counter + 1]);

        });
        
        static::deleting(function ($image){
            
            Storage::disk('public')->delete($image->path);

            SchoolDataHasBeenUpdatedEvent::dispatch($image->school);

        });
    }


    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
