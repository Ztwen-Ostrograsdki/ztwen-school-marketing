<?php

namespace App\Livewire\User;

use Livewire\Component;

class MyProfil extends Component
{
    public $uuid, $user_id;

    public $user_name = "Ostro marc";

    public $user_email = "gertner@gmail.com";

    public function mount($id, $uuid)
    {
        $this->user_id = $id;

        $this->uuid = $uuid;

    }

    
    public function render()
    {
        return view('livewire.user.my-profil');
    }

    
}
