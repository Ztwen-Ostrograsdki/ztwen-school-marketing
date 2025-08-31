<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Services\SubscriptionsDelayedService;
use App\Livewire\Traits\SchoolActionsTraits;
use App\Livewire\Traits\SchoolMediaActionsTrait;
use App\Models\School;
use App\Models\Stat;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Profil école")]
class SchoolProfil extends Component
{
    use SchoolActionsTraits, SchoolMediaActionsTrait, ListenToEchoEventsTrait, Toast, Confirm;
    
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

                $school->refreshImagesFolder();

                $this->school = $school;

                SubscriptionsDelayedService::runner([$school]);

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

        $school_infos = $this->school->getSchoolInfos();

        $school_offers = $this->school->getSchoolInfos("Offres d'emploi");

        return view('livewire.master.school-profil', compact('school_stats', 'stats_years', 'school_infos', 'school_offers'));
    }

    public function updatedSelectedStatYear($selected)
    {
        session()->put('selected_stat_year', $selected);
    }

    public function addNewSchoolStat($stat_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true)){
            $this->dispatch('ManageStatLiveEvent', $this->school->id);
        }
        
    }
    
    public function manageSchoolStat($stat_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true)) $this->dispatch('ManageStatLiveEvent', $this->school->id, $stat_id);
    }

    

    public function manageSchoolInfo($info_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true))
        $this->dispatch('ManageCommuniqueLiveEvent', $this->school->id, $info_id);
    }

    public function addNewSchoolInfo()
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school->id, ['infos-manager'], true))
        $this->dispatch('ManageCommuniqueLiveEvent', $this->school->id);
    }
    

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }

    public function addImages()
    {
        $this->dispatch('ManageSchoolImagesLiveEvent', $this->school->id);
    }
    
    public function addVideos()
    {
        $this->dispatch('ManageSchoolVideoLiveEvent', $this->school->id, null);
    }
    
    
}
