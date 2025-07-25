<?php
namespace App\Helpers\Robots;


use App\Models\User;
use App\Notifications\NotifyAdminsThatBlockedUserTriedToLoginToUnblockThisUserAccount;
use App\Notifications\NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount;
use App\Notifications\RealTimeNotification;
use App\Notifications\SendDynamicMailToUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ModelsRobots{

    public $model;

    public function __construct($model = null) {

        $this->model = $model;
    }

    public static function generatePseudo($sequence = null)
    {
        if(!$sequence) $sequence = Str::random();

        return '@' . Str::substr($sequence, 0, 3) . '' . generateRandomNumber(4);
    }


    public static function greatingMessage($name = null)
    {
        $hour = date('G');
        
        if($hour >= 0 && $hour <= 12){

            $greating = "Bonjour ";
        }
        else{

            $greating = "Bonsoir ";
        }

        return $name  ? $greating . ' ' . $name : $greating;
    }

    public static function getMasters($pluckingColumn = 'id', $except = null)
    {
        $roles = ['master'];

        if(!$pluckingColumn)

            return User::whereHas('roles', function($query) use ($roles, $except) {

                $query->whereIn('roles.name', $roles);

                if($except) $query->where('users.id', '<>', $except);

            })
            ->orWhere(function($query) use ($except){

                $query->where('users.id', 1);

                if($except) $query->where('users.id', '<>', $except);
            })
            ->distinct()
            ->pluck('id')
            ->toArray();

        else

            return User::whereHas('roles', function($query) use ($roles, $except) {

                $query->whereIn('roles.name', $roles);

                if($except) $query->where('users.id', '<>', $except);

            })
            ->orWhere(function($query) use ($except){

                $query->where('users.id', 1);

                if($except) $query->where('users.id', '<>', $except);
            })
            ->distinct()->get();
    }

    public static function getUserAdmins($pluckingColumn = false, $except = null)
    {
        $roles = ['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5'];

        if($pluckingColumn)

            return User::whereHas('roles', function($query) use ($roles, $except) {

                $query->whereIn('roles.name', $roles);

                if($except) $query->where('users.id', '<>', $except);

            })
            ->orWhere(function($query) use ($except){

                $query->where('users.id', 1);

                if($except) $query->where('users.id', '<>', $except);
            })
            ->distinct()
            ->pluck('id')
            ->toArray();

        else

            return User::whereHas('roles', function($query) use ($roles, $except) {

                $query->whereIn('roles.name', $roles);

                if($except) $query->where('users.id', '<>', $except);

            })
            ->orWhere(function($query) use ($except){

                $query->where('users.id', 1);

                if($except) $query->where('users.id', '<>', $except);
            })
            ->distinct()->get();
    }

    public static function getAllAdmins($with_these_admins = [], $limit_to_take = null)
    {
        $roles = ['master', 'admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5'];

        if(!empty($with_these_admins)){

            $roles = array_merge($roles, $with_these_admins);
        }

        if($limit_to_take)
            return User::whereHas('roles', function($query) use ($roles) {

                $query->whereIn('roles.name', $roles);
    
            })
            ->orWhere(function($query){
    
                $query->where('users.id', 1);
            })
            ->inRandomOrder()->distinct()->limit($limit_to_take)->get();
        
        else

            return User::whereHas('roles', function($query) use ($roles) {

                $query->whereIn('roles.name', $roles);
    
            })
            ->orWhere(function($query){
    
                $query->where('users.id', 1);
            })
            ->distinct()->get();
        

    }

    

    public static function deleteFileFromStorageManager($path)
    {

        // Ex: 'users/' . $file_name

        $complete_path = storage_path().'/app/public/' . $path;

        if(File::exists($complete_path)){

            return File::delete($complete_path);
        }
        
        return true;
        
    }

    public static function deleteFilesFromStorageManager(array $paths)
    {

        // Ex: 'users/' . $file_name

        foreach($paths as $path){

            $complete_path = storage_path().'/app/public/' . $path;

            if(File::exists($complete_path)){

                return File::delete($complete_path);
            }
        }
        
        return true;
        
    }

    






    public static function makeUserIdentifySequence()
    {
        return "AESP-" . date('Y') . generateRandomNumber(6);
    }

    
    public static function notificationThatBlockedUserTriedToLogin(User $user, $title, $object, $content)
    {
        if($user && !$user->blocked){

            $since = __formatDateTime($user->blocked_at);

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminsThatBlockedUserTriedToLoginToUnblockThisUserAccount($user, $title, $object, $content));

            }

            $message = "L'utilisateur " . $user->getFullName(true) . " dont le compte a été bloqué le " . $since . " a essayé de se connecter à son compte!";

            Notification::sendNow($admins, new RealTimeNotification($message));

        }
    }
}