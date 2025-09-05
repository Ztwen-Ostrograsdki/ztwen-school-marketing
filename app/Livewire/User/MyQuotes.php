<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mes Citations")]
class MyQuotes extends Component
{
    use Toast, Confirm;

    public $user, $id, $uuid;

    public $counter = 0;

    public $quotes;
    public $quoteId = null;
    public $content;

    public $showForm = false;
    public $isEditing = false;

    public function mount($id, $uuid)
    {
        if($id && $uuid){

            $user = User::where('identifiant', $id)->where('uuid', $uuid)->firstOrFail();

            if($user){

                $this->user = $user;

                $this->quotes = $user->quotes()->latest()->get();

            }
        }
        else{

            return abort(404);
        }

    }

   

    protected $rules = [
        'content' => 'required|string|min:20'
    ];


    public function showCreateForm()
    {
        $this->resetErrorBag();
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function showEditForm($id)
    {
        $quote = Quote::findOrFail($id);
        $this->quoteId = $quote->id;
        $this->content = $quote->content;
        $this->showForm = true;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            Quote::find($this->quoteId)->update(['content' => $this->content]);
        } else {
            Quote::create(['content' => $this->content, 'user_id' => auth_user_id()]);
        }

        $this->resetForm();
        $this->quotes = Quote::latest()->get();
        $this->showForm = false;
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->isEditing = false;
    }

    public function resetForm()
    {
        $this->quoteId = null;
        $this->content = '';
    }



    public function render()
    {
        $max_quotables = config('app.max_quotes_by_user');

        return view('livewire.user.my-quotes', compact('max_quotables'));
    }


    public function manageQuote($quote_id = null)
    {
        if(Gate::denies('is_self_user', $this->user->id)){

            return abort(403, "Action non authorisée!");
        }

        $this->dispatch('ManageUserQuoteLiveEvent', $quote_id);
    }
    
    public function deleteQuote($quote_id)
    {

        if(Gate::denies('is_self_user', $this->user->id)){

            return abort(403, "Action non authorisée!");
        }

        $quote = Quote::find($quote_id);

        if($quote){

            $content = $quote->content;

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer la citation  </p>
                            <p class='text-sky-600 py-0 my-0 font-semibold'> {$content} </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedQuoteDeletion', 'confirmButtonText' => 'Supprimer', 'cancelButtonText' => 'Annulé', 'data' => ['quote_id' => $quote_id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedQuoteDeletion')]
    public function onConfirmationQuoteDeletion($data)
    {
        if($data){

            $quote_id = $data['quote_id'];

            $quote = Quote::find($quote_id);

            if($quote){

                $quote->delete();

                $this->toast( "La citation  a été supprimée avec succès!", 'success');

                $this->counter = getRand();

            }
            else{

                $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
            }

        }

       

    }



    #[On('LiveUpdateQuotesListEvent')]
    public function reloadData($data = null)
    {
        $this->counter = getRand();
    }
}
