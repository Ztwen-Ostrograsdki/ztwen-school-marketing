<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\User;
use Livewire\Attributes\Locked;
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

    public function deleteRequest()
    {
        

    }
}
