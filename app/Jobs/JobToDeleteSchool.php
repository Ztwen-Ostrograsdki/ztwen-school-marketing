<?php

namespace App\Jobs;

use App\Models\School;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class JobToDeleteSchool implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public School $school,
        public User $admin_generator
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $school_name = $this->school->name;

        $school_folder = $this->school->folder;

        $school = $this->school;

        try {

            $school->delete();

            DB::commit();

            DB::afterCommit(function() use($school_name, $school_folder){

                Storage::disk('public')->deleteDirectory($school_folder);

                $message_to_creator = "L'école " . $school_name . " a été supprimée avec succès!";

                Notification::sendNow([$this->admin_generator], new RealTimeNotification($message_to_creator));

            });


        } catch (\Throwable $th) {

            DB::rollback();

            $message_to_creator = "La suppression de l'école " . $school_name . " a échoué! " . $th->getMessage();

            Notification::sendNow([$this->admin_generator], new RealTimeNotification($message_to_creator));

            $this->fail();
        }
    }
}
