<?php

namespace App\Listeners;

use App\Events\InitializationToCreateNewAssistantRequestEvent;
use App\Jobs\JobToSendEmailToUserForAssistanceRequest;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToAssistanceRequestCreation
{
    public function handle(InitializationToCreateNewAssistantRequestEvent $event): void
    {
        
        $batch = Bus::batch([

            new JobToSendEmailToUserForAssistanceRequest($event->sender, $event->receiver, $event->school, $event->privileges),

        ])->then(function(Batch $batch) use ($event){


        })
        ->catch(function(Batch $batch, Throwable $er) use ($event){

            $message = "Une erreure s'est produite lors de génération de la requête d'affiliation de " . $event->receiver->getFullName() . " en tant que assistant de gestion de l'école " . $event->school->name . " que vous avez lancé!";

            Notification::sendNow([$event->sender], new RealTimeNotification($message));

            
        })->finally(function(Batch $batch){


        })->name('new_assistance_created')->dispatch();
    }
}
