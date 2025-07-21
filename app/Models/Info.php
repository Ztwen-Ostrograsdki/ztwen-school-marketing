<?php

namespace App\Models;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Info extends Model
{

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'content',
        'is_active',
        'user_id',
        'school_id',
        'target',
        'type',
    ];

    public static function booted()
    {
        static::creating(function ($info){

            $info->uuid = Str::uuid();

            $info->slug = Str::slug($info->title) . '-' . generateRandomNumber();

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
    


}
