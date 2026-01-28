<?php
namespace App\Livewire\Traits;



use App\Helpers\Robots\SpatieManager;
use App\Models\SchoolBestPupil;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;


trait SchoolBestsPupilsActionsTraits{


public function deleteSchoolBestPupil($pupil_id)
    {
        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer un meilleur élève </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmPupilDeletion', 'confirmButtonText' => 'Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['pupil_id' => $pupil_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmPupilDeletion')]
    public function onConfirmPupilDeletion($data)
    {
        $pupil_id = $data['pupil_id'];

        if($pupil_id){

            $school = $this->school;

            $pupil = SchoolBestPupil::where('id', $pupil_id)->first();

            if($pupil){

				$pupil_name = $pupil->pupil_name;

                $deleted = $pupil->delete();

				$school->refreshSchoolBestPupilsPhotos();

				if($deleted) $this->toast( "{$pupil_name} a été retiré avec succès de la liste de vos meilleurs records!", 'success');

				else $this->toast( "Erreur : La suppression a échoué!", 'error');

				$this->counter = getRand();

            }
            else{
                return $this->toast( "Erreur données: cette donnée est introuvable!", 'error');
            }
        }
    }


	public function hideSchoolBestPupil($pupil_id)
    {

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer ce record ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Ce record ne sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmPupilHidden', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['video_id' => $pupil_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPupilHidden')]
    public function onHidePupil($data)
    {
        if($data){

            $pupil_id = $data['pupil_id'];

            if($pupil_id){

                $pupil = SchoolBestPupil::where('id', $pupil_id)->first();

                if($pupil){

                    $message = "Le record de " . $pupil->pupil_name . " a été masqué avec succès!";

                    $hidden = $pupil->update(['hidden' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("Le record n'a pas pu être masqué", 'error');
				}
            }
			else{

				return $this->toast("Le record n'a pas pu être masqué", 'error');
			}

            
        }
    }

	public function unhideSchoolBestPupil($pupil_id)
    {

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment rendre visible ce record ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Ce record sera à nouveau visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmPupilUnHidden', 'confirmButtonText' => 'Afficher', 'cancelButtonText' => 'Annulé', 'data' => ['video_id' => $pupil_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPupilUnHidden')]
    public function onUnHidePupil($data)
    {
        if($data){

            $pupil_id = $data['pupil_id'];

            if($pupil_id){

                $pupil = SchoolBestPupil::where('id', $pupil_id)->first();

                if($pupil){

                    $message = "Le record de " . $pupil->pupil_name . " est à nouveau visible par les visiteurs!";

                    $hidden = $pupil->update(['hidden' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("Le record n'a pas pu être publié", 'error');
				}
            }
			else{

				return $this->toast("Le record n'a pas pu être publié", 'error');
			}

            
        }
    }



	public function hideAllBestPupils()
    { 

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer toutes les records? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Tous les recoords ne seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllBestPupils', 'confirmButtonText' => 'Tout masquer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllBestPupils')]
    public function onHideAllBestPupils()
    {
        $message = "Tous les meilleurs publiés sont à présents masquées et donc inacessibles par vos visiteurs!";

		$updates = $this->school->best_pupils()->where('school_videos.hidden', true)->update(['hidden' => true]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }

	public function unhideAllBestPupils()
    { 

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment publier toutes les records? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Tous les recoords seront à nouveau visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToUnHideAllBestPupils', 'confirmButtonText' => 'Tout afficher', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToUnHideAllBestPupils')]
    public function onUnHideAllBestPupils()
    {
        $message = "Tous les records publiés sont à présents visibles par vos visiteurs!";

		$updates = $this->school->best_pupils()->where('school_videos.hidden', false)->update(['hidden' => false]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }


    public function manageBestPupil($pupil_id)
    {
        $this->dispatch('ManageSchoolImageData', $pupil_id);
    }
    
    public function manageVideo($video_id)
    {
        $this->dispatch('ManageSchoolVideoLiveEvent', $this->school->id, $video_id);
    }



}