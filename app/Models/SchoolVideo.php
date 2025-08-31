<?php

namespace App\Models;

use App\Events\SchoolDataHasBeenUpdatedEvent;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolVideo extends Model
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
        static::creating(function ($video){
            
            $video->uuid = Str::uuid();

        });
        
        static::created(function ($video){
            
            SchoolDataHasBeenUpdatedEvent::dispatch($video->school);

            $video->school->update(['posts_counter' => $video->school->posts_counter + 1]);

        });

        static::updated(function ($video){
            
            SchoolDataHasBeenUpdatedEvent::dispatch($video->school);

            $video->school->update(['posts_counter' => $video->school->posts_counter + 1]);

        });
        
        static::deleting(function ($video){
            
            Storage::disk('public')->delete($video->path);

            SchoolDataHasBeenUpdatedEvent::dispatch($video->school);

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
