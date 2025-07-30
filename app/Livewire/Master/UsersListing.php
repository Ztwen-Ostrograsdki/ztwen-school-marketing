<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitProcessToBlockUserAccountEvent;
use App\Events\InitProcessToDeleteUserAccountEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Robots\SpatieManager;
use App\Livewire\Traits\UserActionsTraits;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des utilisateurs de la plateforme")]
class UsersListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, UserActionsTraits;

    public $search = '';

    public $section = 'all';

    public $counter = null;

    public $paginate_page = 10;

    public $selected_users = [];

    public $display_select_cases = false;

    public function render()
    {
        $p = $this->paginate_page;

        if(session()->has('users_list_section')){

            $this->section = session('users_list_section');
        }

        $users = User::orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->paginate($p);

        $sections = config('app.users_list_sections');

        if($this->search && strlen($this->search) >= 2){

            $s = '%' . $this->search . '%';

            $users = User::where('firstname', 'like', $s)
                         ->orWhere('lastname', 'like', $s)
                         ->orWhere('email', 'like', $s)
                         ->orWhere('contacts', 'like', $s)
                         ->orWhere('pseudo', 'like', $s)
                         ->orWhere('address', 'like', $s)
                         ->orWhere('city', 'like', $s)
                         ->orWhere('gender', 'like', $s)
                         ->orWhere('identifiant', 'like', $s)
                         ->orWhere('department', 'like', $s)
                         ->orWhere('marital_status', 'like', $s)
                         ->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')
                         ->paginate($p);
        }
        
        return view('livewire.master.users-listing', compact('users', 'sections'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSection($section)
    {
        session()->put('users_list_section', $section);

        $this->section = $section;
    }

    

}
