<?php

namespace App\Observers;

use App\Events\NewSchoolInfoAddedEvent;
use App\Events\SchoolInfoUpdatedEvent;
use App\Models\Info;

class ObserveInfo
{
    /**
     * Handle the Info "created" event.
     */
    public function created(Info $info): void
    {
        NewSchoolInfoAddedEvent::dispatch($info);
    }

    /**
     * Handle the Info "updated" event.
     */
    public function updated(Info $info): void
    {
        SchoolInfoUpdatedEvent::dispatch($info);
    }

    /**
     * Handle the Info "deleted" event.
     */
    public function deleted(Info $info): void
    {
        //
    }

    /**
     * Handle the Info "restored" event.
     */
    public function restored(Info $info): void
    {
        //
    }

    /**
     * Handle the Info "force deleted" event.
     */
    public function forceDeleted(Info $info): void
    {
        //
    }
}
