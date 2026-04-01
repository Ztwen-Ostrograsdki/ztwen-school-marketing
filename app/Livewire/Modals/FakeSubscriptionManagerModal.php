<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Jobs\JobToGiveFreeSubscription;
use App\Models\Pack;
use App\Models\School;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class FakeSubscriptionManagerModal extends Component
{
    public $modal_name = "#give-subscription-modal";

    use Toast, Confirm;
    
    public $start;

    public $end;

    public $months;

    public $days;

    public $pack;

    public $pack_id;

    public $school;

    public $subscriber;


    public function render()
    {
        $packs = Pack::all();
        
        return view('livewire.modals.fake-subscription-manager-modal', compact('packs'));
    }

    protected function rules()
    {
        return [
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end'   => ['required', 'date', 'after:start'],
            'pack_id' => ['required', 'exists:packs,id'],
        ];
    }


    #[On("GiveSubscriptionModal")]
    public function openModal($school_id)
    {

        if($school_id){

            $school = School::find($school_id);

            if($school){

                $this->school = $school;

                $this->dispatch('OpenModalEvent', $this->modal_name);
            }
        }
    }

    public function updated($field)
    {
        $this->days = (int)$this->days;

        $this->validateOnly($field);
        
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }


    public function insert()
    {
        $start = Carbon::createFromFormat('d/m/Y', $this->start)->format('Y-m-d');

        $end = Carbon::createFromFormat('d/m/Y', $this->end)->format('Y-m-d');

        $duration = getFulldurationBetween2Dates($start, $end);

        $months = Carbon::createFromFormat('d/m/Y', $this->start)->diff($end)->m;

        $data = [
            'months' => $months,
            'will_closed_at' => $end,
            'duration' => $duration
        ];

        $pack = Pack::find($this->pack_id);

        $school = $this->school;

        $receiver = $this->school->user;

        JobToGiveFreeSubscription::dispatch($receiver, $school, $pack, auth_user(), $data);

        $message = "Le processus d'attribution du pack {$pack->name} à l'utilisateur {$receiver->name} pour son école {$school->name} a été lancé!";

        $this->toast($message, 'success');

        $this->hideModal();

        $this->resetErrorBag();

        $this->reset();

    }
}
