<?php

namespace App\Models;

use App\Events\SchoolBestPupilCreatedEvent;
use App\Events\SchoolBestPupilUpdatedEvent;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;

class SchoolBestPupil extends Model
{
    protected $fillable = [
        'school_id',
        'details',
        'ranks',
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
