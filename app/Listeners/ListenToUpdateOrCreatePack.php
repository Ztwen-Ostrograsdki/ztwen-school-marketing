<?php

namespace App\Listeners;

use App\Events\InitPackProcessToCreateOrUpdateEvent;
use App\Events\PacksHasBeenUpdatedEvent;
use App\Jobs\JobToUpdateOrCreatePack;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToUpdateOrCreatePack
{
    /**
     * Handle the event.
     */
    public function handle(InitPackProcessToCreateOrUpdateEvent $event): void
    {
        Bus::batch([
                new JobToUpdateOrCreatePack($event->admin_generator, $event->data, $event->pack),

            ])
            ->progress(function(Batch $batch) use ($event){

            })
            ->then(function(Batch $batch) use ($event){

                PacksHasBeenUpdatedEvent::dispatch();

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("La boutique des packs a été mise à jour!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La crétion du pack a échoué!";                

                Notification::sendNow([$event->admin_generator], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('pack_managing')->dispatch();
    
    }
}
