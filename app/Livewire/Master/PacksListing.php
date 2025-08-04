<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\PackActionsTraits;
use App\Models\Pack;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des packs disponibles")]
class PacksListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, PackActionsTraits;

    public $counter = 2;

    public $search = '';


    public function render()
    {
        $packs = Pack::all();
        
        return view('livewire.master.packs-listing', compact('packs'));
    }



}
