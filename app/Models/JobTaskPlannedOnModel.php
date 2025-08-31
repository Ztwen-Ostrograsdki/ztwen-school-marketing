<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobTaskPlannedOnModel extends Model
{
    protected $fillable = [
        'job_id',
        'batch_id',
        'model_id',
        'model_class',
        'job_class',
        'payload',
        'status',
        'report',

    ];

    public static function booted()
    {
        static::creating(function ($report){

        });
    }


    public function job()
    {
        return DB::table('jobs')->where('id', $this->job_id)->first();
    }


   
}
