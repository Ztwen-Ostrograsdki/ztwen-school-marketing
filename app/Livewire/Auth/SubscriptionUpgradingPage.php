<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\UpgradingSubscriptionEvent;
use App\Models\Subscription;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Renouvellement d'un abonnement")]
class SubscriptionUpgradingPage extends Component
{
    use Toast, Confirm;

    public $subscription, $school, $subscriber, $subscription_uuid, $school_uuid, $user, $email, $receiver_contact, $receiver_name;

    public $amount, $total, $amount_to_show, $reduction, $reduction_to_show, $reduction_as_money, $facture, $months = 1, $school_name;

    public function mount($token, $subscription_ref_key, $subscription_uuid,  $school_uuid)
    {
        if($token && $token == config('app.my_token')){

            if($school_uuid && $subscription_uuid && $subscription_ref_key){

                $subscription = Subscription::where('uuid', $subscription_uuid)->where('ref_key', $subscription_ref_key)->where('is_active', true)->firstOrFail();

                if($subscription){

                    if($subscription->school && $subscription->school->uuid == $school_uuid){

                        $this->user = findUser(auth_user_id());

                        $user = $this->user;

                        $this->email = $user->email;

                        $this->receiver_name = $user->getFullName();

                        $this->receiver_contact = $user->contacts;

                        $this->subscription = $subscription;

                        $this->school = $subscription->school;

                        $this->school_name = $subscription->school->name;

                        $this->amount = $subscription->unique_price;

                        $this->reduction = $subscription->discount;

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

                return abort(404);
            }

        }
        else{

            return abort(403);
        }
    }

    public function render()
    {
        return view('livewire.auth.subscription-upgrading-page');
    }

    public function subscribe()
    {
        $this->resetErrorBag();
        
        $this->validate(
            [
                'receiver_name' => 'required|string',
                'receiver_contact' => 'required|string',
            ]
        );

        $data = [
            'receiver_name' => $this->receiver_name,
            'receiver_contact' => $this->receiver_contact,
            'months' => $this->months,
            'total' => $this->facture,
            'unique_price' => $this->subscription->unique_price,
            'discount' => $this->reduction
        ];

        $dispatched = UpgradingSubscriptionEvent::dispatch(auth_user(), $this->subscription, $data);

        if($dispatched){

            $this->toast("Votre demande de réabonnement a été lancé avec succès!", "success");

            return redirect()->to($this->user->to_subscribes_route());

            $this->reset();

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
