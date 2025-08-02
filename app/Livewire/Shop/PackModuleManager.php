<?php

namespace App\Livewire\Shop;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Pack;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;



#[Title("Gestion des packs")]
class PackModuleManager extends Component
{
    use Toast, Confirm;

    public $pack_uuid, $pack_slug, $pack;

    #[Validate("string|required")]
    public $name;

    public $slug;

    #[Validate("numeric|required")]
    public $max_images;

    #[Validate("numeric|required")]
    public $max_assistants;

    #[Validate("numeric|required")]
    public $max_infos;

    #[Validate("numeric|required")]
    public $max_stats;

    public bool $on_page = false;

    public $privileges = [];

    #[Validate("numeric|required")]
    public $discount;

    #[Validate("numeric|required")]
    public $price;

    public bool $notify_by_sms = false;

    public bool $notify_by_email = false;

    public bool $promoting = false;

    #[Validate("numeric|required")]
    public $promo_price;


    public function mount($token, $pack_uuid = null, $pack_slug = null)
    {
        if($token){

            if($token == env('APP_MY_TOKEN')){

                if($pack_slug && $pack_uuid){

                    $pack = Pack::where('slug', $pack_slug)->where('uuid', $pack_uuid)->firstOrFail();

                    if($pack){

                        $this->pack = $pack;

                        self::initDefaultValues($pack);
                    }

                }
            }
            else{

                return abort(403);
            }

        }
        else{

            return abort(404);
        }
    }


    public function initDefaultValues($pack)
    {
        $this->name = $pack->name;
        $this->privileges = $pack->privileges;
        $this->price = $pack->price;
        $this->discount = $pack->discount;
        $this->max_images = $pack->max_images;
        $this->max_infos = $pack->max_infos;
        $this->max_stats = $pack->max_stats;
        $this->max_assistants = $pack->max_assistants;
        $this->name = $pack->name;
    }


    public function render()
    {
        return view('livewire.shop.pack-module-manager');
    }


    public function insert()
    {
        $this->validate();
    }


}
