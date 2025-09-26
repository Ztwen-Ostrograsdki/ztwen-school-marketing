<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use App\Models\SchoolComment;
use Livewire\Attributes\On;
use Livewire\Component;

class SchoolCommentManagerModal extends Component
{
    use Toast;

    public $modal_name = "#school-comment-manager-modal";

    public $content = '',  $school;

    public function render()
    {
        return view('livewire.modals.school-comment-manager-modal');
    }

    #[On("AddNewCommentLiveEvent")]
    public function openModal($school_id)
    {
        if($school_id){

            $school = School::find($school_id);

            if($school){

                $this->school = $school;

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
        $user_id = null;

        if(auth_user()){

            $user_id = auth_user_id();
        }
        
        if(!$this->school->current_subscription){

            return $this->toast("La pubication des commentaires de cette école n'est pas actif pour le moment!", 'info');

            return;
        }

        $this->validate(
            [
                'content' => 'required|string',
            ]
        );

        $done = SchoolComment::create(['content' => $this->content, 'school_id' => $this->school->id, 'user_id' => $user_id]);

        if($done){

            $this->reset();

            $this->hideModal();

            $this->toast("Votre commentaire a été publié avec succès!", 'success');
        }
        else{

            $this->toast("Une erreure s'est produite lors de la publication de votre commentaire!", 'error');
        }
    }

    public function updatedContent($content)
    {
        $this->resetErrorBag('content');
    }

}
