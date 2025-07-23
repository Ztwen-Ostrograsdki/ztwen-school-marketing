<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class SchoolImagesManager extends Component
{
    use WithFileUploads, Toast;

    public $user;

    public array $images = [];

    public $lycee_id;

    public $lycee;

    public $max_images = 5;

    protected $rules = [
        'images' => 'required|array|max:5', // max 5 images
        'images.*' => 'image|max:2048',     // chaque fichier = image de 2MB max
    ];

    public $counter = 0;
    
    public $school_id, $school, $modal_name = "#school-images-manager-modal";

    public $error_message = '';

    public function render()
    {
        return view('livewire.modals.school-images-manager');
    }

    #[On("ManageSchoolImagesLiveEvent")]
    public function openModal($school_id)
    {
        $this->school_id = $school_id;

        $school = School::find($this->school_id);

        if($school){

            $this->max_images = 7;

            $this->school = $school;

            $this->dispatch('OpenModalEvent', $this->modal_name);

        }

    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function save()
    {
        $max_images = $this->max_images;

        $this->validate([
            'images' => "required|array|max:$max_images",
            'images.*' => 'image|max:2048',
        ]);

        $root_folder =  $this->school->folder;

        DB::beginTransaction();

        try {

            $images_treated = self::imagesUploader($root_folder, $this->images);

            if($images_treated && !$this->error_message){

                $done = $this->school->update(['images' => $images_treated]);

                if(!$done){

                    $this->school->refreshImagesFolder();

                    return $this->toast("Une erreure s'est produite lors de la mise à jour des données!", 'error');

                }
                else{

                    $this->hideModal();

                    $this->toast("La mise à jour de votre  école a été lancée", 'success');

                }

            }
            else{


                $this->toast("La requête n'a pas pu être traitée", 'error');

                return false;

            }

            DB::commit();
            
        } catch (\Throwable $th) {

            $this->school->refreshImagesFolder();

            DB::rollBack();

            return $this->toast($this->error_message ? $this->error_message : "Une erreure est survenue: " . $th->getMessage(), 'error');

        }

        
    }

    public function updatedImages()
    {
        $this->resetErrorBag();
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);

        $this->images = array_values($this->images); 
    }

    public function imagesUploader($root_folder, $images)
    {
        if (!Storage::disk('public')->exists($root_folder)) {

            Storage::disk('public')->makeDirectory($root_folder);
        }

        if(!Storage::disk('public')->exists($root_folder)){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

            return;
        }

        $images_paths = [];

        foreach($images as $image){

            $extension = $image->extension();

            $file_name = Str::slug($this->school->name) . '-' . getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(6);

            $save = $image->storeAs($root_folder, $file_name . '.' . $extension, ['disk' => 'public']);

            if($save){

                $images_paths[] = $root_folder . '/' . $file_name . '.' . $extension;
            }
            else{

                $this->error_message = "Une erreure est survenue lors du stockage des images, veuillez réessayer";
                
                return false;
            }
        }

        if(count($images_paths) == count($images)){

            return $images_paths;

        }

        $this->error_message = "Une erreure est survenue lors du stockage des images, veuillez réessayer";

        return false;
            
    }


    
}
