<?php

namespace App\Livewire\Pages;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NavBar extends Component
{
    use Toast, Confirm;

    public $counter = 2;


    public function render()
    {
        return view('livewire.pages.nav-bar');
    }

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $stat_id);
    }


    public function manageSchoolInfo($info_id = null)
    {
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }



    public function newNotification($user = null)
    {
        $this->counter = getRandom();

        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


    #[On('LiveLogoutUserEvent')]
    public function logout($ev = null)
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        $this->toast("Vous avez été déconneté avec succès!!!");

        return redirect(route('login'));

    }

    

    #[On("LiveToasterMessagesEvent")]
    public function getToasters()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveNewLiveNotificationEvent")]
    public function realodToaster()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveNotificationDispatchedToAdminsSuccessfullyEvent")]
    public function adminsRealodToaster()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveUserDataHasBeenUpdatedEvent")]
    public function userDataUpdated()
    {
        $this->counter = getRandom();
    }
}
