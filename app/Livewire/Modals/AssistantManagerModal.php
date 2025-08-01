<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\SpatieManager;
use App\Models\AssistantRequest;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class AssistantManagerModal extends Component
{
    public $modal_name = "#assistant-manager-modal";

    use Toast, Confirm;
    
    public $assistant;

    public $director;

    public $assistant_request;

    public $assistant_request_id;

    public $privileges = [];

    public $selecteds = [];

    public $school;


    public function render()
    {
        $rolables = SpatieManager::getAssistantRolables();

        $roles = Role::whereIn('name', $rolables)->get();

        return view('livewire.modals.assistant-manager-modal', ['roles' => $roles]);
    }


    #[On("ManageAssistantPrivileges")]
    public function openModal($assistant_request_id)
    {
        if($assistant_request_id){

            $assistant_request = AssistantRequest::where('id', $assistant_request_id)->firstOrFail();

            if($assistant_request){

                $this->assistant_request = $assistant_request;

                $this->assistant = $assistant_request->assistant;

                $this->director = $assistant_request->director;

                $this->school = $assistant_request->school;

                $this->privileges = $assistant_request->privileges;

                $this->selecteds = $this->privileges;

                $this->dispatch('OpenModalEvent', $this->modal_name);
            }
        }
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function pushIntoSelecteds($name)
    {
        $tables = [];

        $selecteds = $this->selecteds;

        if(!in_array($name, $selecteds)){

            $selecteds[$name] = $name;
        }

        $this->resetErrorBag();

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($name)
    {
        $this->resetErrorBag();

        $selecteds = $this->selecteds;

        if(in_array($name, $selecteds)){

            unset($selecteds[$name]);
        }

        $this->selecteds = $selecteds;
    }
}
