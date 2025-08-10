<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\Subscription;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mes abonnements")]
class MySubscribes extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;

    public $counter = 2, $search = "";

    public $subscriptions = [];


    public function mount()
    {
        if(auth_user()){

            $this->subscriptions = findUser(auth_user_id())->subscriptions()->orderBy('created_at', 'desc')->get();
        }
    }

    public function render()
    {
        return view('livewire.user.my-subscribes');
    }


    public function notifyAdminsThatPaymentHasBeenDone($subscription_id)
    {
        if($subscription_id){

            $subscription = Subscription::whereId($subscription_id)->firstOrFail();

            if($subscription){

                $subscription->__notifyAdminsThatPaymentHasBeenDone();

            }
        }
    }
}
