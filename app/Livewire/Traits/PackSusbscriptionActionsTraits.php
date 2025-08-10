<?php

namespace App\Livewire\Traits;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\SpatieManager;
use App\Models\Subscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;

trait PackSusbscriptionActionsTraits {

	use Toast, Confirm;


	public function approvedSouscription($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment approuver cette demande ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cela signifira que cette demande a été soldée! </p>";

        $options = ['event' => 'confirmSubscription', 'confirmButtonText' => 'Approuvée', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmSubscription')]
    public function oncConfirmSubscription($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

                    $name = $subscription->ref_key;

                    $message = "La souscription " . $name . " a été approuvée avec succès!";
                    
					$done = $subscription->__subcriptionApprobationManager(auth_user());

                    if($done){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("la validation de la demande a échoué", 'error');
        }
    }




	public function deleteSubscriptionRequest($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer cette demande d'abonnement ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmPackDeletion', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmPackDeletion')]
    public function onDeletePack($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

					$name = $subscription->ref_key;

                    $message = "La demande " . $name . " a été supprimée  a été supprimé avec succès!";

                    $deleted = $subscription->delete();

                    if($deleted){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression a échoué", 'error');
        }
    }


    public function nofifySubscriberToPaidSubscriptionForValidation($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        if($subscription_id){

            $subscription = Subscription::find($subscription_id);

            if($subscription){

                $subscription->__notifySubscriberToFinalyseSubscriptionByPayingToValidateIt(auth_user());

                return $this->toast("Un rappel a été envoyé à " . $subscription->subscriber->getFullName() . " afin qu'il procède au payement de sa souscription", 'success');

            }
        }
    }


    public function deleteAllRequests()
    {

    }


    public function approvedAllRequests()
    {
        
    }





}
