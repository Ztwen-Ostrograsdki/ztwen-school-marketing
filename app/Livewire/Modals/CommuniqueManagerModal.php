<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class CommuniqueManagerModal extends Component
{

    public $modal_name = "#infos-manager-modal";

    public $title, $content, $target, $communique_id, $type;

    public function render()
    {
        $infos_types = config('app.infos_types');

        return view('livewire.modals.communique-manager-modal', compact('infos_types'));
    }


    #[On("ManageCommuniqueLiveEvent")]
    public function openModal($communique_id = null)
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
