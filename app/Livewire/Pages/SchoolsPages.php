<?php

namespace App\Livewire\Pages;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\School;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des écoles - Trouver une école")]
class SchoolsPages extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;

    public $counter = 3;



    public function render()
    {
        $schools = School::whereNotNull('name')->get();
        
        return view('livewire.pages.schools-pages', compact('schools'));
    }
}
