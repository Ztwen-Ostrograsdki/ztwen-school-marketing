<?php

namespace App\Jobs;

use App\Helpers\Services\PacksManagerService;
use App\Models\Pack;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class JobToRefreshPackDataFromConfig implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $admin_generator, public ?Pack $pack = null, public ?array $data = [])
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pack = $this->pack;

        DB::beginTransaction();

        try {

            $privileges = PacksManagerService::getPrivileges($pack->name);

            $details = PacksManagerService::getDetails($pack->name);

            $pack->privileges = $privileges;

            $pack->save();

            $pack->update($details);

            DB::commit();



        } catch (\Throwable $th) {

            DB::rollBack();

            
        }
    }
}
