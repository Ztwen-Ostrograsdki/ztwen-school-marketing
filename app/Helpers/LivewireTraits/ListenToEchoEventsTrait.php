<?php
namespace App\Helpers\LivewireTraits;



use Livewire\Attributes\On;

trait ListenToEchoEventsTrait{

    // SPATIE ROLES CRUD events

	#[On("LiveRolePermissionsWasUpdatedEvent")]
    public function relaodDataForRolePermissionsUpdate()
    {
        $this->counter = getRandom();
    }
    
    



    // Notfications events
    #[On("LiveNotificationDispatchedToAdminsSuccessfullyEvent")]
    public function notificationsToAdmins()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveIHaveNewNotificationEvent")]
    public function newNotifications()
    {
        $this->counter = getRandom();
    }
    
    #[On("LiveNotificationsDeletedSuccessfullyEvent")]
    public function notificationDeleted()
    {
        $this->counter = getRandom();
    }
    



    // Users CRUD events
    #[On("LiveUserDataHasBeenUpdatedEvent")]
    public function relaodDataForUsers()
    {
        $this->counter = getRandom();
    }

    #[On("LiveNewUserCreatedEvent")]
    public function userCreated()
    {
        $this->counter = getRandom();
    }






    
    // School CRUD events
    #[On("LiveNewSchoolCreatedEvent")]
    public function schoolCreated()
    {
        $this->counter = getRandom();
    }

    #[On("LiveSchoolDataHasBeenUpdatedEvent")]
    public function shoolDataUpdated()
    {
        $this->counter = getRand();
    }


}

