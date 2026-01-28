<?php

namespace App\Models;

use App\Events\SchoolBestPupilCreatedEvent;
use App\Events\SchoolBestPupilUpdatedEvent;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchoolBestPupil extends Model
{
    protected $fillable = [
        'school_id',
        'mention',
        'details',
        'ranks',
        'average',
        'exam',
        'pupil_name',
        'image_path',
        'hidden',
        'uuid',
        'slug'
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'details' => 'array',
            'ranks' => 'array',
        ];
    }

    public static function booted()
    {

        static::creating(function ($best){

            $best->uuid = Str::uuid();

            $slug = 'meilleur-eleve-' . Str::slug($best->pupil_name) . '-' . Str::slug($best->exam) . '-de-' . Str::slug($best->school->name);

            $best->slug = Str::slug($slug);

        });

        static::updating(function ($best){

            $slug = 'meilleur-eleve-' . Str::slug($best->pupil_name) . '-' . Str::slug($best->exam) . '-de-' . Str::slug($best->school->name);

            $best->slug = Str::slug($slug);

        });

        static::created(function ($school_best_pupil){

            SchoolBestPupilCreatedEvent::dispatch($school_best_pupil);

        });



        
        static::updated(function ($school_best_pupil){

            SchoolBestPupilUpdatedEvent::dispatch($school_best_pupil);

        });

    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
