<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use App\Models\SchoolImage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SchoolImageEditionModal extends Component
{
    use Toast, Confirm;

    public $modal_name = "#school-image-editor-modal";

    #[Validate('required|string')]
    public $title;

    public $image;

    public $image_title = "TITRE DE L'IMAGE";

    public $school;

    public $receiver;

    public function render()
    {

        return view('livewire.modals.school-image-edition-modal');
    }

    #[On("ManageSchoolImageData")]
    public function openModal($school_image_id)
    {
        $school_image = SchoolImage::where('id', $school_image_id)->firstOrFail();

        if($school_image){

            $this->image = $school_image;

            $this->school = $school_image->school;

            $this->title = $school_image->title;

            $this->image_title = $school_image->title;

            $this->dispatch('OpenModalEvent', $this->modal_name);

        }
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }


    public function updateImageData()
    {
        if(!$this->school->current_subscription){

            return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

            return;
        }
        elseif($this->school->current_subscription && !$this->school->current_subscription->assistable){

            return $this->toast("Vous avez déjà épuisé le nombre d'assistants que vous pouvez avoir avec votre abonnement actif actuellement!", 'info');

            return;
        }

        $this->validate();

        $this->image->update(['title' => $this->title]);

        $this->hideModal();

        $this->toast("La mise à jour de l'image s'est bien déroulée!", 'success');

        
    }
}
