<?php

namespace App\Models;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AssistantToken extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'max_usesable',
        'only_for',
        'used_count',
        'privileges',
        'delay',
        'token'
    ];

    protected $casts = [
        'privileges' => 'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
