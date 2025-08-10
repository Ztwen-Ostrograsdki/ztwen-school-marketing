<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\PackSusbscriptionActionsTraits;
use App\Models\Subscription;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des souscriptions reçues")]
class PackSubscriptionsListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, PackSusbscriptionActionsTraits;

    public $counter = 2, $search = "";

    public $subscriptions = [];


    public function mount()
    {
        $this->subscriptions = Subscription::where('validate_at', null)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.master.pack-subscriptions-listing');
    }






}
