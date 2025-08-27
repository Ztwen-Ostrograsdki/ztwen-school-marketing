<?php

namespace App\Models;

use App\Events\NewVisitorHasBeenRegistredEvent;
use App\Helpers\Robots\ModelsRobots;
use App\Notifications\RealTimeNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'country',
        'city',
        'device_type',
        'visited_at',
    ];

     public static function booted()
    {
        static::created(function ($visitor){

            NewVisitorHasBeenRegistredEvent::dispatch();

            $admins = ModelsRobots::getAllAdmins();

            Notification::sendNow($admins, new RealTimeNotification("Un nouvel visiteur a été enregistré sur la plateforme!"));

        });

        static::updated(function ($visitor){

            NewVisitorHasBeenRegistredEvent::dispatch();

            $admins = ModelsRobots::getAllAdmins();

            Notification::sendNow($admins, new RealTimeNotification("Un nouvel visiteur a été enregistré sur la plateforme!"));

        });
        
    }

    
}
