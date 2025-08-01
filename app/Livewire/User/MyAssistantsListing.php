<?php
namespace App\Livewire\User;



use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\AssistantActionsTraits;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("La liste de mes assistants")]
class MyAssistantsListing extends Component
{
    use ListenToEchoEventsTrait, AssistantActionsTraits;
    
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
        $my_assistants = [];

        $my_assistants = $this->user?->my_assistants;

        return view('livewire.user.my-assistants-listing', compact('my_assistants'));
    }

    public function generateAssistantTokenFor()
    {
        $this->dispatch('AddNewAssistantLiveEvent');

    }


    
}
