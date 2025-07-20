<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class StatsManagerModal extends Component
{
    public $modal_name = "#stats-manager-modal";

    public $title, $stat, $year, $stat_id;

    public function render()
    {
        return view('livewire.modals.stats-manager-modal');
    }

    #[On("ManageStatLiveEvent")]
    public function openModal($stat_id = null)
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function insert()
    {
        

    }
}
