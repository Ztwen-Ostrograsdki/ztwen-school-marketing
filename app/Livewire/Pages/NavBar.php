<?php

namespace App\Livewire\Pages;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\School;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NavBar extends Component
{
    use Toast, Confirm;

    public $counter = 2;


    public function render()
    {
        $subscription_demandes = Subscription::whereNull('validate_at')
                      ->orWhere(function($q){
                            $q->whereNotNull('validate_at')->whereHas('upgrading_requests', function($sq){
                                $sq->whereNull('validate_at');
                            });
                        })->count();

        $subscriptions = Subscription::whereNotNull('validate_at')->count();

        $payments = Payment::whereNotNull('payed_at')->count();

        $schools = School::all()->count();

        $packs = Pack::all()->count();

        return view('livewire.pages.nav-bar', compact('subscription_demandes', 'subscriptions', 'schools', 'packs', 'payments'));
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
