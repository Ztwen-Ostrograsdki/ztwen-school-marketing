<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\SendConfirmationMailRequestToUserMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class JobToSendConfirmationMailRequestToUser implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $key;


    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?User $user,
    )
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        DB::beginTransaction();
        
        try {

            self::mailBuilder();


            DB::commit();

        } catch (\Throwable $th) {

            to_flash('error', "Une erreur est survenue lors de la génération du lien de confirmation. Veuillez donc réessayer!");
            
            DB::rollBack();

        }

        
    }


    public function mailBuilder()
    {
        $key = generateRandomNumber(6);

        $user = $this->user;

        $lien = route('email.verification', ['token' => env('APP_MY_TOKEN'), 'email' => $user->email, 'key' => $key]);

        $user->forceFill(['password_reset_key' => Hash::make($key)])->save();

        $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

        $html = EmailTemplateBuilder::render('email-confirmation', [
            'lien' => $lien,
            'greating' => $greating,
            'key' => $key
        ]);

        return Mail::to($user->email)->send(new SendConfirmationMailRequestToUserMail($user, $key, $html));
    }
}


