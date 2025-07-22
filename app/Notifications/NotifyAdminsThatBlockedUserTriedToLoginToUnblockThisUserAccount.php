<?php

namespace App\Notifications;

use App\Helpers\Robots\ModelsRobots;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminsThatBlockedUserTriedToLoginToUnblockThisUserAccount extends Notification
{
    use Queueable;

    public $blocked_user;

    public $title;

    public $object;

    public $content;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $blocked_user, $title = null, $object = null, $content = null)
    {
        $this->blocked_user = $blocked_user;

        $this->title = $title;

        $this->object = $object;

        $this->content = $content;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->blocked_user;

        $salutation = ModelsRobots::greatingMessage($notifiable->getUserNamePrefix(true, false));

        return (new MailMessage)
            ->subject($this->title . " : " . $this->object)
            ->greeting($salutation)
            ->line('Vous recevez ce courriel parce que vous êtes un administrateur actif de ' . config('app.name') . '!')
            ->line("L'utilisateur " . $user->getFullName() . " dont l'adresse mail est " . $user->email . "  a tenté de se connecté!")
            ->line($this->content)
            ->line("Vous pouvez procéder au déblocage ou non de ce compte;")
            ->action("Proccéder à l'analyse du compte de " . $user->getFullName() . " !" , url($user->to_profil_route()));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
