<?php

namespace App\Livewire\Auth;

use App\Events\InitNewPackSubscriptionEvent;
use App\Models\Pack;
use App\Models\School;
use Livewire\Component;

class SubscribePage extends Component
{
    public $pack_uuid, $pack_slug, $token;

    public $email;

    public $school;

    public $school_id, $receiver_name, $receiver_contact, $amount = 0;

    public $amount_to_show;

    public $months = 1;

    public $total;

    public $facture = 0;

    public $free_delay = 0;

    public $reduction = 0;

    public $reduction_to_show = '0 %';

    public $reduction_as_money;

    public $pack, $user;

    public function mount($token, $pack_uuid, $pack_slug)
    {
        if($token && $token == config('app.my_token')){

            if($pack_slug && $pack_uuid){

                $pack = Pack::where('uuid', $pack_uuid)->where('slug', $pack_slug)->where('is_active', true)->firstOrFail();

                if($pack){

                    $this->user = findUser(auth_user_id());

                    $user = $this->user;

                    $this->email = $user->email;

                    $this->receiver_name = $user->getFullName();

                    $this->receiver_contact = $user->contacts;

                    $this->pack = $pack;

                    $this->pack_uuid = $pack_uuid;

                    $this->pack_slug = $pack_slug;

                    $this->token = $token;

                    $this->amount = $pack->price;

                    $this->reduction = $pack->discount;

                    $this->amount_to_show = self::__moneyFormat($this->amount);

                    $this->reduction_to_show = $this->reduction . ' %';

                    $cummul = ($this->amount * $this->months);

                    $total = ($cummul - ($cummul * $this->reduction / 100));

                    $this->facture = $total;

                    $this->total = self::__moneyFormat($total);

                    $this->reduction_as_money = self::__moneyFormat(($this->amount * $this->months) - $total) . ' FCFA';

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

            return abort(403);
        }

    }

    public function render()
    {
        $schools = auth_user()->schools;

        return view('livewire.auth.subscribe-page', compact('schools'));
    }


    public function subscribe()
    {
        $this->resetErrorBag();
        
        $this->validate(
            [
                'school_id' => 'required|numeric|exists:schools,id',
                'receiver_name' => 'required|string',
                'receiver_contact' => 'required|string',
            ]
        );

        $school = School::where('id', $this->school_id)->firstOrFail();

        $pack = $this->pack;

        $data = [
            'receiver_name' => $this->receiver_name,
            'receiver_contact' => $this->receiver_contact,
            'months' => $this->months,
            'total' => $this->facture,
            'unique_price' => $this->pack->price,
            'discount' => $this->reduction
        ];

        $dispatched = InitNewPackSubscriptionEvent::dispatch(auth_user(), $school, $pack, $data);

        if($dispatched){

            $this->toast("Votre demande a été lancé avec succès!", "success");

            $this->reset();

            return redirect()->to($this->user->to_subscribes_route());

            
        }



    }

    public function __moneyFormat($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

    public function updatedMonths($months)
    {
        $cummul = (($this->amount) * $months);

        $total = ($cummul - ($cummul * $this->reduction) / 100);

        $this->facture = $total;

        $this->total = self::__moneyFormat($total);

        $this->reduction_as_money = self::__moneyFormat(($this->amount * $this->months) - $total) . ' FCFA';
    }
}
