<?php

namespace App\Livewire\Auth;

use App\Models\Pack;
use Livewire\Component;

class SubscribePage extends Component
{
    public $pack_uuid, $pack_slug, $token;

    public $email;

    public $school = "VOTRE ECOLE";

    public $amount = 30000;

    public $amount_to_show;

    public $months = 1;

    public $total;

    public $free_delay = 15;

    public $reduction = 5;

    public $reduction_to_show = '0 %';

    public $reduction_as_money;

    public $contacts = "01525562662";

    public $pack;

    public function mount($token, $pack_uuid, $pack_slug)
    {
        $this->pack_uuid = $pack_uuid;

        $this->pack_slug = $pack_slug;

        $this->token = $token;

        $this->pack = Pack::where('uuid', $pack_uuid)->where('slug', $pack_slug)->where('is_active', true)->firstOrFail();

        $this->amount_to_show = self::__moneyFormat($this->amount);

        $this->reduction_to_show = $this->reduction . ' %';

        $cummul = ($this->amount * $this->months);

        $total = ($cummul - ($cummul * $this->reduction / 100));

        $this->total = self::__moneyFormat($total);

        $this->reduction_as_money = self::__moneyFormat(($this->amount * $this->months) - $total) . ' FCFA';

        if($token !== config('app.my_token')){

            return abort(403);
        }

    }

    public function render()
    {
        return view('livewire.auth.subscribe-page');
    }

    public function __moneyFormat($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

    public function updatedMonths($months)
    {
        $cummul = (($this->amount) * $months);

        $total = ($cummul - ($cummul * $this->reduction) / 100);

        $this->total = self::__moneyFormat($total);

        $this->reduction_as_money = self::__moneyFormat(($this->amount * $this->months) - $total) . ' FCFA';
    }
}
