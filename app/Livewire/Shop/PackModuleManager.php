<?php

namespace App\Livewire\Shop;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitPackProcessToCreateOrUpdateEvent;
use App\Helpers\Robots\SpatieManager;
use App\Helpers\Services\PacksManagerService;
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

    public $discount = 0;

    #[Validate("numeric|required")]
    public $price;

    public bool $notify_by_sms = false;

    public bool $notify_by_email = false;

    public bool $promoting = false;

    public $app_packs = [];

    public $app_pack_privileges = [];

    #[Validate("numeric|required")]
    public $promo_price;


    public function mount($token, $pack_uuid = null, $pack_slug = null)
    {
        if($token){

            if($token == config('app.my_token')){

                if($pack_slug && $pack_uuid){

                    $pack = Pack::where('slug', $pack_slug)->where('uuid', $pack_uuid)->firstOrFail();

                    if($pack){

                        $this->pack = $pack;

                        self::initDefaultValues($pack);
                    }


                }

                $this->app_packs = PacksManagerService::getPacks();
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

        $this->privileges = (array)$pack->privileges;

        $this->price = $pack->price;

        $this->discount = $pack->discount;

        $this->max_images = $pack->max_images;

        $this->max_infos = $pack->max_infos;

        $this->max_stats = $pack->max_stats;

        $this->max_assistants = $pack->max_assistants;

        $this->promo_price = $pack->promo_price;

        $this->notify_by_email = $pack->notify_by_email;

        $this->notify_by_sms = $pack->notify_by_sms;

        $this->promo_price = $pack->promo_price;

    }


    public function render()
    {
        return view('livewire.shop.pack-module-manager');
    }


    public function insert()
    {
        SpatieManager::ensureThatUserCan();
        
        $this->validate();

        if(!$this->pack){

            $this->validate(['name' => 'required|unique:packs,name']);
        }

        $data = [
            'name' => $this->name,
            'discount' => $this->discount,
            'price' => $this->price,
            'privileges' => $this->privileges,
            'max_images' => $this->max_images,
            'max_assistants' => $this->max_assistants,
            'max_infos' => $this->max_infos,
            'max_stats' => $this->max_stats,
            'promo_price' => $this->promo_price,
            'notify_by_email' => $this->notify_by_email,
            'notify_by_sms' => $this->notify_by_sms,
        ];

        $dispatched = InitPackProcessToCreateOrUpdateEvent::dispatch(auth_user(), $data, $this->pack);

        if($dispatched) $this->reset('price', 'promo_price', 'discount', 'name', 'privileges', 'max_infos', 'max_stats', 'max_images', 'max_assistants', 'notify_by_email', 'notify_by_sms');

    }


    public function updatedName($name)
    {
        $privileges = PacksManagerService::getPrivileges($name);

        $this->privileges = $privileges;

        $max = PacksManagerService::getDetails($name);

        $this->max_images = $max['max_images'];

        $this->max_stats = $max['max_stats'];

        $this->max_assistants = $max['max_assistants'];

        $this->max_infos = $max['max_infos'];

    }


    public function updatedPrice($price)
    {
        $discount = $this->discount;

        if($discount){

            $this->promo_price = ($price - ($price * $discount) / 100);

        }
    }

    public function updatedPromoPrice($promo_price)
    {
        
    }

    public function updatedDiscount($discount)
    {
        $price = $this->price;

        if($price){

            $this->promo_price = ($price - ($price * $discount) / 100);

        }
    }

}
