<?php

namespace App\Models;

use App\Events\CommentUpdatedEvent;
use App\Events\NewCommentDispatchedEvent;
use App\Models\School;
use App\Notifications\RealTimeNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class SchoolComment extends Model
{
    protected $fillable = [
        'school_id',
        'content',
        'user_id',
        'hidden'
    ];


    public static function booted()
    {
        static::created(function ($comment){

            $user = $comment->school->user;

            $msg_to_author = "Nouveau commentaire publié : << " . $comment->content . " >>";

            Notification::sendNow([$user], new RealTimeNotification($msg_to_author));

            NewCommentDispatchedEvent::dispatch($comment->school, $comment->content);

        });
        
        static::updated(function ($comment){

            CommentUpdatedEvent::dispatch($comment);

        });

    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
