<?php

namespace App\Observers;

use App\Events\AssistantAccessWasUpdatedEvent;
use App\Events\NewAssistanceRequestCreatedEvent;
use App\Jobs\JobToDeleteAssistantRequestAfterDelayed;
use App\Models\AssistantRequest;

class ObserveAssistanceRequest
{
    /**
     * Handle the AssistantRequest "created" event.
     */
    public function created(AssistantRequest $assistantRequest): void
    {
        NewAssistanceRequestCreatedEvent::dispatch($assistantRequest);
        
        JobToDeleteAssistantRequestAfterDelayed::dispatch($assistantRequest)->delay(now()->addHours(24));
    }

    /**
     * Handle the AssistantRequest "updated" event.
     */
    public function updated(AssistantRequest $assistantRequest): void
    {
        AssistantAccessWasUpdatedEvent::dispatch();
    }

    /**
     * Handle the AssistantRequest "deleted" event.
     */
    public function deleted(AssistantRequest $assistantRequest): void
    {
        AssistantAccessWasUpdatedEvent::dispatch();
    }

    /**
     * Handle the AssistantRequest "restored" event.
     */
    public function restored(AssistantRequest $assistantRequest): void
    {
        //
    }

    /**
     * Handle the AssistantRequest "force deleted" event.
     */
    public function forceDeleted(AssistantRequest $assistantRequest): void
    {
        //
    }
}
