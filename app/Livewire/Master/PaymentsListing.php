<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Robots\SpatieManager;
use App\Models\Payment;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Les payements effectués")]
class PaymentsListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;
    
    public $counter = 2, $search = "";

    public $payments = [];


    public function mount()
    {

        $search = '%' . $this->search . '%';

        $this->payments = Payment::where(function($query) use ($search){

            if(!($search && strlen($search) > 3)){

                $query->whereNotNull('payed_at');

            }
            else{

                $query->whereNotNull('payed_at')->whereAny(['uuid', 'contacts', 'amount', 'email', 'payment_status'], 'like', $search);
            }

        })->orderBy('payed_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.master.payments-listing');
    }


    public function updatedSearch($search)
    {
        $search = '%' . $this->search . '%';

        $this->payments = Payment::where(function($query) use ($search){

            if(!($search && strlen($search) > 3)){

                $query->whereNotNull('payed_at');

            }
            else{

                $query->whereNotNull('payed_at')->whereAny(['uuid', 'contacts', 'amount', 'email', 'payment_status'], 'like', $search);
            }

        })->orderBy('payed_at', 'desc')->get();
    }


    public function deleteSubscriptionRequest($payment_id)
    {
        SpatieManager::ensureThatUserCan();

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer ce payement enregistré ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmPaymentDeletion', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['payment_id' => $payment_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmPaymentDeletion')]
    public function onDeletePayment($data)
    {
        if($data){

            $payment_id = $data['payment_id'];

            if($payment_id){

                $payment = Payment::find($payment_id);

                if($payment){

					$ref_key = $payment->ref_key;

                    $objet = $payment->subscription_upgrading_request_id ? "le réabonnement" : "l'abonnement";

                    $message = "Le payement enregistré pour " . $objet . " " . $ref_key . " a été supprimé avec succès!";

                    $deleted = $payment->delete();

                    if($deleted){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
            }

            return $this->toast("La suppression a échoué", 'error');
        }
    }
}
