<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("A propos")]
class AboutUs extends Component
{
    public function render()
    {
        return view('livewire.pages.about-us');
    }
}
