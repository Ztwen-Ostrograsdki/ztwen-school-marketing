<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class SubscribePage extends Component
{

    public $email;

    public $school;

    public $level;

    public $subscribe_option;

    public function render()
    {
        return view('livewire.auth.subscribe-page');
    }
}
