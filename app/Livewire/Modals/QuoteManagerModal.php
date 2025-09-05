<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\UpdateUserQuoteEvent;
use App\Models\Quote;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class QuoteManagerModal extends Component
{
    use Toast;

    #[Validate('required|string|max:250')]
    public $content;

    public $quote;

    public $modal_name = "#user-quotes-manager-modal";

    public $counter = 2;


    public function render()
    {
        return view('livewire.modals.quote-manager-modal');
    }

    public function insert()
    {
        $this->validate();

        UpdateUserQuoteEvent::dispatch(auth_user(), $this->content, $this->quote);

        $this->reset();

        self::hideModal();
    }

    #[On('ManageUserQuoteLiveEvent')]
    public function openModal($quote_id = null)
    {
        // $this->reset();

        // if($quote_id){

        //     $quote = Quote::find($quote_id);

        //     if($quote){

        //         $this->quote = $quote;

        //         $this->content = $quote->content;

        //     } 

        // }

        $this->dispatch('OpenModalEvent', $this->modal_name);                                                            
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }
}
