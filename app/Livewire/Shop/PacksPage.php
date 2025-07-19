<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Boutique des packs")]
class PacksPage extends Component
{
    public function render()
    {
        return view('livewire.shop.packs-page');
    }
}
