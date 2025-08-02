<?php

namespace App\Livewire\Traits;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\AssistantAccessWasUpdatedEvent;
use App\Events\UserDataHasBeenUpdatedEvent;
use App\Models\AssistantRequest;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;

trait AssistantActionsTraits{

	use Toast, Confirm;

	public function lockAccess($assistant_request_id, $assistant_name = null)
    {
        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment verrouiller l'accès à {$assistant_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> 
            {$assistant_name} n'aura plus accès aux privilèges de gestion jusqu'au devérouillage !
        </p>";

        $options = ['event' => 'lockAccess', 'confirmButtonText' => 'Verrouiller', 'cancelButtonText' => 'Annulé', 'data' => ['assistant_request_id' => $assistant_request_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('lockAccess')]
    public function onLockAccess($data)
    {
        $assistant_request = AssistantRequest::where('id', $data['assistant_request_id'])->first();

		if($assistant_request){

            $updates = $assistant_request->update(['is_active' => false]);

            if($updates){

                $message = "Vous venez de vérouiller les privilèges de " . $assistant_request->assistant->getFullName() . " : Il n'aura plus accès à la gestion de votre école jusqu'à sa réactivation!";

                Notification::sendNow([$assistant_request->director], new RealTimeNotification($message));

                return;
            }
        }
    }


    public function unlockAccess($assistant_request_id, $assistant_name = null)
    {

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment réactiver les privilèges de {$assistant_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> 
            {$assistant_name} aura de nouveau accès aux privilèges de gestion de votre page!
        </p>";

        $options = ['event' => 'unlockAccess', 'confirmButtonText' => 'Déverrouiller', 'cancelButtonText' => 'Annulé', 'data' => ['assistant_request_id' => $assistant_request_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('unlockAccess')]
    public function onUnlockAccess($data)
    {
        $assistant_request = AssistantRequest::where('id', $data['assistant_request_id'])->first();

		if($assistant_request){

            $updates = $assistant_request->update(['is_active' => true]);

            if($updates){

                $message = "Vous venez de réactiver les privilèges de " . $assistant_request->assistant->getFullName() . " : Il aura de nouveau accès à la gestion de votre page!";

                Notification::sendNow([$assistant_request->director], new RealTimeNotification($message));

                return;
            }
        }
    }
    
    
    public function deleteAssistant($assistant_request_id, $assistant_name = null)
    {
        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer {$assistant_name} de vos assistants</p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> 
            {$assistant_name} sera retirer définitivement des assistants de gestion de votre page!
        </p>";

        $options = ['event' => 'deleteAssistantReq', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['assistant_request_id' => $assistant_request_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('deleteAssistantReq')]
    public function deleteAssistantFrom($data)
    {
        $assistant_request = AssistantRequest::where('id', $data['assistant_request_id'])->first();

		if($assistant_request){

            $assistant_name = $assistant_request->assistant->getFullName();

            $school_name = $assistant_request->school->name;

            $director = $assistant_request->director;

            $deleted = $assistant_request->delete();

            if($deleted){

                $message = "Vous venez de supprimer définitivement " . $assistant_name . " de gestion de l'école " . $school_name . "!";

                Notification::sendNow([$director], new RealTimeNotification($message));

                return;
            }
        }
    }


    public function manageAssistant($assistant_request_id)
    {
        $this->dispatch('ManageAssistantPrivileges', $assistant_request_id);

    }

}