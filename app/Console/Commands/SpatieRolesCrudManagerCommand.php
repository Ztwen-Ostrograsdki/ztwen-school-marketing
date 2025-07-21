<?php

namespace App\Console\Commands;

use App\Helpers\Robots\SpatieManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpatieRolesCrudManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spatie:roles {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Opération (population et rafraîchissement) sur les tables Roles et permissions Spaties';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        if($action == 'create'){

            $this->alert("Initialisation de la base de données: Rafraissement des données (rôles et privilèges administrateurs spaties) en cours...");

            self::clearData();

            $this->alert("Création en base de données des rôles et privilèges administrateurs spaties enclenchées: processus en cours...");

            self::creator();

            $this->info("Les données ont été créées avec succès!");

            
        }
        elseif($action == 'clear'){

            $this->alert("Rafraissement des données (rôles et privilèges administrateurs spaties) en cours...");

            self::clearData();

            $this->info("Les données ont été rafraîchies avec succès!");

        }
        else{

            $this->error("Le processus incohérent, veuillez renseigner un argument action: 'create' ou 'clear' svp!");

        }

    }

    public function clearData()
    {
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table((new Role)->getTable())->truncate();

            DB::table((new Permission)->getTable())->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            

        } catch (\Throwable $th) {

            $this->error("Le processus a échoué : " . $th->getMessage());

        }
    }

    public function creator()
    {
        DB::beginTransaction();

        try {
            $permissions = SpatieManager::getPermissions();

            $roles = SpatieManager::getRoles();

            foreach ($permissions as $perm) {

                Permission::firstOrCreate(['name' => $perm]);

            }

            foreach ($roles as $role) {

                Role::firstOrCreate(['name' => $role]);

            }

            $master = Role::where('name', 'master')->first();

            $master->syncPermissions($permissions);

            DB::commit();

        } catch (\Throwable $th) {

            $this->error("Le processus a échoué : " . $th->getMessage());

            DB::rollBack();
        }
    }
}
