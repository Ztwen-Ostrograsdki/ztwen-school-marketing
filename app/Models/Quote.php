<?php

namespace App\Models;

use App\Events\UpdateQuotesListEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['user_id', 'content', 'hidden', 'on_page'];


    public static function booted()
    {
        static::creating(function ($quote){

            UpdateQuotesListEvent::dispatch();

        });
        
        static::updated(function ($quote){

            UpdateQuotesListEvent::dispatch();

        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
