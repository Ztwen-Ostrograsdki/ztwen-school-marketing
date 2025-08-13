<?php

namespace App\Livewire\Page;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Subscription;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Page des details d'un abonnement")]
class SubscriptionDetailsPage extends Component
{
    use Toast, Confirm;

    public $subscription;

    public $subscriber;

    public $school;

    public function mount($subscription_uuid, $subscription_id)
    {
        if($subscription_uuid && $subscription_id){

            $subscription = Subscription::where('uuid', $subscription_uuid)->whereId($subscription_id)->firstOrFail();

            if($subscription){

                $user = findUser(auth_user_id());

                if($user->isAdminsOrMaster() || $user->id == $subscription->subscriber->id){

                    $this->subscription = $subscription;

                    $this->subscriber = $subscription->subscriber;

                    $this->school = $subscription->school;
                }
                else{

                    return abort(403);
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
        return view('livewire.page.subscription-details-page');
    }
}
