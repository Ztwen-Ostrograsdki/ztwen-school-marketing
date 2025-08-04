<?php

namespace App\Jobs;

use App\Models\Pack;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class JobToUpdateOrCreatePack implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $admin_generator, public ?array $data = null, public ?Pack $pack = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $created_pack = null;

        try {

            $data = $this->data;

            if($this->pack){

                $this->pack->update($data);

            }
            else{

                $created_pack = Pack::create($data);

            }

            DB::commit();


            DB::afterCommit(function() use($created_pack){

                if($this->pack){

                    $message_to_creator = "Les données du pack " . $this->pack->name . " ont été mises à jour avec succès!";

                    Notification::sendNow([$this->admin_generator], new RealTimeNotification($message_to_creator));

                }
                elseif($created_pack){

                    $message_to_creator = "La creation du pack " . $created_pack->name . " s'est achevée avec succès!";

                    Notification::sendNow([$this->admin_generator], new RealTimeNotification($message_to_creator));

                }

            });
            

        } catch (\Throwable $th) {

            $message_to_creator = "Une erreure est survenue lors de la creation du pack : " . $th->getMessage();

            Notification::sendNow([$this->admin_generator], new RealTimeNotification($message_to_creator));

            DB::rollBack();
        }

        
    }
}
