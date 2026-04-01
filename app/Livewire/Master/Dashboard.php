<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    use ListenToEchoEventsTrait;
    
    public function render()
    {
        $subscription_demandes = Subscription::whereNull('validate_at')
                      ->orWhere(function($q){
                            $q->whereNotNull('validate_at')->whereHas('upgrading_requests', function($sq){
                                $sq->whereNull('validate_at');
                            });
                        })->count();

        $users = User::whereNotNull('email_verified_at')->count();

        $subscriptions = Subscription::whereNotNull('validate_at')->where('will_closed_at', '>', now())->count();

        $payments = Payment::whereNotNull('payed_at')->count();

        $schools = School::all()->count();

        $packs = Pack::all()->count();

        return view('livewire.master.dashboard', compact('subscription_demandes', 'subscriptions', 'schools', 'packs', 'payments', 'users'));
    }
}
