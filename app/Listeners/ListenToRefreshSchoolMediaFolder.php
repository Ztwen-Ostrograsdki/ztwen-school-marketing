<?php

namespace App\Listeners;

use App\Events\InitSchoolMediaFolderRefreshingEvent;
use App\Events\SchoolDataUpdatedEvent;
use App\Jobs\JobToRefreshSchoolMediaFolder;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToRefreshSchoolMediaFolder
{
    
    /**
     * Handle the event.
     */
    public function handle(InitSchoolMediaFolderRefreshingEvent $event): void
    {
        Bus::batch([
                new JobToRefreshSchoolMediaFolder($event->school),

            ])
            ->then(function(Batch $batch) use ($event){

                SchoolDataUpdatedEvent::dispatch();

                Notification::sendNow([$event->school->user], new RealTimeNotification("Le stockage a été mis à jour!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "La mise à jour du stockage a échoué ! ERREUR = " . $er->getMessage();                

                Notification::sendNow([$event->school->user], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch){


        })->name('school_media_folder_refreshing')->dispatch();
    
    }
}
