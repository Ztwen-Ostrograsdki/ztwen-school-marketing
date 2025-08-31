<?php

namespace App\Livewire\Traits;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\PlannedTaskToDelayedSubscriptionEvent;
use App\Helpers\Robots\SpatieManager;
use App\Models\Subscription;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    public function onConfirmSubscription($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

					$subscription->__subcriptionApprobationManager(auth_user());

                }
            }
            else{

                return $this->toast("la validation de la demande a échoué", 'error');
            }

            
        }
    }
    
    
    public function markAsExpired($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        if($subscription_id){

            $subscription = Subscription::find($subscription_id);

            if($subscription && $subscription->remainingsDays > 0){

                $expired_date = __formatDateTime($subscription->will_closed_at);

                $remainingsDays = $subscription->remainingsDays;

                $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment plannifier la tâche d'expiration de cet abonnement ? </p>
                </h6>";

                $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cet abonnement expire le {$expired_date} soit dans 
                {$remainingsDays} jours. Cela signifira que cet abonnement sera inactif et les privilèges dissouts une fois la tâche exécutée! </p>";

                $options = ['event' => 'subscriptionExpired', 'confirmButtonText' => 'Plannifier', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

                $this->confirm($html, $noback, $options);

            }
            elseif($subscription && $subscription->remainingsDays < 0){

                $expired_date = __formatDateTime($subscription->will_closed_at);

                $remainingsDays = $subscription->remainingsDays;

                $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment expirer cet abonnement ? </p>
                </h6>";

                $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cet abonnement a déjà expiré depuis le {$expired_date} soit depuis 
                {$remainingsDays} jours.</p>";

                $options = ['event' => 'subscriptionExpired', 'confirmButtonText' => 'Expirer', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

                $this->confirm($html, $noback, $options);

            }
        }

       
    }

    #[On('subscriptionExpired')]
    public function onsubscriptionExpired($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

                    if(!$subscription->hasPlannedDelayedTask()){

                        PlannedTaskToDelayedSubscriptionEvent::dispatch(auth_user(), [$subscription_id]);
                    }
                    else{

                        $this->toast("L'abonnement " . $subscription->ref_key . " a déjà une tâche plannifiée en cours.");

                    }
                }
            }
            else{

                return $this->toast("Le processus de plannification  d'expiration de l'abonnement a échoué", 'error');
            }

            
        }
    }




	public function activateSubscriptionRequest($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment activer cet abonnement ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action fera que l'abonnement sera de nouveau actif! </p>";

        $options = ['event' => 'confirmPackSubscriptionActivation', 'confirmButtonText' => 'Activer', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPackSubscriptionActivation')]
    public function onUnlockPackSubscription($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

					DB::beginTransaction();

                    try {

                        $report = config('app.subcriptions_task_report');

                        $locked_at = Carbon::parse($subscription->locked_at);

                        $will_closed_at = Carbon::parse($subscription->will_closed_at);

                        $hours_passed_since_locked = $locked_at->diffInHours(null, true);

                        if($will_closed_at > now()){

                            //Expired date not yet passed

                            $exipired_at = $will_closed_at->addHours($hours_passed_since_locked);

                            $subscription->update(['is_active' => true, 'will_closed_at' => $exipired_at, 'locked_at' => null]);


                        }
                        else{

                            //Expired date passed

                            $exipired_at = now()->addHours($hours_passed_since_locked)->addDays(3);

                            $subscription->update(['is_active' => true, 'will_closed_at' => $exipired_at, 'locked_at' => null]);
                            
                        }

                        $subscription->definePlannedTask($report);

                        DB::commit();

                        DB::afterCommit(function() use ($subscription){

                            $name = $subscription->ref_key;

                            $message = "L'abonnement " . $name . " a été réactivé avec succès!";

                            Notification::sendNow([auth_user()], new RealTimeNotification($message));

                            return;

                        });


                    } catch (\Throwable $th) {
                        
                        $message = "ERREURE (REACTIVATION ABONNEMENT) : La réactivation de l'abonnement " . $subscription->ref_key . " souscrit par " . $subscription->subscriber->getFullName() . " pour l'école " . $subscription->school->name . " a échoué. DETAILS : " . $th->getMessage();

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));
                        
                        DB::rollBack();
                    }

                }
                else{

                    return $this->toast("L'activation a échoué", 'error');
                }
            }
            else{

                return $this->toast("L'activation a échoué", 'error');


            }

        }
    }
    
    public function blockSubscriptionRequest($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment suspendre cet abonnement ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action fera que l'abonnement sera inactif et l'école concernée sera considérée commme non abonnée </p>";

        $options = ['event' => 'confirmPackSubscriptionLocked', 'confirmButtonText' => 'Suspendre', 'cancelButtonText' => 'Annuler', 'data' => ['subscription_id' => $subscription_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmPackSubscriptionLocked')]
    public function onLockPackSubscription($data)
    {
        if($data){

            $subscription_id = $data['subscription_id'];

            if($subscription_id){

                $subscription = Subscription::find($subscription_id);

                if($subscription){

                    DB::beginTransaction();

					try {

                        $subscription->update(['is_active' => false, 'locked_at' => now()]);

                        $report = config('app.subcriptions_task_report');

                        if($subscription->hasPlannedDelayedTask($report)){

                            $subscription->deletePlannedTask($report);

                        }

                        DB::commit();

                        DB::afterCommit(function() use ($subscription){

                            $name = $subscription->ref_key;

                            $message = "L'abonnement " . $name . " a été suspendu avec succès!";

                            Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        });
                        

                    } catch (\Throwable $th) {

                        $message = "ERREURE (SUSPENSION ABONNEMENT) : La suspension de l'abonnement " . $subscription->ref_key . " souscrit par " . $subscription->subscriber->getFullName() . " pour l'école " . $subscription->school->name . " a échoué. DETAILS : " . $th->getMessage();

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));
                        
                        DB::rollBack();

                    }

                }
                else{

                    return $this->toast("La suspension a échoué", 'error');
                }
            }
            else{

                return $this->toast("La suspension a échoué", 'error');
            }

            
        }
    }
    
    
    public function deleteSubscriptionRequest($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer cette demande d'abonnement ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmPackSubscriptionDeletion', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['subscription_id' => $subscription_id]];

        $this->confirm($html, $noback, $options);
    }



    #[On('confirmPackSubscriptionDeletion')]
    public function onDeletePackSubscription($data)
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

    public function nofifySubscriberToPaidSubscriptionUpgradeRequestForValidation($subscription_upgrade_request_id)
    {

    }

    public function deleteSubscriptionUpgradeRequest($subscription_upgrade_request_id)
    {

    }
    
    public function approvedSouscriptionUpgradeRequest($subscription_upgrade_request_id)
    {

    }

    public function deleteAllRequests()
    {

    }

    public function approvedAllRequests()
    {

    }

    public function exiredAllDelayedsSubscriptions()
    {

    }

    public function nofifySubscribersThatExpiredDateIsSoClose()
    {

    }
    
    
    public function nofifySubscriberThatExpiredDateIsSoClose($subscription_id)
    {
        SpatieManager::ensureThatUserCan();

        if($subscription_id){

            $subscription = Subscription::find($subscription_id);

            if($subscription){

                $subscription->__rememberDaysRemainingToSubscriber(auth_user());

                return $this->toast("Un rappel a été envoyé à " . $subscription->subscriber->getFullName() . " pour lui rappeler la date d'expiration de son abonnement en cours!", 'success');

            }
        }
    }





}
