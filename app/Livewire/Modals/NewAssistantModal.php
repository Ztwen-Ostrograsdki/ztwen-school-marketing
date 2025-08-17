<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitializationToCreateNewAssistantRequestEvent;
use App\Events\NewAssistanceRequestCreatedEvent;
use App\Helpers\Robots\SpatieManager;
use App\Models\AssistantRequest;
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

    public $school;

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

    public function updatedSchoolId($school_id)
    {
        if($school_id){

            $school = School::whereId($school_id)->first();

            if($school){

                $this->school = $school;
            }
        }
    }

    public function addAssistant()
    {
        if(!$this->school->current_subscription()){

            return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

            return;
        }
        elseif($this->school->current_subscription() && !$this->school->current_subscription()->assistable){

            return $this->toast("Vous avez déjà épuisé le nombre d'assistants que vous pouvez avoir avec votre abonnement actif actuellement!", 'info');

            return;
        }

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

            $existed_approved = AssistantRequest::where('assistant_id', $this->receiver->id)->where('director_id', $sender->id)->where('school_id', $this->school_id)->where('status', 'Approuvé')->whereNotNull('approved_at')->first();

            $existed_not_approved = AssistantRequest::where('assistant_id', $this->receiver->id)->where('director_id', $sender->id)->where('school_id', $this->school_id)->where('status', '<>', 'Approuvé')->whereNull('approved_at')->first();

            if($existed_approved){

                $message = "Attention: " . $this->receiver->getFullName() . " vous assiste déjà dans la gestion de l'école " . $school->name . " avec les privilèges : " . implode(" - ", $existed_approved->privileges) . " depuis le " . __formatDateTime($existed_approved->approved_at);

                $this->addError('assistant', $this->receiver->getFullName() . " vous assiste déjà!");

                $this->toast($message, "info");

                return;
            }

            if($existed_not_approved){

                $d = $existed_not_approved->delay;

                if($d > now()){

                    $message = "Attention: Vous avez déjà envoyé une demande à " . $this->receiver->getFullName() . " pour vous assister dans la gestion de l'école " . $school->name . " avec les privilèges : " . implode(" - ", $existed_not_approved->privileges) . " depuis le " . __formatDateTime($existed_not_approved->created_at);

                    $this->addError('assistant', $this->receiver->getFullName() . " a déjà une demande en cours!");

                    $this->toast($message, "info");

                    return;
                }
                else{

                    $existed_not_approved->delete();
                }
            }


            InitializationToCreateNewAssistantRequestEvent::dispatch($sender, $this->receiver, $school, $this->assistant_roles);

            $this->toast("Le processus a été lancé", "success");

            $this->hideModal();

        }

        
    }
}
