<?php

namespace App\Livewire\User;

use Livewire\Component;

class MyProfil extends Component
{
    public $uuid;

    public $user_name = "Ostro marc";

    public $user_email = "gertner@gmail.com";

    public function mount($uuid)
    {
        $this->uuid = $uuid;

    }

    
    public function render()
    {
        return view('livewire.user.my-profil');
    }

    
}
