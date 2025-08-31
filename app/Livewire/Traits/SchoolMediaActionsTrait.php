<?php
namespace App\Livewire\Traits;



use App\Helpers\Robots\SpatieManager;
use App\Models\SchoolImage;
use App\Models\SchoolVideo;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;


trait SchoolMediaActionsTrait{



	public function removeAllImages()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer toutes les images de {$this->school_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImagesDeletion', 'confirmButtonText' => 'Tout Supprimer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImagesDeletion')]
    public function confirmAllImagesRemoving()
    {

        if($this->school){

            $school = $this->school;

            $images = $school->images;

            if(!empty($images)){

                if(Storage::disk('public')->exists($school->folder)){

                    $deleted = $school->images()->delete();

                    if($deleted){

                        $school->refreshImagesFolder();

                        $this->toast( "La galerie des images a été rafraîchie avec succès!", 'success');

                        $this->counter = getRand();

                    } 
                    else{

                        return $this->toast( "Une erreure s'est produite, les images n'ont pas pu être supprimées!", 'error');


                    }  
                }
                else{

                    return $this->toast( "Erreur stockage: Le dossier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Une erreure s'est produite!", 'error');
            }
        }
    }


    public function removeAllVideos()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer toutes les vidéos de {$this->school_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmVideosDeletion', 'confirmButtonText' => 'Tout Supprimer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmVideosDeletion')]
    public function confirmAllVideosRemoving()
    {

        if($this->school){

            $school = $this->school;

            $videos = $school->videos;

            if(!empty($videos)){

                if(Storage::disk('public')->exists($school->folder)){

                    $deleted = $school->videos()->delete();

                    if($deleted){

                        $school->refreshVideosFolder();

                        $this->toast( "La galerie des vidéos a été rafraîchie avec succès!", 'success');

                        $this->counter = getRand();

                    } 
                    else{

                        return $this->toast( "Une erreure s'est produite, les vidéos n'ont pas pu être supprimées!", 'error');


                    }  
                }
                else{

                    return $this->toast( "Erreur stockage: Le dossier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Une erreure s'est produite!", 'error');
            }
        }
    }


    public function removeImageFromImagesOf($image_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une image </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImageDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['image_id' => $image_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImageDeletion')]
    public function confirmImageRemoving($data)
    {
        $image_id = $data['image_id'];

        if($image_id){

            $school = $this->school;

            $image = SchoolImage::where('id', $image_id)->first();

            if($image){

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
    
    public function removeVideoFromVideosOf($video_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

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

            $school = $this->school;

            $video = SchoolVideo::where('id', $video_id)->first();

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


	public function hideSchoolImage($image_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer cette image ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmImageHidden', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['image_id' => $image_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmImageHidden')]
    public function onHideImage($data)
    {
        if($data){

            $image_id = $data['image_id'];

            if($image_id){

                $image = SchoolImage::find($image_id);

                if($image){

                    $message = "L'image " . $image->title . " a été masqué avec succès!";

                    $hidden = $image->update(['is_active' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("L'image n'a pas pu être masquée", 'error');
				}
            }
			else{

				return $this->toast("L'image n'a pas pu être masquée", 'error');
			}

            
        }
    }

	public function hideSchoolVideo($video_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer cette vidéo ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmVideoHidden', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['video_id' => $video_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmVideoHidden')]
    public function onHideVideo($data)
    {
        if($data){

            $video_id = $data['video_id'];

            if($video_id){

                $video = SchoolVideo::find($video_id);

                if($video){

                    $message = "La vidéo " . $video->title . " a été masqué avec succès!";

                    $hidden = $video->update(['is_active' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("La vidéo n'a pas pu être masquée", 'error');
				}
            }
			else{

				return $this->toast("La vidéo n'a pas pu être masquée", 'error');
			}

            
        }
    }

	public function hideAllImages()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer toutes les images? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elles se seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllImages', 'confirmButtonText' => 'Tout masquer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllImages')]
    public function onHideAllImages()
    {
        $message = "Toutes les images publiées sont à présents masquées et donc inacessibles par vos visiteurs!";

		$updates = $this->school->images()->where('school_images.is_active', true)->update(['is_active' => false]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }


	public function hideAllVideos()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer toutes les vidéos? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elles se seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllVideos', 'confirmButtonText' => 'Tout masquer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllVideos')]
    public function onHideAllVideos()
    {
        $message = "Toutes les vidéos publiées sont à présents masquées et donc inacessibles par vos visiteurs!";

		$updates = $this->school->videos()->where('school_videos.is_active', true)->update(['is_active' => false]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }


    public function manageImageTitle($image_id)
    {
        $this->dispatch('ManageSchoolImageData', $image_id);
    }
    
    public function manageVideo($video_id)
    {
        $this->dispatch('ManageSchoolVideoLiveEvent', $this->school->id, $video_id);
    }





}