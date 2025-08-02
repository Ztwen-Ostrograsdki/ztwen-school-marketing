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


    #[On("LiveRolesWasUpdatedEvent")]
    public function spatieRoleUpdated($req = null)
    {
        $this->counter = getRand();
    }
    
    #[On("LiveUserAccountWasBlockedEvent")]
    public function reloadDataAfterAccountBlocked($req = null)
    {
        $this->counter = getRand();
    }
    
    #[On("LiveUserAccountWasDeletedEvent")]
    public function reloadDataAfterAccountDeleted($req = null)
    {
        $this->counter = getRand();
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
    public function userCreated($user = null)
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

    // School STAT CRUD events
    #[On("LiveNewSchoolStatAddedEvent")]
    public function schoolStatCreated($stat = null)
    {
        $this->counter = getRandom();
    }

    #[On("LiveSchoolStatUpdatedEvent")]
    public function schoolStatUpdated($stat = null)
    {
        $this->counter = getRand();
    }
    
    
    // School INFOS CRUD events
    #[On("LiveNewSchoolInfoAddedEvent")]
    public function schoolInfoCreated($info = null)
    {
        $this->counter = getRandom();
    }

    #[On("LiveSchoolInfoUpdatedEvent")]
    public function schoolInfoUpdated($info = null)
    {
        $this->counter = getRand();
    }

    // School ASSISTANTS CRUD events
    #[On("LiveNewAssistanceRequestCreatedEvent")]
    public function schoolAssistantRequestCreated($req = null)
    {
        $this->counter = getRandom();
    }

    #[On("LiveAssistantRequestApprovedEvent")]
    public function schoolAssistantRequestApproved($req = null)
    {
        $this->counter = getRand();
    }
    
    #[On("LiveAssistantAccessWasUpdatedEvent")]
    public function assistantAccessUpdated($req = null)
    {
        $this->counter = getRand();
    }
    
    


}

