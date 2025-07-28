<?php
namespace App\Helpers\TraitsManagers;

use App\Helpers\Robots\ModelsRobots;
use App\Jobs\JobToSendConfirmationMailRequestToUser;
use App\Jobs\JobToSendPasswordResetKeyToUser;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;



trait UserTrait{

    public function emailVerified()
    {
        return !is_null($this->email_verified_at);
    }

    public function emailNotVerified()
    {
        return is_null($this->email_verified_at);
    }

    public function markAsVerified()
    {
        if($this->emailNotVerified()){
    
            $this->forceFill([
                'email_verify_key' => null,
                'email_verified_at' => now(),
            ])->setRememberToken(Str::random(60));
 
            $this->save();

        }

        return $this->emailVerified();
    }

    public function markAsNotVerified()
    {
        $email_verify_key = generateRandomNumber(6);

        if(!$this->emailNotVerified()){
    
            $this->forceFill([
                'email_verify_key' => $email_verify_key,
                'email_verified_at' => null,
                'remember_token' => null,
            ]);
 
            $this->save();

        }

        return $this->emailNotVerified();
    }

    public function getUserNamePrefix($withFullName = false, $reverseName = false)
    {
        $prefix = 'Mr/Mme';

        if(in_array($this->gender, ['male', 'Male', 'M', 'm', 'masculin', 'Masculin'])) $prefix = 'Mr';

        if(in_array($this->gender, ['female', 'Female', 'F', 'f', 'feminin', 'Féminin', 'Feminin'])) $prefix = 'Mme';

        if($withFullName) return $prefix . ' ' . $this->getFullName($reverseName);

        return $prefix;
    }

    public function greatingMessage()
    {
        $name = $this->getFullName();


        $hour = date('G');
        
        if($hour >= 0 && $hour <= 12){

            $greating = "Bonjour ";
        }
        else{

            $greating = "Bonsoir ";
        }

        return $name  ? $greating . ' ' . $name : $greating;
    }

    public function sendVerificationLinkOrKeyToUser()
    {
        if($this->emailVerified()){

            return $this;
        }

        $dispatched = JobToSendConfirmationMailRequestToUser::dispatch($this);

        return $dispatched ? $this : false;
    }

    public function sendPasswordResetKeyToUser(?string $key = null)
    {
        return JobToSendPasswordResetKeyToUser::dispatch($this);
    }

    public function hasSchoolRoles($school_id, $roles = [])
    {
        return false;
    }

    public static function makeUserIdentifySequence()
    {
        return date('Y') . generateRandomNumber(6);
    }

    public function markUserAsVerifiedOrNot(bool $as_verified, bool $as_not_verified)
    {
        return ($as_verified === true || $as_not_verified === false) ? $this->markAsVerified() : $this->markAsNotVerified();
    }

    public function resetIdentifiant()
    {
        $identifiant = self::makeUserIdentifySequence();

        return $this->update(['identifiant' => $identifiant]);
    }


    public function blockUserAccount()
    {

    }

    public function isAdminsOrMaster()
    {
        return $this->isOnlyAdmin() || $this->isMaster();
    }

    public function isOnlyAdmin()
    {
        return $this->hasRole(['admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);
    }

    public function isMaster()
    {
        return $this->hasRole('master') || $this->id == 1;
    }

    public function formatString($text)
    {
        return $text ? $text : "Non renseigné";
    }

    public function formatDate($date, $substr = 3, $withTime = false)
    {
        return $date ? $this->__getDateAsString($date, $substr, $withTime) : "Non renseigné";
    }


    public function getFullName($reverse = false)
    {
        return $reverse ? $this->lastname . ' ' . $this->firstname : $this->firstname . ' ' . $this->lastname;
    }

    
    public function userBlockerOrUnblockerRobot($action = true, $reason = null)
    {
        if($action){

            $admins = ModelsRobots::getUserAdmins(false);
            
            if(!empty($admins)){

                $msg_to_admins = "Le compte de l'utilisateur " . $this->getFullName(true) . " vient d'être bloqué!";

                Notification::sendNow($admins, new RealTimeNotification($msg_to_admins));
            }

            $this->forceFill([
                'blocked' => true,
                'blocked_at' => Carbon::now(),
                'blocked_because' => $reason
            ])->save();
        }
        else{
            return $this->forceFill([
                'blocked' => false,
                'blocked_at' => null,
                'blocked_because' => null
            ])->save();

        }
    }

    public function isAdminAs($roles = ['master', 'admin'])
    {
        if($this->id == 1) return true;

        $user = $this;

        if($user){

            if($user->id == 1) return true;

            if($roles){

                if(is_array($roles)){

                    if(in_array('admin', $roles)) return $user->hasRole(['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);

                    else return $user->hasRole($roles);
                }

                if(!is_array($roles)){

                    if($roles == 'admin') return $user->hasRole(['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);

                    else return $user->hasRole([$roles]);
                }
            }
            return $user->hasRole(['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5']);
        }
    }

    public function incrementUserWrongPasswordTried()
    {
        $tried = (int)$this->wrong_password_tried + 1;

        return $this->update(['wrong_password_tried' => $tried]);
    }

    public function resetUserWrongPasswordTried()
    {
        return $this->update(['wrong_password_tried' => null]);
    }


    public function userHasBeenBlocked()
    {
        return $this->blocked;
    }

    public function getMyIncommingNotifications($senders = null, $search = null, $options = null)
    {
        $data = [];

        

        return $data;
    }


    


    






    




}