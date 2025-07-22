<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RobotToTruncateTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:table {table_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Opération  rafraîchissement (Truncatage) de table dans la base de donées';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table_name = $this->argument('table_name');

        if($table_name){

            if(Schema::hasTable($table_name)){

                $this->alert("Initialisation : Rafraissement des données de la table {$table_name} en cours...");

                $this->warn("Toutes les données de la table " . $table_name . " seront éffacées. Continuer ? (yes/no)");

                if(!$this->confirm("Cette action est irréversible. Continuer ?")){

                    $this->line('');
                    $this->infos("Opération annulée!");
                    $this->line('');
                    return;

                }

                return self::clearData($table_name);

            }
            else{

                return $this->error("Le processus a échoué la table {$table_name} n'existe pas!");
            }

        }
        

    }

    public function clearData($table_name)
    {
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table($table_name)->truncate();

            $this->line('');
            $this->info("Opération terminée: La table {$table_name} a été rafraîchie avec succès!");
            $this->line('');

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            

        } catch (\Throwable $th) {

            $this->error("Le processus a échoué : " . $th->getMessage());

        }
    }

    
}
