<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Détails sur un pack")]
class PackProfil extends Component
{
    public $pack_uuid, $pack_slug;

    public function mount($pack_uuid, $pack_slug)
    {
        $this->pack_uuid = $pack_uuid;

        $this->pack_slug = $pack_slug;

    }
    
    public function render()
    {
        return view('livewire.shop.pack-profil');
    }


    public function toPaymentPage()
    {
        
        $token = env('APP_MY_TOKEN');

        return to_route('subscribe.confirmation', ['uuid', $this->uuid, 'slug' => $this->slug, 'token' => $token]);
    }
}
