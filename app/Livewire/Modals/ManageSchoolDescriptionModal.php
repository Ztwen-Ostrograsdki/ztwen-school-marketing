<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageSchoolDescriptionModal extends Component
{
    use Toast;

    public $modal_name = "#school-description-manager-modal";

    public $description = '',  $school;

    public function render()
    {
        return view('livewire.modals.manage-school-description-modal');
    }


    #[On("ManageSchoolDescriptionLiveEvent")]
    public function openModal($school_id)
    {
        if($school_id){

            $school = School::find($school_id);

            if($school){

                $this->school = $school;

                $this->description = $school->description;

                $this->dispatch('OpenModalEvent', $this->modal_name);
            }
        }
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function insert()
    {
        if(!$this->school->current_subscription){

            return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

            return;
        }

        $this->validate(
            [
                'description' => 'required|string',
            ]
        );

        $done = $this->school->update(['description' => $this->description]);

        if($done){

            $this->reset();

            $this->hideModal();

            $this->toast("La mise à jour de la description de votre école s'est bien déroulée!", 'success');
        }
        else{

            $this->toast("Une erreure s'est produite lors de la mise à jour de la description de votre école!", 'error');

        }


    }

    public function updatedDescription($title)
    {
        $this->resetErrorBag('description');
    }

    
}
