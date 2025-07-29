<?php

namespace App\Jobs;

use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\AssistantRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Queue\SerializesModels;

class JobToDeleteAssistantRequestAfterDelayed implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $assistant_name, $school_name, $created_at, $message_to_sender, $message_to_assistant, $sender_name, $assistant_email, $sender_email;

    /**
     * Create a new job instance.
    */
    public function __construct(public AssistantRequest $assistant_request)
    {
        $this->assistant_name = $assistant_request->assistant->getUserNamePrefix(true, false);

        $this->assistant_email = $assistant_request->assistant->email;

        $this->sender_name = $assistant_request->user->getFullName();

        $this->sender_email = $assistant_request->user->email;


        $this->message_to_sender = "Votre demande d'assistance pour l'école " . $assistant_request->school->name . " envoyée le " . __formatDateTime($assistant_request->delay) . " à " . $assistant_request->assistant->getUserNamePrefix(true, false) . " a expiré sans être approuvée! Elle a donc été supprimée! Vous pouvez relancer la demande à tout moment.";

        $this->message_to_assistant = "La demande d'assistance pour l'école " . $assistant_request->school->name . " qui vous a été envoyée le " . __formatDateTime($assistant_request->delay) . " par " . $assistant_request->user->getUserNamePrefix(true, false) . " a expiré sans votre approbation! Elle a donc été supprimée!";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(!$this->assistant_request->exists){

            return;
        }


        $assistant_request = $this->assistant_request;

        if($assistant_request->delay && ($assistant_request->status !== 'Approuvé' || !$assistant_request->approved_at)){

            $deleted = $assistant_request->delete();

            if($deleted){

                JobToSendSimpleMailMessageTo::dispatch($this->assistant_email, $this->assistant_name, $this->message_to_assistant, "DEMANDE EXPIREE", null, null);

                JobToSendSimpleMailMessageTo::dispatch($this->sender_email, $this->sender_name, $this->message_to_sender, "DEMANDE EXPIREE", null, null);

            }
        }
    }

    public function middleware() : array
    {
        return [
            Skip::when(!$this->assistant_request->exists),

        ];
    }
}
