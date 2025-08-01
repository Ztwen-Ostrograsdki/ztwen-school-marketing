<?php

namespace App\Models;

use App\Models\School;
use App\Models\User;
use App\Observers\ObserveAssistanceRequest;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[ObservedBy(ObserveAssistanceRequest::class)]
class AssistantRequest extends Model
{
    protected $fillable = [
        'director_id',
        'school_id',
        'assistant_id',
        'status',
        'approved_at',
        'uuid',
        'privileges',
        'delay',
        'is_active',
        'token'
    ];

    protected $casts = [
        'privileges' => 'array',
        'approved_at' => 'datetime',
        'delay' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function ($req){

            $req->uuid = Str::uuid();

        });

    }



    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }


    public function to_assistant_request_route($token = false)
    {
        if($token){

            return 
            route('assistant.request.approved', 
                [
                    'request_uuid' => $this->uuid, 
                    'assistant_uuid' => $this->assistant->uuid, 
                    'sender_uuid' => $this->director->uuid, 
                    'token' => $token
                ]
            );
        }
        
        return 
        route('assistant.request.response', 
            [
                'request_uuid' => $this->uuid, 
                'assistant_uuid' => $this->assistant->uuid, 
                'sender_uuid' => $this->director->uuid
            ]
        );
    }
}
