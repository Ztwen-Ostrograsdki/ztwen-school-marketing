<?php

namespace App\Listeners;

use App\Events\UpdateUserQuoteEvent;
use App\Jobs\JobToManageUserQuote;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToUpdateUserQuote
{
    /**
     * Handle the event.
     */
    public function handle(UpdateUserQuoteEvent $event): void
    {
        $batch = Bus::batch([

            new JobToManageUserQuote($event->user, $event->content, $event->quote)
            ])->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->user], new RealTimeNotification("La citation a bien été enregistrée et publiée!"));
                
            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                Notification::sendNow([$event->user], new RealTimeNotification("L'insertion de la citation a échoué!"));

            })

            ->finally(function(Batch $batch){


        })->name('user_quote_manager')->dispatch();
    }
}
