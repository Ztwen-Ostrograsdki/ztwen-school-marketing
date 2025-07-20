<?php

namespace App\Livewire\Master;

use Livewire\Component;

class SchoolProfil extends Component
{
    public $uuid;

    public $simple_name = "CEPG Réussite Assurée";

    public $school_name = "ECOLE";

    public function mount($uuid)
    {
        $this->uuid = $uuid;


    }
    
    public function render()
    {
        return view('livewire.master.school-profil');
    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $stat_id);
    }


    public function manageSchoolInfo($info_id = null)
    {
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }
}
