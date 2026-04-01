<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\PackSusbscriptionActionsTraits;
use App\Models\Subscription;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des abonnements approuvés et payés")]
class AbonnementsListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, PackSusbscriptionActionsTraits;

    public $counter = 2, $search = "";

    public $subscriptions = [];

    public $subscribers = [];

    public $selected = 'not_expired';

    public $selecteds = [
        'all' => "Tous",
        'expired' => "Tout type expirés", 
        'not_expired' => "Tout type Non expirés", 
        'not_frees_all' => "Abonnements non offerts : tous",
        'not_frees_not_expired' => "Abonnements non offerts : actifs",
        'not_frees_expired' => "Abonnements non offerts : expirés",
        'frees_all' => "Abonnements offerts : tous", 
        'frees_not_expired' => "Abonnements offerts : actifs", 
        'frees_expired' => "Abonnements offerts : expirés", 
    ];

    public $subscriber_id;

    public $subscriber;


    public function mount()
    {
        $search = '%' . $this->search . '%';

        if(session()->has('selected_subscription') && session('selected_subscription')){

            $this->selected = session('selected_subscription');

        }
        if(session()->has('subscriber_selected_subscription') && session('subscriber_selected_subscription')){

            $this->subscriber_id = session('subscriber_selected_subscription');

            $this->subscriber = findUser($this->subscriber_id);

        }

        $this->subscriptions = Subscription::where(function($query) use ($search){

            if(($search && strlen($search) > 3)){

                $query->whereNotNull('validate_at')->where('ref_key', 'like', $search);
            }
            if($this->selected){

                $query = self::getQuery($query);
            }
            if($this->subscriber_id){
                
                $query = $query->where('user_id', $this->subscriber_id);
            }

        })->orderBy('validate_at', 'desc')->get();

        $this->subscribers = User::whereHas('validateds_subscriptions')->orderBy('firstname', 'asc')->orderBy('lastname', 'asc')->get();
    }

    public function render()
    {
        $delayeds = Subscription::whereNotNull('validate_at')->where('will_closed_at', '<', now())->where('expired', false)->count();

        return view('livewire.master.abonnements-listing', compact('delayeds'));
    }


    public function updatedSelected($selected)
    {
        if($this->selected){

            session()->put('selected_subscription', $selected);

            $query = Subscription::whereNotNull('validate_at');

            $query = self::getQuery($query);

            if($this->subscriber_id){
                
                $query = $query->where('user_id', $this->subscriber_id);
            }

            $this->subscriptions = $query->orderBy('validate_at', 'desc')->get();
        }
        else{

            session()->forget('selected_subscription');

            $query = Subscription::whereNotNull('validate_at');

            $query = self::getQuery($query);

            if($this->subscriber_id){
                
                $query = $query->where('user_id', $this->subscriber_id);
            }

            $this->subscriptions = $query->orderBy('validate_at', 'desc')->get();
        }
    }


    public function updatedSubscriberId($subscriber_id)
    {
        $query = Subscription::whereNotNull('validate_at');

        if($subscriber_id){

            session()->put('subscriber_selected_subscription', $subscriber_id);

            $this->subscriber = findUser($subscriber_id);

            $query = $query->where('user_id', $subscriber_id);

            if($this->selected){

                $query = self::getQuery($query);
            }

            $this->subscriptions = $query->orderBy('validate_at', 'desc')->get();
        }
        else{

            $this->subscriber = null;

            if($this->selected){

                $query = self::getQuery($query);
            }

            $this->subscriptions = $query->orderBy('validate_at', 'desc')->get();

            session()->forget('subscriber_selected_subscription');
        }
    }

    public function updatedSearch($search)
    {
        $search = '%' . $this->search . '%';

        $this->subscriptions = Subscription::where(function($query) use ($search){

            if(($search && strlen($search) > 3)){

                $query->whereNotNull('validate_at')->where('ref_key', 'like', $search)->orWhereHas('user', function($q) use ($search){

                    $q->whereAny(['firstname', 'lastname', 'email'], 'like', $search);

                });

            }
            if($this->selected){

                $query = self::getQuery($query);
            }
            if($this->subscriber_id){
                
                $query = $query->where('user_id', $this->subscriber_id);
            }

        })->orderBy('created_at', 'desc')->get();
    }

    public function getQuery($query)
    {
        if($this->selected == 'all'){

            $query->whereNotNull('validate_at');      
        }
        elseif($this->selected == 'not_expired'){

            $query->where('expired', false);
        }
        elseif($this->selected == 'expired'){

            $query->where('expired', true);
        }
        elseif($this->selected == 'not_frees_all'){

            $query->where('is_free', false);
        }
        elseif($this->selected == 'not_frees_not_expired'){

            $query->where('is_free', false)->where('expired', false);
        }
        elseif($this->selected == 'not_frees_expired'){

            $query->where('is_free', false)->where('expired', true);
        }
        elseif($this->selected == 'frees_all'){

            $query->where('is_free', true);
        }
        elseif($this->selected == 'frees_not_expired'){

            $query->where('is_free', true)->where('expired', false);
           
        }
        elseif($this->selected == 'frees_expired'){

            $query->where('is_free', true)->where('expired', true);
        }

        return $query;
    }

    public function resetSelections()
    {
        $this->reset('selected', 'subscriber', 'subscriber_id');

        session()->forget('subscriber_selected_subscription');

        session()->put('selected_subscription', $this->selected);

        $query = Subscription::whereNotNull('validate_at');

        $query = self::getQuery($query);

        $this->subscriptions = $query->orderBy('validate_at', 'desc')->get();
    }
}
