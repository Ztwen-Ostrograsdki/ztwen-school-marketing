<?php

namespace App\Jobs;

use App\Helpers\Robots\ModelsRobots;
use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\SendSimpleMailMessageMail;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class JobToSendSimpleMailMessageToAdmins implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $message,
        public $objet,
        public $file_to_attach_path = null,
        public $lien = null
    )
    {
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = ModelsRobots::getAllAdmins();

        if(!empty($admins)){

            foreach($admins as $admin){

                $lien = $this->lien ? $this->lien : route('admin');

                $objet = $this->objet ? $this->objet : "Un courriel pour vous";

                $html = EmailTemplateBuilder::render('simple-mail-message', [
                    'lien' => $lien,
                    'full_name' => $admin->getFullName(),
                    'mail_message' => $this->message,
                    'objet' => $objet,
                ]);

                Mail::to($admin->email)->send(new SendSimpleMailMessageMail($admin->email, $admin->getFullName(), $this->message, $this->objet, $this->file_to_attach_path, $html));

                Notification::sendNow([$admin], new RealTimeNotification($this->message));
                
            }

            
        }
    }
}
