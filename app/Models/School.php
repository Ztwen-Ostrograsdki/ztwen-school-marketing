<?php

namespace App\Models;

use App\Helpers\Services\PacksManagerService;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\SchoolFollower;
use App\Models\SchoolImage;
use App\Models\SchoolVideo;
use App\Models\Stat;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\ObserveSchool;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSchool::class)]
class School extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'cover_image',
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
        'profil_images',
        'observation',
        'description',
        'likes',
        'folder',
        'is_public',
        'created_by',
        'creation_year',
        'posts_counter',
        'geographic_position',

    ];

    public $photos_root = 'ecoles/';

    protected $casts = [
        'objectives' => 'array',
        'profil_images' => 'array',
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


    // public static function booted()
    // {
    //     static::creating(function ($school){

            

    //     });
        
    // }

    public function profilImage() : Attribute
    {
        if(count($this->images) > 0) :

            $image = $this->images()->inRandomOrder()->first()->path;

            return Attribute::get(fn() => $image);

        else :

            $image = asset("/images/school1.jpg");

            return Attribute::get(fn() => $image);

        endif;
    }


    public function getCoverImage()
    {
        return $this->cover_image ? $this->cover_image : asset("/images/default_cover_image.jpg");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function followers()
    {
        return $this->hasMany(SchoolFollower::class);
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function assistant_requests()
    {
        return $this->hasMany(AssistantRequest::class);
    }

    protected function assistants() : Attribute
    {
        return Attribute::get(fn() => $this->assistant_requests()->whereNotNull('approved_at')->where('is_active', true)->get());
    }

    public function subscribing()
    {
        return $this->subscriptions()->where('is_active', true)->where('will_closed_at', '>', now())->first() !== null;
    }

    public function current_subscription()
    {
        return $this->hasOne(Subscription::class)->whereNotNull('validate_at')->where('is_active', true)->where('will_closed_at', '>', now())->latest('will_closed_at');
    }

    public function current_payment()
    {
        return $this->payments()->where('is_active', true)->first();
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function hasProfilImages()
    {
        return count($this->profil_images) > 0;
    }

    public function hasVideos()
    {
        return count($this->videos) > 0;
    }

    public function videos()
    {
        return $this->hasMany(SchoolVideo::class);
    }
    
    public function hasImages()
    {
        return count($this->images) > 0;
    }


    public function images()
    {
        return $this->hasMany(SchoolImage::class);
    }

    public function getSchoolType() : string
    {
        return $this->is_public ? 'Public' : 'Privée';
    }

    public function refreshImagesFolder()
    {

        $is_dir = Storage::disk('public')->exists($this->folder);

        if($is_dir){

            $models_images = $this->images;

            foreach($models_images as $img){

                if(!Storage::disk('public')->exists($img->path)){

                    $img->delete();
                }

            }


        }
    }
    
    
    public function refreshSchoolCoverImage()
    {
        $is_dir = Storage::disk('public')->exists($this->folder);

        if($is_dir){

            $target = 'photo-de-couverture-ecole-' . $this->id;

            $cover_image = $this->cover_image;

            if($cover_image && !Storage::disk('public')->exists($cover_image)){

                $this->update(['cover_image' => null]);
            }

            if(!$cover_image){

                $this->update(['cover_image' => null]);

                $files = Storage::allFiles('public/'.$this->folder);

                foreach($files as $file){

                    if(str_contains($file, $target)){

                        Storage::disk('public')->delete($file);

                    }
                }
            }

        }
    }
    
    public function refreshVideosFolder()
    {

        $is_dir = Storage::disk('public')->exists($this->folder);

        if($is_dir){

            $models_videos = $this->videos;

            foreach($models_videos as $video){

                if(!Storage::disk('public')->exists($video->path)){

                    $video->delete();
                }

            }


        }
    }


    public function getStatsByYears()
    {
        return Stat::where(function ($query) {
                        $query->where('school_id', $this->id);
                    })
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($stat) {

                    return $stat->year;
                });
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function hasStats($year = null)
    {
        return $year ? 
                    count($this->stats()->where('stats.is_active', true)->where('stats.year', $year)->get()) > 0 : 
                    count($this->stats) > 0;
    }


    public function infos()
    {
        return $this->hasMany(Info::class);
    }

    public function hasInfos($type = null, $target = null)
    {
        if($target && $type){

            return count($this->infos()->where('infos.is_active', true)->where('infos.type', $type)->where('infos.target', $target)->get()) > 0;
        }
        elseif($target){

            count($this->infos()->where('infos.is_active', true)->where('infos.target', $target)->get()) > 0;

        }
        elseif($type){

            count($this->infos()->where('infos.is_active', true)->where('infos.type', $type)->get()) > 0;

        }

        return count($this->infos()->where('infos.is_active', true)->get()) > 0;
        
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

                if(count($stats) > 0) return $stats[array_key_first($stats->toArray())];

                else return [];

            }
        }
        else{

            return [];
        }
    }


    public function getIASIAccessLevel()
    {
        if($this->subscribing()){

            $current_subs = $this->current_subscription();

            if($current_subs){

                return PacksManagerService::getIASIAccessLevel($current_subs->pack->name);
            }

        }

        return null;
    }


    public function hasIASIAccess($level = null)
    {
        if($this->getIASIAccessLevel()){

            if($level):

                return $this->getIASIAccessLevel() == $level;

            else :

                return $this->getIASIAccessLevel() == 'iasi';
                
            endif;

        }
        return false;
    }


    protected function posts() : Attribute
    {
        return Attribute::get(fn() => $this->posts_counter);
    }
}
