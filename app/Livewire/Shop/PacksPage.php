<?php

namespace App\Livewire\Shop;

use App\Models\Pack;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Boutique des packs")]
class PacksPage extends Component
{
    public function render()
    {
        $packs = Pack::where('is_active', true)->orderBy('price', 'desc')->get();

        return view('livewire.shop.packs-page', compact('packs'));
    }
}
