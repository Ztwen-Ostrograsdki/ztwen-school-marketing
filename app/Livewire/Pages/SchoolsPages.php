<?php

namespace App\Livewire\Pages;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Services\SubscriptionsDelayedService;
use App\Models\School;
use App\Models\SchoolFollower;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Liste des écoles - Trouver une école")]
class SchoolsPages extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;

    public $schools = [], $counter = 3;

    public function mount()
    {
        $this->schools = School::where('is_active', true)->whereHas('subscriptions', function($q){

            $q->whereNotNull('validate_at')
              ->where('will_closed_at', '>', now())
              ->where('is_active', true);

        })->with('current_subscription')->get();

        SubscriptionsDelayedService::runner($this->schools ?? null);
    }

    public function likeAndFollow($school_id)
    {
        SchoolFollower::create(['school_id' => $school_id, 'follower_id' => auth_user_id() ?? null]);
    }



    public function render()
    {
        return view('livewire.pages.schools-pages');
    }
}
