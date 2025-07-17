<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Footer extends Component
{
    #[Validate('required|email|unique:news_letter_subscribers,email')]
    public $subscriber_mail;


    public function render()
    {
        Carbon::setLocale('fr');

        $date = ucfirst(Carbon::now()->translatedFormat("F Y"));

        return view('livewire.pages.footer', compact('date'));
    }


    public function subscribeTo()
    {

    }
}
