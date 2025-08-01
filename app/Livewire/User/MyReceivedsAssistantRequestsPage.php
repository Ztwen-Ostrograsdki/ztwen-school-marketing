<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\UserDataHasBeenUpdatedEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\AssistantRequest;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title("Requêtes d'assistance reçues")]
class MyReceivedsAssistantRequestsPage extends Component
{
    use ListenToEchoEventsTrait, Toast, Confirm;
    
    public $uuid;

    public $user_id;

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
        $my_assistings = [];

        if($this->user && $this->user->my_directors) $my_assistings = $this->user->my_directors;

        return view('livewire.user.my-receiveds-assistant-requests-page', compact('my_assistings'));
    }

    public function deleteRequest($assistant_request_id, $assistant_name = null)
    {
        $assistant_name = $this->user->getFullName();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer ce requête de vos demande</p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> 
            Vous n'aurez plus accès aux privilèges qui vous ont été accordés pour la gestion de cette école!
        </p>";

        $options = ['event' => 'deleteAssistantReq', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['assistant_request_id' => $assistant_request_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('deleteAssistantReq')]
    public function deleteAssistantFrom($data)
    {
        $assistant_request = AssistantRequest::where('id', $data['assistant_request_id'])->first();

		if($assistant_request){

            $assistant_name = $this->user->getFullName();

            $school_name = $assistant_request->school->name;

            $director = $assistant_request->director;

            $deleted = $assistant_request->delete();

            if($deleted){

                UserDataHasBeenUpdatedEvent::dispatch($this->user);

                $message = "Vous venez de supprimer définitivement la requête de gestion de l'école " . $assistant_request->school->name . "!";

                Notification::sendNow([$director], new RealTimeNotification($assistant_name . " vient de se retirer de la liste de vos assistants de gestion de l'école " . $school_name . " !"));

                Notification::sendNow([$this->user], new RealTimeNotification($message));

                return;
            }
        }
    }

}
