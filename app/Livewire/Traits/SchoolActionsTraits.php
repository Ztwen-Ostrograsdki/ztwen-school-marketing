<?php
namespace App\Livewire\Traits;

use App\Helpers\Robots\SpatieManager;
use App\Models\Info;
use App\Models\Stat;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

/* This trait is to throw all actions on school from all livewire 
	component. 
	
	Principaly in the SchoolProfil Livewire's component
*/
trait SchoolActionsTraits {


	// SCHOOL STATS ACTIONS

	public function deleteSchoolStat($stat_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer cette statistique ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmStatDeletion', 'confirmButtonText' => 'supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['stat_id' => $stat_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmStatDeletion')]
    public function onDeleteStat($data)
    {
        if($data){

            $stat_id = $data['stat_id'];

            if($stat_id){

                $stat = Stat::find($stat_id);

                if($stat){

                    $message = "La statistique de l'examen " . $stat->exam . " " . $stat->year . " a été supprimé avec succès!";

                    $deleted = $stat->delete();

                    if($deleted){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression a échoué", 'error');
        }
    }

    public function hideSchoolStat($stat_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer cette statistique ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmStatHidden', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé', 'data' => ['stat_id' => $stat_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmStatHidden')]
    public function onHideStat($data)
    {
        if($data){

            $stat_id = $data['stat_id'];

            if($stat_id){

                $stat = Stat::find($stat_id);

                if($stat){

                    $message = "La statistique de l'examen " . $stat->exam . " " . $stat->year . " a été masqué avec succès!";

                    $hidden = $stat->update(['is_active' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La statistique n'a pas pu être masquée", 'error');
        }
    }

    public function hideAllStats()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        $phrase = $this->selected_stat_year ? " de l'année {$this->selected_stat_year} " : " publiées jusqu'à présent ";

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer toutes les statistiques {$phrase} ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elles se seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllStats', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllStats')]
    public function onHideAllStats()
    {
        if($this->selected_stat_year){
            $message = "Toutes les statistiques publiées qui sont à présents masquées et donc inacessibles par vos visiteurs!";

            $updates = $this->school->stats()->where('stats.year', $this->selected_stat_year)->where('stats.is_active', true)->update(['is_active' => false]);

            if($updates){

                Notification::sendNow([auth_user()], new RealTimeNotification($message));

                return;
            }

        }
        else{

            $message = "Toutes les statistiques publiées en " . $this->selected_stat_year . " sont masquées et donc inacessibles à présents  par vos visiteurs!";

            $updates = $this->school->stats()->where('stats.is_active', true)->update(['is_active' => false]);

            if($updates){

                Notification::sendNow([auth_user()], new RealTimeNotification($message));

                return;
            }
        }
    }
    
    
    public function unhideSchoolStat($stat_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);

        if($stat_id){

            $stat = Stat::find($stat_id);

            if($stat){

                $message = "La statistique de l'examen " . $stat->exam . " " . $stat->year . " est à nouveau accessible par vos visiteurs!";

                $unhidden = $stat->update(['is_active' => true]);

                if($unhidden){

                    Notification::sendNow([auth_user()], new RealTimeNotification($message));

                    return;
                }

            }
        }

        return $this->toast("La statistique n'a pas pu être rendue visible", 'error');
    }

    public function unhideAllStats()
    {
        if($this->selected_stat_year){
            $message = "Toutes les statistiques publiées qui sont masquées sont à présents accessibles par vos visiteurs!";

            $updates = $this->school->stats()->where('stats.year', $this->selected_stat_year)->where('stats.is_active', false)->update(['is_active' => true]);

            if($updates){

                Notification::sendNow([auth_user()], new RealTimeNotification($message));

                return;
            }

        }
        else{

            $message = "Toutes les statistiques publiées qui sont masquées sont à présents accessibles par vos visiteurs!";

            $updates = $this->school->stats()->where('stats.is_active', false)->update(['is_active' => true]);

            if($updates){

                Notification::sendNow([auth_user()], new RealTimeNotification($message));

                return;
            }
        }
    }


	// SCHOOL INFOS ACTIONS
	public function deleteSchoolInfos($info_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer cette donnée ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmInfoDeletion', 'confirmButtonText' => 'supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['info_id' => $info_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmInfoDeletion')]
    public function onDeleteInfo($data)
    {
        if($data){

            $info_id = $data['info_id'];

            if($info_id){

                $info = Info::find($info_id);

                if($info){

                    $message = "La donnée a été supprimé avec succès!";

                    $deleted = $info->delete();

                    if($deleted){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression a échoué", 'error');
        }
    }

    public function hideSchoolInfo($info_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer cette donnée ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmInfoHidden', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé', 'data' => ['info_id' => $info_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmInfoHidden')]
    public function onHideInfo($data)
    {
        if($data){

            $info_id = $data['info_id'];

            if($info_id){

                $info = Info::find($info_id);

                if($info){

                    $message = "La donnée a été masqué avec succès!";

                    $hidden = $info->update(['is_active' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La donnée n'a pas pu être masquée", 'error');
        }
    }

    public function hideAllInfos()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer toutes les données (infos | communiqués | annonces ) ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elles se seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllInfos', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllInfos')]
    public function onHideAllInfos()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true);

        $message = "Toutes les données (infos | communiqués | annonces ) sont masquées et donc inacessibles à présents  par vos visiteurs!";

		$updates = $this->school->infos()->where('infos.is_active', true)->update(['is_active' => false]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }
    
    
    public function unhideSchoolInfo($info_id)
    {
        if($info_id){

            $info = Info::find($info_id);

            if($info){

                $message = "La donnée est à nouveau accessible par vos visiteurs!";

                $unhidden = $info->update(['is_active' => true]);

                if($unhidden){

                    Notification::sendNow([auth_user()], new RealTimeNotification($message));

                    return;
                }

            }
        }

        return $this->toast("La donnée n'a pas pu être rendue visible", 'error');
    }

    public function unhideAllInfos()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true);

        $message = "Toutes les données (infos | communiqués | annonces) publiées qui sont masquées sont à présents accessibles par vos visiteurs!";

		$updates = $this->school->infos()->where('stats.is_active', false)->update(['is_active' => true]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));

			return;
		}
    }


	public function removeAllImages()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer toutes les images de {$this->school_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImagesDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé'];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImagesDeletion')]
    public function confirmAllImagesRemoving()
    {

        if($this->school){

            $school = $this->school;

            $images = (array)$school->images;

            if(!empty($images)){

                if(Storage::disk('public')->exists($school->folder)){

                    if(Storage::disk('public')->deleteDirectory($school->folder)){

                        $updated = $school->update(['images' => null]);

                        if($updated) $this->toast( "La galerie a été rafraîchie avec succès!", 'success');

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


    public function removeImageFromImagesOf($image_path)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['school-images-manager'], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une image </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImageDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['image_path' => $image_path]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImageDeletion')]
    public function confirmImageRemoving($data)
    {
        $image_path = $data['image_path'];

        if($image_path){

            $school = $this->school;

            $images = (array)$school->images;

            if(in_array($image_path, $images)){

                $image_key = array_keys($images, $image_path)[0];

                if(Storage::disk('public')->exists($image_path)){

                    if(Storage::disk('public')->delete($image_path)){

                        unset($images[$image_key]);

                        $images = array_values($images); 

                        $updated = $school->update(['images' => $images]);

                        if($updated) $this->toast( "L'image a été retirée avec succès!", 'success');

                        $this->counter = getRand();
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

}