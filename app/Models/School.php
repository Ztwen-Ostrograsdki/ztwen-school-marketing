<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\ObserveSchool;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSchool::class)]
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
        'likes',
        'folder',

    ];

    public $photos_root = 'ecoles/';

    protected $casts = [
        'objectives' => 'array',
        'images' => 'array',
    ];

    public function to_profil_route()
    {
        return route('school.profil', ['slug' => $this->slug, 'uuid' => $this->uuid]);
    }
    
    public function to_school_update_route()
    {
        return route('school.edition', ['user_uuid' => $this->user->uuid, 'school_slug' => $this->slug, 'school_id' => $this->id]);
    }


    public static function booted()
    {
        static::creating(function ($school){

            $school->uuid = Str::uuid();

            $school->is_active = false;

            $school->likes = generateRandomNumber(2);

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

    public function hasImages()
    {
        return !empty($this->images);
    }

    public function refreshImagesFolder()
    {

        $is_dir = Storage::disk('public')->exists($this->folder);

        if($is_dir){

            $images = (array)$this->images;

            $images_from_storage = Storage::disk('public')->files($this->folder);

            foreach($images_from_storage as $file){

                if(!in_array($file, $images)){

                    Storage::disk('public')->delete($file);

                }

            }


        }
    }


}
