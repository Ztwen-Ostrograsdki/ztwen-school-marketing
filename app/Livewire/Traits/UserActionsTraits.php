<?php
namespace App\Livewire\Traits;

use App\Events\InitProcessToBlockUserAccountEvent;
use App\Events\InitProcessToDeleteUserAccountEvent;
use App\Events\InitProcessToUnlockUsersAccountEvent;
use App\Events\RolesWasUpdatedEvent;
use App\Helpers\Robots\ModelsRobots;
use App\Helpers\Robots\SpatieManager;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

trait UserActionsTraits{

	public function assignAdminRoles($user_id)
    {
        SpatieManager::ensureThatUserCan();
        
        $this->dispatch("ManageUserSpatiesRolesEvent", $user_id);
    }

	public function blockUserAccount($user_id)
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        if($user){

            if($user->blocked){

                $t = "Confirmez le blocage de " . $user->getFullName();

                $r = "Vous étes sur le point de bloquer cet utilisateur";

            }

            $options = ['event' => 'confirmAccountBlocking', 'confirmButtonText' => 'Bloquer', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmAccountBlocking')]
    public function onConfirmationTheUserBlockOrUnblocked($data)
    {
        $action = true;

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            if(!$user->blocked){

                InitProcessToBlockUserAccountEvent::dispatch($user, auth_user());

                $this->toast( "L'opération a été lancée!", 'success');
            
            }
            else{

                
            }
            
        }

    }


	public function unlockUserAccount($user_id)
    {

        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        if($user){

            if($user->blocked){

                $since = __formatDateTime($user->blocked_at);

                $t = "Confirmez le déblocage de " . $user->getFullName();

                $r = "Vous étes sur le point de débloquer cet utilisateur bloqué depuis " . $since;
            }
            

            $options = ['event' => 'confirmAccountUnlocking', 'confirmButtonText' => 'Bloquer', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmAccountUnlocking')]
    public function onConfirmationUnlockAccount($data)
    {
        $action = true;

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            if(!$user->blocked){

                InitProcessToUnlockUsersAccountEvent::dispatch([$user_id], auth_user(), false, 1);

                $this->toast( "L'opération a été lancée!", 'success');
            
            }
            
        }

    }


    public function confirmUserEmail($user_id)
    {
        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user){

            $t = "Confirmez l'addresse mail de " . $user->getFullName();

            $r = "Vous étes sur le point de confirmer l'addresse mail de cet utilisateur";

            $options = ['event' => 'confirmedTheUserEmailVerification', 'confirmButtonText' => 'Confirmer email', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserEmailVerification')]
    public function onConfirmationTheUserEmailVerification($data)
    {
        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $verified = $user->markAsVerified();

            if($verified){

                $message = "L'utilisateur a été confirmé avec success!";

                $this->toast($message, 'success');

                session()->flash('success', $message);

            }
            else{

                $this->toast( "La confirmation a échoué! Veuillez réessayer!", 'error');

            }
        }

    }


    public function deleteAccount($user_id)
    {
        SpatieManager::ensureThatUserCan(['users-manager', 'destroyer', 'user-account-reseter', 'account-manager']);

        $user = User::find($user_id);

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        if($user){

            $name = $user->getFullName();

            $email = $user->email;


            $html = "<h6 class='font-semibold flex flex-col gap-y-0 text-base text-orange-400 py-0 my-0'>
                    <span>Voulez-vous vraiment confirmer la suppression du compte de l'utilisateur</span>
                    <span class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </span>
                    <span class='text-yellow-300 py-0 my-0 font-semibold'> Email: {$email} </span>
                    <span class='text-red-600 py-0 my-0 font-semibold'> Cette action est irréversible: le compte sera définitivement supprimé! </span>
                </h6>";

            $noback = "";

            $options = ['event' => 'confirmedAccountDeletion', 'confirmButtonText' => 'Supprimer compte', 'cancelButtonText' => 'Annulé', 'data' => ['user_id' => $user_id]];

            $this->confirm($html, $noback, $options);
        }

    }

    #[On('confirmedAccountDeletion')]
    public function onConfirmedAccountDeletion($data)
    {
        $admin = auth_user();

        if($data){

            $user_id = $data['user_id'];
        
            if($user_id){

                $user = findUser($user_id);

                if($user){

                    InitProcessToDeleteUserAccountEvent::dispatch($admin, [$user_id]);
                    
                }


            }
           
        }

    }

    public function blockAllUsersAccount()
    {
        SpatieManager::ensureThatUserCan();

        $targets = "all_users";

        if(!empty($targets_ids)){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de bloquer les comptes de tous les utilisateurs
                            </p>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedBlockSelectedsUsersAccount', 'confirmButtonText' => 'Bloqué les comptes', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets]];

            $this->confirm($html, $noback, $options);
        }
    } 
    
    public function blockSelectedsUsersAccount()
    {
        SpatieManager::ensureThatUserCan();

        $targets_ids = [];

        if(!empty($this->selected_users)){

            $targets_ids = $this->selected_users;
        }
        else{

            $targets_ids = [];

        }

        if(!empty($targets_ids)){

            $total = numberZeroFormattor(count($targets_ids));

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de bloquer les comptes de tous les  
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$total} </span>
                                utilisateurs sélectionnés
                            </p>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedBlockSelectedsUsersAccount', 'confirmButtonText' => 'Bloqué les comptes', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets_ids]];

            $this->confirm($html, $noback, $options);
        }
    } 


    #[On('confirmedBlockSelectedsUsersAccount')]
    public function onconfirmedBlockSelectedsUsersAccount($data)
    {
        if($data){

            $targets = $data['targets'];

            if(is_array($targets) && !empty($targets)){

                InitProcessToBlockUserAccountEvent::dispatch(null, auth_user(), $targets);

                $this->toast( "L'opération de blocage des comptes a été lancée!", 'success');

            }
            elseif(!is_array($targets)){

                if($targets == 'all_users'){

                    InitProcessToBlockUserAccountEvent::dispatch(null, auth_user(), $targets, true);

                    $this->toast( "L'opération de blocage des comptes a été lancée!", 'success');

                }

            }

        }
    }

    public function unlockSelectedsUsersAccount()
    {
        SpatieManager::ensureThatUserCan();
        $targets_ids = [];

        if(!empty($this->selected_users)){

            $targets_ids = $this->selected_users;
        }
        else{

            $targets_ids = [];

        }

        if(!empty($targets_ids)){

            $total = numberZeroFormattor(count($targets_ids));

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de débloquer les comptes de tous les  
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$total} </span>
                                utilisateurs sélectionnés
                            </p>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedunlockSelectedsUsersAccount', 'confirmButtonText' => 'Débloqué les comptes', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets_ids]];

            $this->confirm($html, $noback, $options);
        }
    } 
    
    public function unlockAllUsersAccount()
    {
        SpatieManager::ensureThatUserCan();

        $targets = "all_users";

        if($targets){

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de débloquer les comptes de tous les utilisateurs ayant leur compte bloqué
                            </p>
                    </h6>";

            $noback = "";

            $options = ['event' => 'confirmedunlockSelectedsUsersAccount', 'confirmButtonText' => 'Débloqué les comptes', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets]];

            $this->confirm($html, $noback, $options);
        }
    } 

    #[On('confirmedunlockSelectedsUsersAccount')]
    public function onconfirmedUnlockSelectedsUsersAccount($data)
    {
        if($data){

            $targets = $data['targets'];

            if(is_array($targets) && !empty($targets)){

                InitProcessToUnlockUsersAccountEvent::dispatch($targets, auth_user(), false, 1);

                $this->toast( "L'opération de déblocage des comptes a été lancée!", 'success');

            }
            elseif(!is_array($targets)){

                if($targets == 'all_users'){

                    InitProcessToUnlockUsersAccountEvent::dispatch(null, auth_user(), true, 1);

                    $this->toast( "L'opération de déblocage des comptes a été lancée!", 'success');

                }

            }

        }
    }
    
    public function removeAllAssignments()
    {
        SpatieManager::ensureThatUserCan();

        $targets_ids = [];

        if(!empty($this->selected_users)){

            $targets_ids = $this->selected_users;
        }
        else{

            $targets_ids = [];

        }

        if(!empty($targets_ids)){

            $total = numberZeroFormattor(count($targets_ids));

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Vous êtes sur le point de supprimer tous les rôles attribués aux  
                                <span class='text-sky-400 letter-spacing-2 font-semibold'> {$total} </span>
                                utilisateurs sélectionnés
                            </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedUsersRolesRetrieving', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['targets' => $targets_ids]];

            $this->confirm($html, $noback, $options);
        }
    } 


    #[On('confirmedUsersRolesRetrieving')]
    public function onconfirmedUsersRolesRetrieving($data)
    {
        if($data){

            $targets_ids = $data['targets'];

            if(!empty($targets_ids)){

                foreach($targets_ids as $user_id){

                    $user = findUser($user_id);

                    if($user && !$user->isMaster()){

                        if(!empty($user->roles)){

                            $retrieved = $user->syncRoles([]);

                            $retrieved = $user->syncPermissions([]);

                            if($retrieved){

                                UserRole::where('user_id', $user->id)->delete();

                                $name = $user->getFullName(true);

                                RolesWasUpdatedEvent::dispatch();

                                Notification::sendNow([auth_user()], new RealTimeNotification("Les rôles attribués à l'utilisateur {$name} ont tous été retirés avec success!"));

                            }


                        }
                    }
                }

            }

        }
    }


    public function pushOrRetrieveFromSelectedUsers($user_id)
    {
        $selecteds = $this->selected_users;

        if(!in_array($user_id, $selecteds)){

            $selecteds[$user_id] = $user_id;
        }
        elseif(in_array($user_id, $selecteds)){

            unset($selecteds[$user_id]);
        }

        $this->resetErrorBag();

        $this->selected_users = $selecteds;
    }


    public function toggleSelectAll()
    {
        $selecteds = $this->selected_users;

        $users = getUsers();

        $masters = ModelsRobots::getMasters();

        if((count($selecteds) > 0 && count($selecteds) < count($users) - count($masters)) || count($selecteds) == 0){

            foreach($users as $user){

                if(!$user->isMaster()){

                    if(!in_array($user->id, $selecteds)){

                        $selecteds[$user->id] = $user->id;
                    }

                }

            }

        }
        else{

            $selecteds = [];

        }

        $this->selected_users = $selecteds;
    }

    public function toggleSelectionsCases()
    {
        $this->display_select_cases = !$this->display_select_cases;

        if(!$this->display_select_cases) $this->reset('selected_users');
    }

    public function revokeThisRoleFromUserRoles($role_id, $user_id)
    {

        SpatieManager::ensureThatUserCan();

        $user = findUser($user_id);

        if(auth_user()->id !== $user->id && $user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        $role = Role::find($role_id);

        if($role && $user->hasRole($role->name)){

            $name = $user->getFullName();

            $role_name = __translateRoleName($role->name);

            $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                        <p>Vous êtes sur le point de retirer le role: 
                            <span class='text-orange-500 letter-spacing-2 font-semibold'> {$role_name} </span>
                            à l'utilisateur {$name}
                        </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

            $options = ['event' => 'confirmedUserRetrieving', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['role_id' => $role->id, 'user_id' => $user_id]];

            $this->confirm($html, $noback, $options);
            
        }

    }

    #[On('confirmedUserRetrieving')]
    public function onConfirmationUserRetrieving($data)
    {
        DB::beginTransaction();

        try {
            if($data){

                $role_id = $data['role_id'];

                $user_id = $data['user_id'];

                $role = Role::find($role_id);

                $user = findUser($user_id);

                if($role && $user){

                    $retrieved = $user->removeRole($role);

                    if($retrieved){

                        UserRole::where('user_id', $user->id)->where('role_id', $role->id)->delete();

                        $role_name = __translateRoleName($role->name);

                        $name = $user->getFullName(true);

                        RolesWasUpdatedEvent::dispatch();

                        Notification::sendNow([auth_user()], new RealTimeNotification("Le rôle {$role_name} a été rétiré à l'utilisateur {$name} avec success!"));

                    }
                }
                else{

                    $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');
                }

            }

            DB::commit();

        } catch (\Throwable $th) {

            $this->toast( "Une erreure s'est produite: La suppression a échoué! Veuillez réessayer!", 'error');
            
            DB::rollBack();
        }
    }

    #[On("LiveNewVisitorHasBeenRegistredEvent")]
    public function newVisitor()
    {
        $this->counter = getRand();
    }





}