<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Livewire\Traits\SchoolActionsTraits;
use App\Livewire\Traits\UserActionsTraits;
use App\Models\School;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Administration - Liste des écoles")]
class SchoolsListing extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait, UserActionsTraits, SchoolActionsTraits;

    public $search = '';

    public $section = 'all';

    public $counter = null;

    public $paginate_page = 10;

    public $selected_schools = [];

    public $display_select_cases = false;


    public function mount()
    {

    }

    public function render()
    {
        $p = $this->paginate_page;

        if(session()->has('schools_list_section')){

            $this->section = session('schools_list_section');
        }

        $schools = School::orderBy('name', 'asc')->orderBy('name', 'asc')->paginate($p);

        $sections = config('app.users_list_sections');

        if($this->search && strlen($this->search) >= 2){

            $s = '%' . $this->search . '%';

            $schools = School::where('name', 'like', $s)
                         ->orWhere('simple_name', 'like', $s)
                         ->orWhere('system', 'like', $s)
                         ->orWhere('city', 'like', $s)
                         ->orWhere('contacts', 'like', $s)
                         ->orWhere('level', 'like', $s)
                         ->orWhere('country', 'like', $s)
                         ->orWhere('quotes', 'like', $s)
                         ->orWhere('objectives', 'like', $s)
                         ->orWhere('created_by', 'like', $s)
                         ->orWhere('creation_year', 'like', $s)
                         ->orWhere('department', 'like', $s)
                         ->orWhere('geographic_position', 'like', $s)
                         ->orderBy('name', 'asc')
                         ->paginate($p);
        }

        return view('livewire.master.schools-listing', compact('schools', 'sections'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSection($section)
    {
        session()->put('schools_list_section', $section);

        $this->section = $section;
    }

}
