<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class NewAssistantModal extends Component
{
    public $modal_name = "#add-new-assistant-modal";

    public $assistant, $assistant_email, $assistant_ID, $assistant_roles = [], $assistant_identifiant;

    public function render()
    {
        return view('livewire.modals.new-assistant-modal');
    }

    #[On("AddNewAssistantLiveEvent")]
    public function openModal()
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function addAssistant()
    {
        if($this->assistant_identifiant){

            if(filter_var($this->assistant_identifiant, FILTER_VALIDATE_EMAIL)){


            }
            else{


            }

        }

    }
}
