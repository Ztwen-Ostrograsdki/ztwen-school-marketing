<?php

namespace App\Listeners;

use App\Events\InitProcessToRefreshPackDataFromConfigEvent;
use App\Events\PacksHasBeenUpdatedEvent;
use App\Jobs\JobToRefreshPackDataFromConfig;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Throwable;

class ListenToRefreshPackDataFromConfig
{
   

    /**
     * Handle the event.
     */
    public function handle(InitProcessToRefreshPackDataFromConfigEvent $event): void
    {
        DB::beginTransaction();

        try {

            $pack = $event->pack;

            if($pack){

                $pack->update(['is_active' => false]);

            }
            Bus::batch([

                new JobToRefreshPackDataFromConfig($event->admin_generator, $event->pack, $event->data),

            ])
            ->progress(function(Batch $batch) use ($event){

            })
            ->then(function(Batch $batch) use ($event){

                Notification::sendNow([$event->admin_generator], new RealTimeNotification("Le rechargement des données du pack depuis les fichiers de configuration s'est achevé avec succès!"));

            })
            ->catch(function(Batch $batch, Throwable $er) use ($event){

                $message_to_creator = "Le rechargement des données du pack depuis les fichiers de configuration a échoué : " . $er->getMessage();                

                Notification::sendNow([$event->admin_generator], new RealTimeNotification($message_to_creator));

            })

            ->finally(function(Batch $batch) use ($pack){

                if($pack){

                    $pack->update(['is_active' => true]);

                }


        })->name('pack_refreshing')->dispatch();

        DB::commit();

        
        } catch (\Throwable $th) {

            DB::rollBack();
            
        }
    }
}
