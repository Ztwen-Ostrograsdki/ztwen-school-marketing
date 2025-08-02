<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\SpatieManager;
use App\Models\AssistantRequest;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Throwable;

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
        
        $selecteds = $this->selecteds;

        if(!in_array($name, $selecteds)){

            $selecteds[$name] = $name;
        }

        $this->selecteds = $selecteds;
    }

    public function retrieveFromSelecteds($name)
    {
        $selecteds = $this->selecteds;

        if(in_array($name, $selecteds)){

            unset($selecteds[$name]);
        }

        $this->selecteds = $selecteds;
    }

    public function insert()
    {
        DB::beginTransaction();
        
        try {

            $selecteds = $this->selecteds;

            $translateds = [];

            foreach($selecteds as $role_name){

                $translateds[] = __translateRoleName($role_name);

            }

            $this->assistant_request->update(['privileges' => $selecteds]);

            DB::commit();

            DB::afterCommit(function() use ($translateds){

                $message = "Vous avez mis à jour les privilèges de " . $this->assistant_request->assistant->getFullName() . " pour la gestion de l'école " . $this->assistant_request->school->name . ". Il aura désormais les accès suivant: " . implode(" -- ", $translateds);

                Notification::sendNow([$this->assistant_request->director], new RealTimeNotification($message));

                $this->hideModal();

                $this->reset();

            });

        } catch (Throwable $th) {

            $this->toast("Une erreure s'est produite lors de la mise à jour des privilèges de " . $this->assistant_request->assistant->getFullName(), 'error');

            DB::rollBack();

            
        }
    }
}
