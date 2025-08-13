<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\PackSusbscriptionActionsTraits;
use App\Models\Subscription;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des abonnements approuvés et payés")]
class AbonnementsListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, PackSusbscriptionActionsTraits;

    public $counter = 2, $search = "";

    public $subscriptions = [];


    public function mount()
    {

        $search = '%' . $this->search . '%';

        $this->subscriptions = Subscription::where(function($query) use ($search){

            if(!($search && strlen($search) > 3)){

                $query->whereNotNull('validate_at');

            }
            else{

                $query->whereNotNull('validate_at')->where('ref_key', 'like', $search);
            }

        })->orderBy('validate_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.master.abonnements-listing');
    }

    public function updatedSearch($search)
    {
        $search = '%' . $this->search . '%';

        $this->subscriptions = Subscription::where(function($query) use ($search){

            if(!($search && strlen($search) > 3)){

                $query->whereNull('validate_at');

            }
            else{

                $query->whereNull('validate_at')->where('ref_key', 'like', $search);
            }

        })->orderBy('created_at', 'desc')->get();
    }
}
