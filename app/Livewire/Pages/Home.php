<?php

namespace App\Livewire\Pages;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use Livewire\Component;

class Home extends Component
{
    use ListenToEchoEventsTrait;
    
    public $counter = 2;


    public function render()
    {
        return view('livewire.pages.home');
    }


    
}
