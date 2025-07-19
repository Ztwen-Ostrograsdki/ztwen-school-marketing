<?php

namespace App\Livewire\Templates;

use Livewire\Component;

class Bubbles extends Component
{
    public $size = 100, $colors = "from-green-300 to-zinc-300 via-green-300", $top = 33, $left = 40;

    public function render()
    {
        return view('livewire.templates.bubbles');
    }
}
