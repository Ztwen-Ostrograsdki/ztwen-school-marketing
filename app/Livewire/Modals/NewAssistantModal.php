<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitializationToCreateNewAssistantRequestEvent;
use App\Events\NewAssistanceRequestCreatedEvent;
use App\Helpers\Robots\SpatieManager;
use App\Models\School;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class NewAssistantModal extends Component
{
    use Toast, Confirm;

    public $modal_name = "#add-new-assistant-modal";

    #[Validate('required|string')]
    public $assistant;

    public $assistant_email;

    public $assistant_ID;

    #[Validate('required')]
    public $assistant_roles = [];

    public $assistant_identifiant;

    #[Validate('required|numeric|exists:schools,id')]
    public $school_id;

    public $receiver;

    public function render()
    {
        $schools = [];

        $rolables = SpatieManager::getAssistantRolables();

        $roles = Role::whereIn('name', $rolables)->pluck('name')->toArray();

        if(auth_user()){
            
            $schools = auth_user()->schools;
        }

        return view('livewire.modals.new-assistant-modal', compact('roles', 'schools'));
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
        $this->validate();

        if($this->assistant){

            if(filter_var($this->assistant, FILTER_VALIDATE_EMAIL)){

                $this->validate([
                    'assistant' => 'exists:users,email',
                ]);

                $this->receiver = User::where('email', $this->assistant)->first();

            }
            else{

                $this->validate([
                    'assistant' => 'exists:users,identifiant',
                ]);

                $this->receiver = User::where('identifiant', $this->assistant)->first();

            }

            $sender = auth_user();

            $school = School::where('id', $this->school_id)->first();
            

            InitializationToCreateNewAssistantRequestEvent::dispatch($sender, $this->receiver, $school, $this->assistant_roles);

            $this->toast("Le processus a été lancé", "success");

            $this->hideModal();

        }

        
    }
}
