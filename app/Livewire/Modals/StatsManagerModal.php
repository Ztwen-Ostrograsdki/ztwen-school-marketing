<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\School;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class StatsManagerModal extends Component
{
    use Toast;

    public $modal_name = "#stats-manager-modal";

    public $title;

    public float $stat_value = 50.5;

    public $year, $stat_id, $exam, $stat_model, $school;

    public function render()
    {
        $exams = config('app.exams');

        return view('livewire.modals.stats-manager-modal', compact('exams'));
    }

    #[On("ManageStatLiveEvent")]
    public function openModal($school_id, $stat_id = null)
    {
        if($school_id){

            $school = School::find($school_id);

            if($school){

                $this->school = $school;

                if(!$this->school->current_subscription()){

                    return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

                    return;
                }
                elseif($this->school->current_subscription()  &&!$school->current_subscription()->statisable){

                    return $this->toast("Vous avez déjà épuisé le nombre de statistiques que vous pouvez publier avec votre abonnement actif actuellement!", 'info');

                    return;
                }

                $this->year = date('Y');

                if($stat_id){

                    $stat_model = Stat::find($stat_id);

                    if($stat_model){

                        $this->stat_model = $stat_model;

                        $this->title = $stat_model->title;

                        $this->stat_value = $stat_model->stat_value;

                        $this->year = $stat_model->year;

                        $this->exam = $stat_model->exam;
                    }


                }
                $this->dispatch('OpenModalEvent', $this->modal_name);
            }
        }
    }

    public function hideModal()
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    public function insert()
    {
        if(!$this->school->current_subscription()){

            return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

            return;
        }

        $this->validate(
            [
                'exam' => 'required|string',
                'year' => 'required|numeric',
                'stat_value' => 'required|numeric|min:0',
            ]
        );

        $this->title = $this->exam . ' ' . $this->year;

        DB::beginTransaction();

        if($this->stat_model){

            try {

                $data = [
                    'title' => $this->title,
                    'stat_value' => $this->stat_value,
                    'year' => $this->year,
                    'exam' => $this->exam,
                ];

                $exists = Stat::where('year', $this->year)->where('school_id', $this->school->id)->where('exam', $this->exam)->where('id', '<>', $this->stat_model->id)->first();

                if($exists){

                    $this->toast("Doublure de statistique: Il semble que vous ayez déjà enregistré une telle statistique!", 'wraning');

                    $this->addError('stat_value', "Statistique déja enregistrée!");

                    $this->addError('year', "Statistique déja enregistrée!");

                    $this->addError('exam', "Statistique déja enregistrée!");

                    return;

                }

                $done = $this->stat_model->update($data);

                if(!$done){

                    $this->toast("Une erreure est survenue: La mise à jour de la statistique a échoué", 'error');
                }
                else{

                    $this->hideModal();
                }


                DB::commit();

                DB::afterCommit(function() use ($done){

                    if($done){

                        $this->reset();

                        $this->toast("La statistique a été mise à jour avec succès", 'success');

                    }

                });
            }
            catch (\Throwable $th) {
                
                DB::rollBack();

                $this->toast("Une erreure est survenue: La mise à jour a échoué", 'error');
            }

        }
        else{

            try {

                $exists = Stat::where('year', $this->year)->where('exam', $this->exam)->where('school_id', $this->school->id)->first();

                if($exists){

                    $this->toast("Doublure de statistique: Il semble que vous ayez déjà enregistré une telle statistique!", 'wraning');

                    $this->addError('stat_value', "Statistique déja enregistrée!");

                    $this->addError('year', "Statistique déja enregistrée!");

                    $this->addError('exam', "Statistique déja enregistrée!");

                    return;

                }

                $data = [
                    'title' => $this->title,
                    'user_id' => auth_user_id(),
                    'school_id' => $this->school->id,
                    'stat_value' => $this->stat_value,
                    'year' => $this->year,
                    'exam' => $this->exam,
                    'subscription_id' => $this->school->current_subscription()->id,
                ];

                $done = Stat::create($data);

                if(!$done){

                    $this->toast("Une erreure est survenue: L'insertion de la statistique a échoué", 'error');
                }
                else{

                    $this->hideModal();
                }


                DB::commit();

                DB::afterCommit(function() use ($done){

                    if($done){

                        $this->reset();

                        $this->toast("La statistique a été enregistrée et publiée avec succès", 'success');

                    }

                });


            } catch (\Throwable $th) {
                
                DB::rollBack();

                $this->toast("Une erreure est survenue {$th->getMessage()} : L'insertion de la statistique a échoué", 'error');
            }
        }
    }

    public function updatedTitle($title)
    {
        $this->resetErrorBag();
    }

    public function updatedYear($year)
    {
        $this->resetErrorBag('year');
    }


    public function updatedStatValue($stat_value)
    {
        $this->resetErrorBag('stat_value');
    }

    public function updatedExam($exam)
    {
        $this->resetErrorBag('exam');
    }
}
