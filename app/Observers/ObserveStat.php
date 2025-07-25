<?php

namespace App\Observers;

use App\Events\NewSchoolStatAddedEvent;
use App\Events\SchoolStatUpdatedEvent;
use App\Models\Stat;

class ObserveStat
{
    /**
     * Handle the Stat "created" event.
     */
    public function created(Stat $stat): void
    {
        NewSchoolStatAddedEvent::dispatch($stat->school);
    }

    /**
     * Handle the Stat "updated" event.
     */
    public function updated(Stat $stat): void
    {
        SchoolStatUpdatedEvent::dispatch($stat->school);
    }

    /**
     * Handle the Stat "deleted" event.
     */
    public function deleting(Stat $stat): void
    {
        SchoolStatUpdatedEvent::dispatch($stat->school);
    }

    /**
     * Handle the Stat "restored" event.
     */
    public function restored(Stat $stat): void
    {
        //
    }

    /**
     * Handle the Stat "force deleted" event.
     */
    public function forceDeleted(Stat $stat): void
    {
        //
    }
}
