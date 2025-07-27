<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("La liste de mes assistants")]
class MyAssistantsListing extends Component
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
        return view('livewire.user.my-assistants-listing');
    }

    public function generateAssistantTokenFor()
    {
        $this->dispatch('AddNewAssistantLiveEvent');

    }


    public function openAddAssistantModal()
    {
        // $this->dispatch('AddNewAssistantLiveEvent');
    }
}
