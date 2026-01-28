<?php

namespace App\Jobs;

use App\Models\School;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class JobToRefreshSchoolMediaFolder implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public School $school
        )
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $school = $this->school;

        // Notification::sendNow([$school->user], new RealTimeNotification("La mise à jour du  stockage est lancée ..."));
        
        $school->refreshImagesFolder();

        $school->refreshSchoolBestPupilsPhotos();

        $school->refreshSchoolCoverImage();

        $school->refreshVideosFolder();

    }
}
