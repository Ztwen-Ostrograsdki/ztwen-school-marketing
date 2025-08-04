<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\PackActionsTraits;
use App\Models\Pack;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Page de gestion d'un pack")]
class PackProfil extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, PackActionsTraits;

    public $counter = 3;

    public $token, $pack_uuid, $pack_slug, $pack;

     

    public function mount($token, $pack_uuid, $pack_slug)
    {

        if($token){

            if($token == config('app.my_token')){

                if($pack_slug && $pack_uuid){

                    $pack = Pack::whereSlug($pack_slug)->whereUuid($pack_uuid)->firstOrFail();

                    if($pack){

                        $this->pack_uuid = $pack_uuid;

                        $this->pack_slug = $pack_slug;

                        $this->pack = $pack;

                    }
                    else{

                        return abort(404);
                    }
                }
                else{

                    return abort(404);
                }
            }
            else{

                return abort(404);
            }
        }
        else{

            return abort(404);
        }

        

    }

    public function render()
    {
        return view('livewire.master.pack-profil');
    }
}
