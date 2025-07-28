<?php

namespace App\Models;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AssistantRequest extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'assistant_id',
        'status',
        'approved_at',
        'uuid',
        'privileges',
        'delay',
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



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    
    public function assistant()
    {
        return User::where('id', $this->assistant_id)->first();
    }


//     Route::get('/gestion/demande-assistance-gestion-ecole=reponse/v/ru={request_uuid}/au={assistant_uuid}/su={sender_uuid}', AssistantRequestedResponsePage::class)->name('assistant.request.response');

// Route::get('/gestion/demande-assistance-gestion-ecole=reponse/l/ru={request_uuid}/au={assistant_uuid}/su={sender_uuid}/tk={token}', AssistantRequestedResponsePage::class)->name('assistant.request.approved');


    public function to_assistant_request_route($token = true)
    {
        if($token){

            return 
            route('assistant.request.approved', 
                [
                    'request_uuid' => $this->uuid, 
                    'assistant_uuid' => $this->assistant()->uuid, 
                    'sender_uuid' => $this->user->uuid, 
                    'token' => $token
                ]
            );
        }
        
        return 
        route('assistant.request.approved', 
            [
                'request_uuid' => $this->uuid, 
                'assistant_uuid' => $this->assistant()->uuid, 
                'sender_uuid' => $this->user->uuid
            ]
        );
    }
}
