<?php

namespace App\Livewire\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Info;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CommuniqueManagerModal extends Component
{
    use Toast;

    public $modal_name = "#infos-manager-modal";

    public $title, $content, $target, $communique, $type, $school;

    public function render()
    {
        $infos_types = config('app.infos_types');

        $targets_types = config('app.targets_types');

        return view('livewire.modals.communique-manager-modal', compact('infos_types', 'targets_types'));
    }


    #[On("ManageCommuniqueLiveEvent")]
    public function openModal($school_id, $communique_id = null)
    {
        if($school_id){

            $school = School::find($school_id);

            if($school){

                $this->school = $school;

                if(!$this->school->current_subscription()){

                    return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

                    return;
                }
                elseif($this->school->current_subscription()  &&!$school->current_subscription()->infosable){

                    return $this->toast("Vous avez déjà épuisé le nombre d'infos que vous pouvez publier avec votre abonnement actif actuellement!", 'info');

                    return;
                }

                if($communique_id){

                    $communique_model = Info::whereId($communique_id)->firstOrFail();

                    if($communique_model){

                        $this->communique = $communique_model;

                        $this->title = $communique_model->title;

                        $this->target = $communique_model->target;

                        $this->content = $communique_model->content;

                        $this->type = $communique_model->type;
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
                'title' => 'required|string',
                'content' => 'required|string',
                'target' => 'required|string',
                'type' => 'required|string',
            ]
        );

        DB::beginTransaction();

        if($this->communique){

            try {

                $data = [
                    'title' => $this->title,
                    'target' => $this->target,
                    'content' => $this->content,
                    'type' => $this->type,
                ];

                $done = $this->communique->update($data);

                if(!$done){

                    $this->toast("Une erreure est survenue: La mise à jour de la donnée a échoué", 'error');
                }
                else{

                    $this->hideModal();
                }


                DB::commit();

                DB::afterCommit(function() use ($done){

                    if($done){

                        $this->toast("La mise à jour s'est déroulée avec succès", 'success');

                        $this->reset();

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

                $data = [
                    'title' => $this->title,
                    'user_id' => auth_user_id(),
                    'school_id' => $this->school->id,
                    'target' => $this->target,
                    'content' => $this->content,
                    'type' => $this->type,
                    'subscription_id' => $this->school->current_subscription()->id
                ];

                $done = Info::create($data);

                if(!$done){

                    $this->toast("Une erreure est survenue: L'insertion de la {$this->type} a échoué", 'error');
                }
                else{

                    $this->hideModal();
                }


                DB::commit();

                DB::afterCommit(function() use ($done){

                    if($done){

                        $this->toast("La {$this->type} a été enregistrée et publiée avec succès", 'success');

                        $this->reset();

                    }

                });


            } catch (\Throwable $th) {
                
                DB::rollBack();

                $this->toast("Une erreure est survenue {$th->getMessage()} : L'insertion de la donnée a échoué", 'error');
            }
        }
    }

    public function updatedTitle($title)
    {
        $this->resetErrorBag('title');
    }

    public function updatedTarget($target)
    {
        $this->resetErrorBag('target');
    }

    public function updatedContent($content)
    {
        $this->resetErrorBag('content');
    }

    public function updatedType($type)
    {
        $this->resetErrorBag('type');
    }

        

}
