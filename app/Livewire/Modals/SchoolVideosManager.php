<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use App\Models\SchoolVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SchoolVideosManager extends Component
{
    use WithFileUploads, Toast;

    public $user;

    #[Validate("required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400
    ")]
    public $video;

    public $video_model;

    public $max_videos = 1;

    public $counter = 0;

    #[Validate("string|required")]
    public $title;
    
    public $school_id, $school, $modal_name = "#school-videos-manager-modal";

    public $error_message = '';

    public function render()
    {
        return view('livewire.modals.school-videos-manager');
    }

    #[On("ManageSchoolVideoLiveEvent")]
    public function openModal($school_id, $video_id = null)
    {
        $this->school_id = $school_id;

        $school = School::find($this->school_id);

        if($school){

            if($school->current_subscription){

                if(!$school->current_subscription->videosable){

                    return $this->toast("Vous avez déjà épuisé le nombre de vidéos que vous pouvez publier avec votre abonnement actif actuellement!", 'info');

                    return;
                }

                $this->school = $school;

                $this->max_videos = $school->current_subscription->remainingVideos;

                if($video_id){

                    $video = SchoolVideo::where('id', $video_id)->first();

                    if($video){

                        $this->video_model = $video;

                        $this->title = $video->title;

                        $this->dispatch('OpenModalEvent', $this->modal_name);

                    }
                    else{

                        $this->toast("Une erreure s'est produite, la vidéo n'a pas été trouvée!");
                    }

                }
                else{

                    $this->dispatch('OpenModalEvent', $this->modal_name);
                }

                
            }
            else{

                $this->toast("Vous ne pouvez pas ajouter des vidéos car vous n'avez pas d'abonnement actif", 'info');
            }

            
        }

    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);

        $this->reset();
    }

    public function save()
    {
        if(!$this->video_model){

            $this->validate();

            $root_folder =  $this->school->folder;

            DB::beginTransaction();

            try {

                $videos_treated = self::videosUploader($root_folder, $this->video);

                if($videos_treated && !$this->error_message){

                }
                else{

                    $this->toast("La requête n'a pas pu être traitée", 'error');

                    return false;

                }

                DB::commit();

                DB::afterCommit(function() use ($videos_treated){

                    if(!$videos_treated){

                        $this->school->refreshVideosFolder();

                        return $this->toast("Une erreure s'est produite lors de la mise à jour des données!", 'error');

                    }
                    else{

                        $this->reset();

                        $this->hideModal();

                        $this->toast("La mise à jour de votre  école a été lancée", 'success');

                    }


                });
                
            } catch (\Throwable $th) {

                $this->school->refreshVideosFolder();

                DB::rollBack();

                return $this->toast($this->error_message ? $this->error_message : "Une erreure est survenue: " . $th->getMessage(), 'error');

            }


        }
        else{

            $this->validate([
                'title' => [
                    'required',
                    'string', 
                ],
            ]);

            $this->video_model->update(['title' => $this->title]);

            $this->reset();

            $this->hideModal();

            $this->toast("La mise à jour de votre  école a été lancée", 'success');

        }

        
    }

    public function updatedVideo()
    {
        $this->resetErrorBag();

        $this->validate(['video']);
    }

    public function videosUploader($root_folder, $video)
    {
        if (!Storage::disk('public')->exists($root_folder)) {

            Storage::disk('public')->makeDirectory($root_folder);
        }

        if(!Storage::disk('public')->exists($root_folder)){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

            return;
        }

        $video_path = "";

        $extension = $video->extension();

        $file_name = Str::slug($this->school->name) . '-' . getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(6);

        $save = $video->storeAs($root_folder, $file_name . '.' . $extension, ['disk' => 'public']);

        if($save){

            $video_path = $root_folder . '/' . $file_name . '.' . $extension;
        }
        else{

            $this->error_message = "Une erreure est survenue lors du stockage des videos, veuillez réessayer";
            
            return false;
        }

        if($video_path){
            
            if($this->school->current_subscription){

                SchoolVideo::create([
                    'subscription_id' => $this->school->current_subscription->id,
                    'user_id' => auth_user_id(),
                    'school_id' => $this->school->id,
                    'path' => $video_path,
                    'title' => $this->title,
                    'is_active' => true,
                ]);

                return $video_path;
            }
            else{

                $this->error_message = "Une erreure est survenue lors du stockage des videos, Vous n'avez aucun abonnement actif";
            }

        }

        $this->error_message = "Une erreure est survenue lors du stockage des images, veuillez réessayer";

        return false;
            
    }
    
}
