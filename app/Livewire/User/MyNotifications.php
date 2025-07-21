<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class MyNotifications extends Component
{
    // use Confirm, Toast;

    public $counter = 1;

    

    public $sectionned = 'unread';

    public $search = '';

    protected $listeners = [
        'LiveIHaveNewNotificationEvent' => 'reloadNotificationsData',
    ];

    public function mount($identifiant)
    {
        if(!$identifiant){

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

    public function reloadNotificationsData($user = null)
    {
        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


   

    public function deleteNotification($notif_id)
    {
        
        
       
    }

    public function deleteAllNotifications()
    {
        
       
    }


    public function deleteNotificationsLL($section = null)
    {
        
    }



    public function deleteNotifications($section = null)
    {

        

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


    public function userUnBlockedSuccessfully($user)
    {
        
        if($user && !$user['blocked']){

            $message = "L'utilisateur a été débloqué avec success!";

            $this->toast($message, 'success');

            to_flash('success', $message);

        }
        else{

            $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

        }
    }


    #[On('LiveNotificationsDeletedSuccessfullyEvent')]
    public function reloadData()
    {
        $this->counter = getRandom();
    }

}
