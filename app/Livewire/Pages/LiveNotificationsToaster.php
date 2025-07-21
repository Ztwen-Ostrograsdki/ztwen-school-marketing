<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class LiveNotificationsToaster extends Component
{
    public $counter = 1;

    public function render()
    {

        $toasters_data = [];

        $data = [];

        if(auth_user()) {

            $data = User::find(auth_user()->id)->unreadNotifications;
        }

        foreach($data as $notif){

            $toasters_data[] = $notif;

        }

        return view('livewire.pages.live-notifications-toaster', [
            'toasters_data' => $toasters_data,
        ]);
    }


    #[On("LiveToasterMessagesEvent")]
    public function getToasters()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveNewLiveNotificationEvent")]
    public function realodToaster()
    {
        $this->counter = getRandom();
    }


    public function deleteNotification($id)
    {

        $notif = User::find(auth_user()->id)->unreadNotifications()->where('id', $id)->first();

        if($notif){
            
            $notif->markAsRead();
        }

        $this->counter = getRandom();

    }
    
    public function deleteAllNotifications()
    {

        $notifs  = User::find(auth_user()->id)->unreadNotifications();

        foreach($notifs as $notif){

            $notif->delete();

            $this->counter = getRandom();

        }

        $this->counter = getRandom();

    }
}
