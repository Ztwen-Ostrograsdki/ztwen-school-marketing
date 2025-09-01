<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Robots\SpatieManager;
use App\Models\SchoolImage;
use App\Models\SchoolVideo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Profil Utilisateur")]
class MyProfil extends Component
{
    use ListenToEchoEventsTrait, Toast, Confirm;
    
    public $uuid, $user_id;

    public $user_name;

    public $user_email;

    public $user;

    public $counter = 2;

    public function mount($id, $uuid)
    {
        if($id && $uuid){

            $user = User::where('identifiant', $id)->where('uuid', $uuid)->firstOrFail();

            if($user){

                $this->user_id = $id;

                $this->uuid = $uuid;

                $this->user = $user;

                $this->user_name = $user->getFullName();

                $this->user_email = $user->email;
            }
        }
        else{

            return abort(404);
        }

    }

    
    public function render()
    {
        $all_subscribes = count($this->user->subscriptions);

        $all_posts = array_sum($this->user->schools()->pluck('posts_counter')->toArray());

        $all_likes = 0;

        foreach($this->user->schools as $school){

            $all_likes += count($school->followers);
        }

        return view('livewire.user.my-profil', compact('all_subscribes', 'all_posts', 'all_likes'));
    }


    public function removeImage($image_id, int $school_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $school_id, ['schools-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une image </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImageDeletion', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['image_id' => $image_id, 'school_id' => $school_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImageDeletion')]
    public function confirmImageRemoving($data)
    {
        $image_id = $data['image_id'];

        if($image_id){

            $image = SchoolImage::where('id', $image_id)->first();

            if($image){

                $school = $image->school;

                $image_path = $image->path;

                if(Storage::disk('public')->exists($image_path)){

                    $deleted = $image->delete();

                    $school->refreshImagesFolder();

                    if($deleted) $this->toast( "L'image a été retirée avec succès!", 'success');

                    else $this->toast( "Erreur : La suppression de l'image a échoué!", 'error');

                    $this->counter = getRand();
                    
                }
                else{

                    return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
            }
        }
    }

    public function generateAssistantTokenFor()
    {
        $this->dispatch('AddNewAssistantLiveEvent');

    } 
    
    public function upgradeSubscription($subscription_id = null)
    {
        if(!$this->user->current_subscription) return $this->toast( "Vous n'avez aucun abonnement actif!", 'error');

        return redirect()->to($this->user->current_subscription->to_upgrading_route());

    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $stat_id);
    }


    public function manageSchoolInfo($info_id = null)
    {
        
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }

    public function removeVideoFromVideosOf($video_id, $school_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $school_id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une vidéo </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmVideoDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['video_id' => $video_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmVideoDeletion')]
    public function confirmVideoRemoving($data)
    {
        $video_id = $data['video_id'];

        if($video_id){

            $video = SchoolVideo::where('id', $video_id)->first();

            $school = $video->school;

            if($video){

                $video_path = $video->path;

                if(Storage::disk('public')->exists($video_path)){

                    $deleted = $video->delete();

                    $school->refreshVideosFolder();

                    if($deleted) $this->toast( "La vidéo a été retirée avec succès!", 'success');

                    else $this->toast( "Erreur : La suppression de la vidéo a échoué!", 'error');

                    $this->counter = getRand();
                    
                }
                else{

                    return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
            }
        }
    }

    public function manageVideo($video_id, $school_id)
    {
        $this->dispatch('ManageSchoolVideoLiveEvent', $school_id, $video_id);
    }


    
}
