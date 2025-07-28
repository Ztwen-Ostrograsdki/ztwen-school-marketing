<?php

namespace App\Jobs;

use App\Helpers\Services\EmailTemplateBuilder;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Mail\MailToSendAssistanceRequestToUser;
use App\Models\AssistantRequest;
use App\Models\School;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class JobToSendEmailToUserForAssistanceRequest implements ShouldQueue
{
    use Queueable, Batchable;

    public $message_to_sender;

    public $message_to_receiver;

    public $assistant_request;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $sender, public User $receiver, public School $school, public array $privileges)
    {
        //
    }

    public function handle(): void
    {

        DB::beginTransaction();
        
        try {

            $key = self::generateAssistantRequest();

            DB::commit();

            DB::afterCommit(function() use ($key){

                self::mailBuilder($key);

                Notification::sendNow([$this->sender], new RealTimeNotification($this->message_to_sender));

                Notification::sendNow([$this->receiver], new RealTimeNotification($this->message_to_receiver));

            });

        } catch (\Throwable $th) {

            to_flash('error', "Une erreur est survenue lors de la génération du lien de confirmation. Veuillez donc réessayer!");
            
            DB::rollBack();

        }

        
    }


    public function mailBuilder($key)
    {

        $school = $this->school;

        $sender = $this->sender;

        $receiver = $this->receiver;

        $privileges = $this->privileges;

        $privileges_translates = [];

        foreach($privileges as $p){

            $privileges_translates[] = __translateRoleName($p);

        }

        $school = $this->school;

        $lien_for_sender = $sender->to_profil_route();

        $lien_for_receiver = $this->assistant_request->to_assistant_request_route($key);

        $greating_sender = $sender->greatingMessage($sender->getUserNamePrefix(true, false)) . ", ";

        $receiver_html = EmailTemplateBuilder::render('email-for-assistant-request', [
            'lien' => $lien_for_receiver,
            'greating' => $greating_sender,
            'key' => $key,
            'sender_name' => $sender->getFullName(true),
            'school_name' => $school->name,
            'privileges' => implode(" - ", $privileges_translates),
        ]);

        Mail::to($receiver->email)->send(new MailToSendAssistanceRequestToUser($receiver, $key, $receiver_html));


        JobToSendSimpleMailMessageTo::dispatch($sender->email, $sender->getFullName(true), $this->message_to_receiver, "Demande d'assistance de gestion d'école", null, $lien_for_sender);
    }


    public function generateAssistantRequest()
    {
        $key = generateRandomNumber(6);

        $delay = Carbon::now()->addHours(24);

        $last = "####" . substr($key, -2);

        $this->message_to_sender = "Votre clé d'affiliation pour assistance a été générée avec succès! Cette clé est : {$last}  . Elle expirera le " . __formatDateTime($delay) . ". Cette clé est utilisable seulement par " . $this->receiver->getUserNamePrefix(true, true) . " utilisateur(s). Elle sera détruite automatiquement juste après utilisation ou après expiration.";

        $this->message_to_receiver = $this->sender->getUserNamePrefix(true, true) . " vous a envoyé une demande d'assistance de gestion d'école. La clé est : {$last} (Vérifier votre boîte mail) . Elle expirera le " . __formatDateTime($delay) . ".  Elle sera détruite automatiquement juste après l' utilisation ou après expiration.";

        $data = [
            'token' => Hash::make($key),
            'assistant_id' => $this->receiver->id,
            'delay' => $delay,
            'user_id' => $this->sender->id,
            'school_id' => $this->school->id,
            'privileges' => $this->privileges
        ];

        $created = AssistantRequest::create($data);

        if($created){

            $this->assistant_request = $created;

            return $created;

        }

        return false;
       
    }
}
