<?php

namespace App\Observers;

use App\Jobs\JobToSendWelcomeMessageToNewsLetterSubscriber;
use App\Models\NewsLetterSubscriber;

class ObserveNewsLetterSubscriber
{
    /**
     * Handle the NewsLetterSubscriber "created" event.
     */
    public function created(NewsLetterSubscriber $newsLetterSubscriber): void
    {
        $email = $newsLetterSubscriber->email;

        JobToSendWelcomeMessageToNewsLetterSubscriber::dispatch($email);
    }

    /**
     * Handle the NewsLetterSubscriber "updated" event.
     */
    public function updated(NewsLetterSubscriber $newsLetterSubscriber): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscriber "deleted" event.
     */
    public function deleted(NewsLetterSubscriber $newsLetterSubscriber): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscriber "restored" event.
     */
    public function restored(NewsLetterSubscriber $newsLetterSubscriber): void
    {
        //
    }

    /**
     * Handle the NewsLetterSubscriber "force deleted" event.
     */
    public function forceDeleted(NewsLetterSubscriber $newsLetterSubscriber): void
    {
        //
    }
}
