<?php

namespace App\Models;

use App\Events\SchoolDataHasBeenUpdatedEvent;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\School;
use App\Notifications\RealTimeNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class SchoolFollower extends Model
{
    protected $fillable = [
        'follower_id',
        'school_id',

    ];

    public static function booted()
    {
        static::created(function ($follow){

            $author = $follow->school->user;

            Notification::sendNow([$author], new RealTimeNotification("Vous avez un nouveau follower pour votre école {$follow->school->name}"));

            $rand = randomNumber(1, 8);

            if($rand > 6):

                $lien = $follow->school->to_profil_route();

                JobToSendSimpleMailMessageTo::dispatch($author->email, $author->getFullName(), "Vous avez un nouveau follower pour votre école {$follow->school->name}", "Nouveau Follower", null, $lien);

            endif;
            
            SchoolDataHasBeenUpdatedEvent::dispatch($follow->school);

        });

    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
