<?php
namespace App\Livewire\Traits;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToRefreshPackDataFromConfigEvent;
use App\Helpers\Robots\SpatieManager;
use App\Models\Pack;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;

trait PackActionsTraits{

	use Toast, Confirm;


	public function loadPackDataFromConfig($pack_id)
    {
		SpatieManager::ensureThatUserCan();

		$pack = Pack::find($pack_id);


		$this->toast("Le rechargement des données du pack depuis les fichiers de configuration a été lancé", 'success');

		InitProcessToRefreshPackDataFromConfigEvent::dispatch(auth_user(), $pack);
    }


	public function unHidePack($pack_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment rencre cet pack visible sur la plateforme ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmPackUnhidden', 'confirmButtonText' => 'Rendre visible', 'cancelButtonText' => 'Annulé', 'data' => ['pack_id' => $pack_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPackUnhidden')]
    public function onUnhidePack($data)
    {
        if($data){

            $pack_id = $data['pack_id'];

            if($pack_id){

                $pack = Pack::find($pack_id);

                if($pack){

                    $name = $pack->name;

                    $message = "Le pack " . $name . " a été rendu visible avec succès!";
                    
					$unhidden = $pack->update(['is_active' => true]);

                    if($unhidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("Le pack n'a pas pu être rendu visible", 'error');
        }
    }

	public function hidePack($pack_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer cet pack ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Elle se sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmPackHidden', 'confirmButtonText' => 'Masqué', 'cancelButtonText' => 'Annulé', 'data' => ['pack_id' => $pack_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPackHidden')]
    public function onHidePack($data)
    {
        if($data){

            $pack_id = $data['pack_id'];

            if($pack_id){

                $pack = Pack::find($pack_id);

                if($pack){

                    $name = $pack->name;

                    $message = "Le pack " . $name . " a été masqué avec succès!";
                    
					$hidden = $pack->update(['is_active' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("Le pack n'a pas pu être masquée", 'error');
        }
    }

	public function deletePack($pack_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer ce pack ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmPackDeletion', 'confirmButtonText' => 'Supprimé', 'cancelButtonText' => 'Annulé', 'data' => ['pack_id' => $pack_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmPackDeletion')]
    public function onDeletePack($data)
    {
        if($data){

            $pack_id = $data['pack_id'];

            if($pack_id){

                $pack = Pack::find($pack_id);

                if($pack){

					$name = $pack->name;

                    $message = "Le pack " . $name . " a été supprimé avec succès!";

                    // $deleted = $pack->delete();

                    $deleted = false;

                    if($deleted){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression a échoué", 'error');
        }
    }





}