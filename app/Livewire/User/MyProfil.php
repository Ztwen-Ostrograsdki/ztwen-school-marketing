<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class MyProfil extends Component
{
    public $uuid, $user_id;

    public $user_name;

    public $user_email;

    public $user;

    public function mount($id, $uuid)
    {
        if($id && $uuid){

            $user = User::where('id', $id)->where('uuid', $uuid)->firstOrFail();

            if($user){

                $this->user_id = $id;

                $this->uuid = $uuid;

                $this->user = $user;

                $this->user_name = $user->getFullName();

                $this->user_email = $user->email;
            }
        }
        else{

            return abort(404);
        }

    }

    
    public function render()
    {
        $all_subscribes = getRand(100, 333);

        $all_posts = getRand(1881, 88888);

        $all_likes = getRand(1000, 959599);

        return view('livewire.user.my-profil', compact('all_subscribes', 'all_posts', 'all_likes'));
    }

    public function openAddAssistantModal()
    {
        $this->dispatch('AddNewAssistantLiveEvent');
    }

    public function manageSchoolStat($stat_id = null)
    {
        $this->dispatch('ManageStatLiveEvent', $stat_id);
    }


    public function manageSchoolInfo($info_id = null)
    {
        $this->dispatch('ManageCommuniqueLiveEvent', $info_id);
    }

    
}
