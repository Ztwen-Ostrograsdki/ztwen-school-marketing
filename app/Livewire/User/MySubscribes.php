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

            $search = '%' . $this->search . '%';

            $this->subscriptions = Subscription::where('user_id', auth_user_id())->where(function($query) use ($search){

                $query->whereNull('validate_at')->orWhere(function($q) use ($search){

                    if(!($search && strlen($search) > 3)){

                        $q->where('is_active', true)->whereNotNull('validate_at')->where('will_closed_at', '>', now());

                    }
                    else{

                        $q->where('is_active', true)->whereNotNull('validate_at')->where('will_closed_at', '>', now())->where('ref_key', 'like', $search);
                    }

                });

            })->orderBy('created_at', 'desc')->get();
            
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

    public function updatedSearch($search)
    {
        $search = '%' . $this->search . '%';

        $this->subscriptions = Subscription::where('user_id', auth_user_id())->where(function($query) use ($search){

            $query->whereNull('validate_at')->orWhere(function($q) use ($search){

                if(!($search && strlen($search) > 3)){

                    $q->where('is_active', true)->whereNotNull('validate_at')->where('will_closed_at', '>', now());

                }
                else{

                    $q->where('is_active', true)->whereNotNull('validate_at')->where('will_closed_at', '>', now())->where('ref_key', 'like', $search);
                }

            });

        })->orderBy('created_at', 'desc')->get();
            
    }


    public function displaySubscriptionDetails($subscription_id)
    {
        $subscription = Subscription::where('id', $subscription_id)->firstOrFail();

        return redirect($subscription->to_details_route());
    }
}
