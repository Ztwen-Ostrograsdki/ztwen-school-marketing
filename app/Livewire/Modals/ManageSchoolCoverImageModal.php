<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\SchoolDataUpdatedEvent;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageSchoolCoverImageModal extends Component
{
    use Toast, Confirm, WithFileUploads;

    public $modal_name = "#school-cover-image-editor-modal";

    public $cover_image;

    public $current_cover_image;

    public $school;

    public $error_message = '';

    public function render()
    {
        return view('livewire.modals.manage-school-cover-image-modal');
    }

    #[On("ManageSchoolCoverImageData")]
    public function openModal($school_id)
    {

        $school = School::find($school_id);

        if($school){

            $this->school = $school;

            if($school->cover_image){

                $this->current_cover_image = $school->cover_image;
            }

            $this->dispatch('OpenModalEvent', $this->modal_name);

        }
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }


    public function save()
    {

        $this->validate([
            'cover_image' => 'image|max:2048',
        ]);

        $root_folder =  $this->school->folder;

        DB::beginTransaction();

        try {

            $image_treated = self::imageUploader($root_folder, $this->cover_image);

            if($image_treated && !$this->error_message){

                $this->school->update(['cover_image' => $image_treated, 'posts_counter' => $this->school->posts_counter + 1]);
            }
            else{

                $this->toast("La requête n'a pas pu être traitée", 'error');

                return false;

            }

            DB::commit();

            DB::afterCommit(function() use ($image_treated){

                if(!$image_treated){

                    $this->school->refreshSchoolCoverImage();

                    return $this->toast("Une erreure s'est produite lors de la mise à jour de l'image de couverture!", 'error');

                }
                else{

                    $this->reset();

                    $this->hideModal();

                    $this->toast("La mise à jour de votre de l'image de couverture s'est bien déroulée!", 'success');

                }


            });
            
        } catch (\Throwable $th) {

            $this->school->refreshSchoolCoverImage();

            DB::rollBack();

            return $this->toast($this->error_message ? $this->error_message : "Une erreure est survenue: " . $th->getMessage(), 'error');

        }
    }

    public function updatedCoverImage()
    {
        $this->resetErrorBag();
    }

    public function removeImage()
    {
        $this->resetErrorBag();

        $this->reset('cover_image');
    }

    public function imageUploader($root_folder, $image)
    {
        if (!Storage::disk('public')->exists($root_folder)) {

            Storage::disk('public')->makeDirectory($root_folder);
        }

        if(!Storage::disk('public')->exists($root_folder)){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

            return;
        }

        $extension = $image->extension();

        $image_path = null;

        $file_name = 'photo-de-couverture-ecole-' . $this->school->id . '-' . Str::slug($this->school->name);

        $save = $image->storeAs($root_folder, $file_name . '.' . $extension, ['disk' => 'public']);

        if($save){

            $image_path = $root_folder . '/' . $file_name . '.' . $extension;
        }
        else{

            $this->error_message = "Une erreure est survenue lors du stockage l'image de couverture, veuillez réessayer";
            
            return false;
        }

        if($this->school->current_subscription){

            return $image_path;
        }
        else{

            $this->error_message = "Une erreure est survenue lors du stockage de l'image de couverture, Vous n'avez aucun abonnement actif";
        }

        $this->error_message = "Une erreure est survenue lors du stockage de l'image de couverture, veuillez réessayer";

        return false;
            
    }
}
