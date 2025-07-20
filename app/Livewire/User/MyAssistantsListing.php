<?php

namespace App\Livewire\User;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("La liste de mes assistants")]
class MyAssistantsListing extends Component
{
    public $uuid;

    public function mount($uuid)
    {
        
        $this->uuid = $uuid;

    }

    public function render()
    {
        return view('livewire.user.my-assistants-listing');
    }
}
