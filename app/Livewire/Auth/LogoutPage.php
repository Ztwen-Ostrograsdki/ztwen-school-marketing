<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class LogoutPage extends Component
{
    use Toast;

    public $modal_name = "#logout-modal";

    public function render()
    {
        return view('livewire.auth.logout-page');
    }

    #[On("LogoutLiveEvent")]
    public function openModal()
    {
        $this->dispatch('OpenModalEvent', $this->modal_name);
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function logout()
    {

        Auth::guard('web')->logout();

        Session::invalidate();
        
        Session::regenerateToken();

        $this->toast("Vous a été déconnecté", 'info');

        return redirect(route('login'));

    }



}
