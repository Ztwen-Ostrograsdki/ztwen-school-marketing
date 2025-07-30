<?php

namespace App\Jobs;

use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobToUnlockUserAccount implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public int $waiting_for = 0
    )
    {
        $this->delay = $waiting_for;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {

            $this->user->userBlockerOrUnblockerRobot(false);

            DB::commit();

            DB::afterCommit(function(){

                $user = $this->user;

                $lien = $user->to_profil_route();

                $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

                $message = "Votre compte " . env('APP_NAME') . " est a nouveau actif";

                JobToSendSimpleMailMessageTo::dispatch($user->email, $greating, $message, "COMPTE DEBLOQUE", null, $lien);


            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        
    }
}
