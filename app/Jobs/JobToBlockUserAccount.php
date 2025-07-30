<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class JobToBlockUserAccount implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public bool $block_this_user = true)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;

        if($user && !$user->isMaster()){

            $user->userBlockerOrUnblockerRobot($this->block_this_user);
        }
    }
}
