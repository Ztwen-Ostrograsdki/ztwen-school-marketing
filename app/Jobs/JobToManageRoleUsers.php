<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserRole;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class JobToManageRoleUsers implements ShouldQueue
{
    use Queueable, Batchable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Role $role,
        public ?array $users_id,
        public ?User $admin_generator
    )
    {
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        $role = $this->role;

        $current_selecteds = [];

        $role_name = __translateRoleName($role->name);

        try {

            if(count($this->users_id) > 0){

                $us = $role->users;

                foreach($us as $u){

                    $current_selecteds[$u->id] = $u->id;

                }

                $users = User::where('blocked', false)->whereNotNull('email_verified_at')->whereNotIn('id', $current_selecteds)->whereIn('id', $this->users_id)->get();

                foreach($users as $user){

                    if(!$user->hasRole($role->name)){

                        $user->assignRole($role->name);

                        $role_name = __translateRoleName($role->name);

                        UserRole::updateOrCreate(['user_id'=> $user->id, 'role_id' => $role->id], ['user_id'=> $user->id, 'role_id' => $role->id]);


                        Notification::sendNow([$user], new RealTimeNotification("FELICITATION : Votre liste de rôles administrateurs a été mise à jour : Vous avez à présent le rôle administrateur {$role_name} et ses privilèges."));

                    }

                }

            }

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();

            Notification::sendNow([$this->admin_generator], new RealTimeNotification("Le rôle {$role_name} n'a pas pu être assigné aux utilisateurs que vous avez sélectionnés ! Veuillez renseigner"));
            
        }


        
    }
}
