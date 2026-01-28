<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitSchoolMediaFolderRefreshingEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Services\SubscriptionsDelayedService;
use App\Livewire\Traits\SchoolActionsTraits;
use App\Livewire\Traits\SchoolBestsPupilsActionsTraits;
use App\Livewire\Traits\SchoolCommentActionsTraits;
use App\Livewire\Traits\SchoolMediaActionsTrait;
use App\Models\School;
use App\Models\Stat;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("PROFIL ECOLE")]
class SchoolProfil extends Component
{
    use SchoolActionsTraits, SchoolMediaActionsTrait, SchoolCommentActionsTraits, SchoolBestsPupilsActionsTraits, ListenToEchoEventsTrait, Toast, Confirm;
    
    public $uuid, $slug, $school_id, $school;

    public $simple_name = "ECOLE-ABC";

    public $school_name = "Ecole";

    public $counter = 2;

    public $selected_stat_year;

    public function mount($slug, $uuid)
    {
        if($slug && $uuid){

            if(auth_user()){

                $user = findUser(auth_user_id());

                if($user->isAdminsOrMaster()){

                    $school = School::where('uuid', $uuid)->where('slug', $slug)->firstOrFail();
                }
                else{

                    $school = School::where('uuid', $uuid)->where('slug', $slug)->where('is_active', true)->firstOrFail();
                }
            }
            else{

                $school = School::where('uuid', $uuid)->where('slug', $slug)->where('is_active', true)->firstOrFail();
            }

            if($school){

                $school->refreshImagesFolder();

                $this->school_id = $school->id;

                SubscriptionsDelayedService::runner([$school]);

                $this->school_name = $school->name;

                $this->simple_name = $school->simple_name;

                $this->uuid = $uuid;

                $this->slug = $slug;

                $this->school = $school;
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

                            $query->where('school_id', $this->school_id)->where('year', $this->selected_stat_year);

                        }
                        else{

                            $query->where('school_id', $this->school_id);
                        }
                    })
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($stat) {

                    return $stat->year;
                });

        $stats_years = Stat::where('school_id', $this->school_id)->orderBy('year', 'desc')->pluck('year')->toArray();

        $school_infos = $this->school->getSchoolInfos();

        $school_comments = $this->school->comments;

        $school_bests_pupils = $this->school->bests_pupils;



        return view('livewire.master.school-profil', compact('school_stats', 'stats_years', 'school_infos', 'school_comments', 'school_bests_pupils'));
    }

    public function updatedSelectedStatYear($selected)
    {
        session()->put('selected_stat_year', $selected);
    }

    public function addNewSchoolStat($stat_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school_id, ['stats-manager'], true)){
            $this->dispatch('ManageStatLiveEvent', $this->school_id);
        }
        
    }
    
    public function manageSchoolStat($stat_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school_id, ['stats-manager'], true)) $this->dispatch('ManageStatLiveEvent', $this->school_id, $stat_id);
    }

    

    public function manageSchoolInfo($info_id = null)
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school_id, ['infos-manager'], true))
        $this->dispatch('ManageCommuniqueLiveEvent', $this->school_id, $info_id);
    }

    public function addNewSchoolInfo()
    {
        if(__ensureThatAssistantCan(auth_user_id(), $this->school_id, ['infos-manager'], true))
        $this->dispatch('ManageCommuniqueLiveEvent', $this->school_id);
    }
    

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent', $this->school_id);
    }

    public function addImages()
    {
        $this->dispatch('ManageSchoolImagesLiveEvent', $this->school_id);
    }
    
    public function addVideos()
    {
        $this->dispatch('ManageSchoolVideoLiveEvent', $this->school_id, null);
    }
    
    public function manageSchoolCoverImage()
    {
        $this->dispatch('ManageSchoolCoverImageData', $this->school_id);
    }
    
    public function manageSchoolDescription()
    {
        $this->dispatch('ManageSchoolDescriptionLiveEvent', $this->school_id);
    }
    
    
    public function commentThisSchool($school_id = null)
    {
        $this->dispatch('AddNewCommentLiveEvent', $this->school_id);
    }

    #[On("LiveSchoolDataUpdatedEvent")]
    public function shoolDataUpdated()
    {
        $this->school = School::where('uuid', $this->uuid)->where('slug', $this->slug)->firstOrFail();
    }


    public function refreshSchoolMediaFolder()
    {
        InitSchoolMediaFolderRefreshingEvent::dispatch($this->school);
    }


    public function addNewBestPupil()
    {
        $this->school->to_create_best_pupil_route();
    }
    
    
}
