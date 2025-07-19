<?php

namespace App\Livewire\Shop;

use Livewire\Component;

class PackProfil extends Component
{
    public $uuid, $slug;

    public function mount($uuid, $slug)
    {
        $this->uuid = $uuid;

        $this->slug = $slug;

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
