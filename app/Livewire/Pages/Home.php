<?php

namespace App\Livewire\Pages;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\Quote;
use Livewire\Component;

class Home extends Component
{
    use ListenToEchoEventsTrait;
    
    public $counter = 2;


    public function render()
    {
        $quotes = Quote::where('hidden', false)->inRandomOrder()->take(5)->get();
        
        return view('livewire.pages.home', compact('quotes'));
    }


    
}
