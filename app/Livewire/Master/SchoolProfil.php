<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Robots\SpatieManager;
use App\Models\School;
use App\Models\Stat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Profil école")]
class SchoolProfil extends Component
{
    use ListenToEchoEventsTrait, Toast, Confirm;
    
    public $uuid, $slug, $school;

    public $simple_name = "ECOLE-ABC";

    public $school_name = "Ecole";

    public $counter = 2;

    public $selected_stat_year;

    public function mount($slug, $uuid)
    {
        if($slug && $uuid){

            $school = School::where('uuid', $uuid)->where('slug', $slug)->firstOrFail();

            if($school){

                $this->school = $school;

                $this->school_name = $school->name;

                $this->simple_name = $school->simple_name;

                $this->uuid = $uuid;

                $this->slug = $slug;
            }
            else{

                return abort(404);
            }


        }
        else{

            return abort(404);
        }

        if(session()->has('selected_stat_year')){

            $this->selected_stat_year = session('selected_stat_year');
        }
        else{

            $this->selected_stat_year = date('Y');
        }
    }
    
    public function render()
    {
        if(session()->has('selected_stat_year')){

            $this->selected_stat_year = session('selected_stat_year');
        }

        $selected_stat_year = $this->selected_stat_year;

        $school_stats = Stat::where(function ($query) {
                        if($this->selected_stat_year && $this->selected_stat_year !== ''){

                            $query->where('school_id', $this->school->id)->where('year', $this->selected_stat_year);

                        }
                        else{

                            $query->where('school_id', $this->school->id);
                        }
                    })
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($stat) {

                    return $stat->year;
                });

        $stats_years = Stat::where('school_id', $this->school->id)->orderBy('year', 'desc')->pluck('year')->toArray();
        


        return view('livewire.master.school-profil', compact('school_stats', 'stats_years'));
    }

    public function updatedSelectedStatYear($selected)
    {
        session()->put('selected_stat_year', $selected);
    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $this->school->id, $stat_id);
    }

    public function deleteSchoolStat($stat_id)
    {

    }

    public function hideSchoolStat($stat_id)
    {
        
    }


    public function manageSchoolInfo($info_id = null)
    {
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }

    public function addImages()
    {
        $this->dispatch('ManageSchoolImagesLiveEvent', $this->school->id);
    }
    
    public function removeAllImages()
    {
        // SpatieManager::ensureThatUserCan(['schools-manager']);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer toutes les images de {$this->school_name} </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImagesDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé'];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImagesDeletion')]
    public function confirmAllImagesRemoving()
    {
        // SpatieManager::ensureThatUserCan(['school-manager']);

        if($this->school){

            $school = $this->school;

            $images = (array)$school->images;

            if(!empty($images)){

                if(Storage::disk('public')->exists($school->folder)){

                    if(Storage::disk('public')->deleteDirectory($school->folder)){

                        $updated = $school->update(['images' => null]);

                        if($updated) $this->toast( "La galerie a été rafraîchie avec succès!", 'success');

                        $this->counter = getRand();
                    }
                    else{

                        return $this->toast( "Une erreure s'est produite, les images n'ont pas pu être supprimées!", 'error');
                    }

                    
                }
                else{

                    return $this->toast( "Erreur stockage: Le dossier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Une erreure s'est produite!", 'error');
            }
        }
    }


    public function removeImageFromImagesOf($image_path)
    {
        // SpatieManager::ensureThatUserCan(['schools-manager']);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer une image </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible! </p>";

        $options = ['event' => 'confirmImageDeletion', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['image_path' => $image_path]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmImageDeletion')]
    public function confirmImageRemoving($data)
    {
        // SpatieManager::ensureThatUserCan(['school-manager']);

        $image_path = $data['image_path'];

        if($image_path){

            $school = $this->school;

            $images = (array)$school->images;

            if(in_array($image_path, $images)){

                $image_key = array_keys($images, $image_path)[0];

                if(Storage::disk('public')->exists($image_path)){

                    if(Storage::disk('public')->delete($image_path)){

                        unset($images[$image_key]);

                        $images = array_values($images); 

                        $updated = $school->update(['images' => $images]);

                        if($updated) $this->toast( "L'image a été retirée avec succès!", 'success');

                        $this->counter = getRand();
                    }
                    else{

                        return $this->toast( "Une erreure s'est produite, l'image n'a pas pu être supprimée!", 'error');
                    }

                    
                }
                else{

                    return $this->toast( "Erreur stockage: Le fichier est introuvable!", 'error');
                }

            }
            else{
                return $this->toast( "Une erreure s'est produite!", 'error');
            }
        }
    }
}
