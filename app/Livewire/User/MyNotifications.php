<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mes notifications")]
class MyNotifications extends Component
{
    use ListenToEchoEventsTrait, Toast, Confirm;

    public $counter = 1;

    public $sectionned = 'unread';

    public $search = '';

    public $uuid, $user_id;

    public $user_name;

    public $user_email;

    public $user;

    public function mount($id, $uuid)
    {
        if($id && $uuid){

            $user = User::where('identifiant', $id)->where('uuid', $uuid)->firstOrFail();

            if($user){

                $this->user_id = $id;

                $this->uuid = $uuid;

                $this->user = $user;

                $this->user_name = $user->getFullName();

                $this->user_email = $user->email;
            }
        }
        else{

            return abort(404);
        }

    }


    public function render()
    {
        if(session()->has('my-notification-section')){

            $this->sectionned = session('my-notification-section');

        }
        
        $user = auth_user();

        $search = null;

        $notif_sections = [
            'unread' => "Non lues",
            'read' => "Déjà lues",
            'all' => "Toutes les notifications",
        ];

        $my_notifications = [];

        $data = [];

        if($this->sectionned == 'read') {

            $data = User::find(auth_user()->id)->readNotifications();
        }
        elseif($this->sectionned == 'unread') {

            $data = User::find(auth_user()->id)->unreadNotifications();
        }
        elseif($this->sectionned == 'all') {

            $data = User::find(auth_user()->id)->notifications();
        }
        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;

            $tag = ['%' . $search . '%'];

            if($data){

                $data = $data->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.message')) LIKE ?", $tag);
            }
            
        }

        

        foreach($data->get() as $notif){

            $my_notifications[] = $notif;

        }

        return view('livewire.user.my-notifications', compact('my_notifications', 'notif_sections'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSectionned($sectionned)
    {
        $this->sectionned = $sectionned;

        session()->put('my-notification-section', $sectionned);
    }

    #[On("LiveIHaveNewNotificationEvent")]
    public function reloadNotificationsData($user = null)
    {
        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


   

    public function deleteNotification($notif_id)
    {
        
        $notif = User::find(auth_user()->id)->unreadNotifications()->where('id', $notif_id)->first();

        if($notif){
            
            $notif->markAsRead();
        }

        $this->counter = getRandom();
       
    }

    public function deleteAllNotifications()
    {
        
       $notifs  = User::find(auth_user()->id)->notifications;

        foreach($notifs as $notif){

            $notif->delete();

            $this->counter = getRandom();

        }

        $this->counter = getRandom();
    }



    public function markAllAsRead($section = null)
    {
        $notifs  = User::find(auth_user()->id)->unreadNotifications;

        foreach($notifs as $notif){

            $notif->markAsRead();

            $this->counter = getRandom();

        }

        $this->counter = getRandom();
        

    }

    #[On('confirmedDeleteNotifications')]
    public function onConfirmationDeleteNotifications($data)
    {

        
    }


    public function deleteNotif($notif_id)
    {
        
    }
    
    public function sendEmailTo($notif_id)
    {
        
        
    }
    

    #[On('LiveNotificationsDeletedSuccessfullyEvent')]
    public function reloadData()
    {
        $this->counter = getRandom();
    }

}
