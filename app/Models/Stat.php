<?php

namespace App\Models;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'stat',
        'exam',
        'title',
        'user_id',
        'school_id',
        'year',
        'is_active',
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
