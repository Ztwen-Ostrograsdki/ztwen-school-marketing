<?php

namespace App\Models;

use App\Models\Pack;
use App\Models\Payment;
use App\Models\Stat;
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
        'is_public',
        'created_by',
        'creation_year',
        'geographic_position',

    ];

    public $photos_root = 'ecoles/';

    protected $casts = [
        'objectives' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
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

    public function getSchoolType() : string
    {
        return $this->is_public ? 'Public' : 'Privée';
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

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function hasStats($year = null)
    {
        return $year ? 
                    !empty($this->stats()->where('stats.is_active', true)->where('stats.year', $year)->get()) : 
                    !empty($this->stats);
    }


    public function infos()
    {
        return $this->hasMany(Info::class);
    }

    public function hasInfos($type = null, $target = null)
    {
        if($target && $type){

            return !empty($this->infos()->where('infos.is_active', true)->where('infos.type', $type)->where('infos.target', $target)->get());
        }
        elseif($target){

            !empty($this->infos()->where('infos.is_active', true)->where('infos.target', $target)->get());

        }
        elseif($type){

            !empty($this->infos()->where('infos.is_active', true)->where('infos.type', $type)->get());

        }

        return !empty($this->infos()->where('infos.is_active', true)->get());
        
    }

    public function getSchoolInfos($type = null)
    {
        if(!self::hasInfos($type)) return [];

        if($type){

            return $this->infos()->where('infos.is_active', true)->where('infos.type', $type)->get();
        }

        return Info::where(function ($query) {
                            $query->where('school_id', $this->id)->where('infos.is_active', true);
                        })
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($info) {

                        return $info->type;
                    });
                
        
        
    }

    public function getSchoolStatOfYear($year = null)
    {

        if(self::hasStats($year)){

            if($year){

                if($this->hasStats($year)){

                    return $this->stats()->where('year', $year)->where('stats.is_active', true)->get();

                }
            }
            else{

                $stats = Stat::where(function ($query) {
                            $query->where('school_id', $this->id)->where('stats.is_active', true);
                        })
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($stat) {

                        return $stat->year;
                    });
                
                    return $stats[array_key_first($stats->toArray())];

            }
        }
        else{

            return [];
        }
    }


}
