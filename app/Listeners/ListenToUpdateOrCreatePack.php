<?php

namespace App\Listeners;

use App\Events\InitPackProcessToCreateOrUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenToUpdateOrCreatePack
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InitPackProcessToCreateOrUpdateEvent $event): void
    {
        //
    }
}
