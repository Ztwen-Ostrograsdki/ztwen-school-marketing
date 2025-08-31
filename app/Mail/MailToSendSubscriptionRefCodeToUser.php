<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailToSendSubscriptionRefCodeToUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $user,
        public $key,
        public $html,
        public bool $to_upgrade = false
    )
    {
        
    }

    public function build()
    {
        $user = $this->user;

        $name = $user->getFullName(true);

        return $this->subject("Bonjour  $name")
                    ->html($this->html);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if(!$this->to_upgrade) : 
            return new Envelope(
                subject: "Code de validation abonnement",
            );
        else :
            return new Envelope(
                subject: "Code de validation réabonnement",
            );
        endif;
    }

   
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            
        ];
    }
}
