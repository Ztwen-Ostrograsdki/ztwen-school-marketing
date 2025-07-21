<?php

namespace App\Livewire\User;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("La liste de mes assistants")]
class MyAssistantsListing extends Component
{
    public $uuid, $user_id;

    public function mount($id, $uuid)
    {
        
        $this->uuid = $uuid;

        $this->user_id = $id;

    }

    public function render()
    {
        return view('livewire.user.my-assistants-listing');
    }


    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }
}
