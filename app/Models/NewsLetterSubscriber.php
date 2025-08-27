<?php

namespace App\Models;

use App\Observers\ObserveNewsLetterSubscriber;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ObserveNewsLetterSubscriber::class)]
class NewsLetterSubscriber extends Model
{
    protected $fillable = ['email', 'is_active'];
}
