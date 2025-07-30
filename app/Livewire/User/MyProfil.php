<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Robots\SpatieManager;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class MyProfil extends Component
{
    use ListenToEchoEventsTrait, Toast, Confirm;
    
    public $uuid, $user_id;

    public $user_name;

    public $user_email;

    public $user;

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
        $all_subscribes = getRand(100, 333);

        $all_posts = getRand(1881, 88888);

        $all_likes = getRand(1000, 959599);



        return view('livewire.user.my-profil', compact('all_subscribes', 'all_posts', 'all_likes'));
    }


    public function removeImage($image_path, int $school_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $school_id, ['schools-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une image </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImageDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['image_path' => $image_path, 'school_id' => $school_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImageDeletion')]
    public function confirmImageRemoving($data)
    {

        $image_path = $data['image_path'];

        $school_id = $data['school_id'];

        SpatieManager::ensureThatAssistantCan(auth_user_id(), $school_id, ['schools-images-manager'], true);

        $school = School::where('id', $school_id)->firstOrFail();

        if($school && $image_path){

            $images = (array)$school->images;

            if(in_array($image_path, $images)){

                $image_key = array_keys($images, $image_path)[0];

                if(Storage::disk('public')->exists($image_path)){

                    if(Storage::disk('public')->delete($image_path)){

                        unset($images[$image_key]);

                        $images = array_values($images); 

                        $updated = $school->update(['images' => $images]);

                        if($updated) $this->toast( "L'image a été retirée avec succès!", 'success');

                    }
                    else{

                        return $this->toast( "Une erreure s'est produite, l'image n'a pas pu être supprimée!", 'error');
                    }

                    
                }
                else{

                    return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Une erreure s'est produite!", 'error');
            }
        }
    }

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $stat_id);
    }


    public function manageSchoolInfo($info_id = null)
    {
        
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }

    
}
