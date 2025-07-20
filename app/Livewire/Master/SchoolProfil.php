<?php

namespace App\Livewire\Master;

use Livewire\Component;

class SchoolProfil extends Component
{
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;

    }
    
    public function render()
    {
        return view('livewire.master.school-profil');
    }
}
