<?php
namespace App\Livewire\Traits;

use App\Helpers\Robots\SpatieManager;
use App\Jobs\JobToDeleteSchool;
use App\Models\Info;
use App\Models\School;
use App\Models\SchoolFollower;
use App\Models\SchoolImage;
use App\Models\SchoolVideo;
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

        $options = ['event' => 'confirmToHideAllStats', 'confirmButtonText' => 'Tout masquer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllStats')]
    public function onHideAllStats()
    {
        if($this->selected_stat_year){
            $message = "Toutes les statistiques publiées sont à présents masquées et donc inacessibles par vos visiteurs!";

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

        $options = ['event' => 'confirmInfoDeletion', 'confirmButtonText' => 'Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['info_id' => $info_id]];

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

        $options = ['event' => 'confirmToHideAllInfos', 'confirmButtonText' => 'Tout Masquer', 'cancelButtonText' => 'Annuler'];

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

    public function likeAndFollow()
    {
        SchoolFollower::create(['school_id' => $this->school->id, 'follower_id' => auth_user_id() ?? null]);
    }


    public function lockSchoolProfil($school_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment verrouiller cette école ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle ne sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmSchoolLocked', 'confirmButtonText' => 'Verouiller profil', 'cancelButtonText' => 'Annulé', 'data' => ['school_id' => $school_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmSchoolLocked')]
    public function onLockSchoolProfil($data)
    {
        if($data){

            $school_id = $data['school_id'];

            if($school_id){

                $school = School::find($school_id);

                if($school){

                    $name = $school->name;

                    $message = "L'école " . $name . " a été verouillée avec succès!";
                    
					$locked = $school->update(['is_active' => false]);

                    if($locked){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("Le verouillage de l'école a échoué", 'error');
        }
    }
    
    public function unlockSchoolProfil($school_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment activer le profil cette école ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle sera plus de nouveau visible et accessible par vos visiteurs! </p>";

        $options = ['event' => 'activateSchoolProfil', 'confirmButtonText' => 'Activer profil', 'cancelButtonText' => 'Annulé', 'data' => ['school_id' => $school_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('activateSchoolProfil')]
    public function onActivateSchoolProfil($data)
    {
        if($data){

            $school_id = $data['school_id'];

            if($school_id){

                $school = School::find($school_id);

                if($school){

                    $name = $school->name;

                    $message = "Le profil de l'école " . $name . " a été activé avec succès!";
                    
					$activate = $school->update(['is_active' => true]);

                    if($activate){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("L'activation du profil de l'école a échoué", 'error');
        }
    }
    
    public function deleteSchool($school_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer cette école ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Les données de cette école seront définitivement supprimées ainsi que l'école! Elle ne sera plus disponible sur la plateforme</p>";

        $options = ['event' => 'deleteSchool', 'confirmButtonText' => 'Supprimer cette école', 'cancelButtonText' => 'Annulé', 'data' => ['school_id' => $school_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('deleteSchool')]
    public function onDeleteSchool($data)
    {
        if($data){

            $school_id = $data['school_id'];

            if($school_id){

                $school = School::find($school_id);

                if($school){

                    $name = $school->name;

                    $message = "La suppresion définitive de l'école " . $name . " a été lancée avec succès!";
                    
					$deleting = JobToDeleteSchool::dispatch($school, auth_user());

                    if($deleting){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression de l'école a échoué", 'error');
        }
    }
    
    public function resetSchoolData($school_id)
    {
        
    }

}