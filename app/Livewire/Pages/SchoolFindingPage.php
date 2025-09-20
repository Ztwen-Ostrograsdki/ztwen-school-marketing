<?php

namespace App\Livewire\Pages;

use App\Helpers\Robots\RobotsBeninHelpers;
use App\Models\School;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Trouver une école")]
class SchoolFindingPage extends Component
{
    public $department, $city, $geographic_position, $school_name, $director_name, $director_email, $system, $level;

    public $countries = [], $cities = [], $departments = [], $geographic_positions = [], $levels = [], $systems = [], $department_name, $department_key;


    public $search = '';

    public $schools = [];

    public $searching = false;

    public function mount()
    {
        $this->cities = RobotsBeninHelpers::getCities();

        $this->departments = RobotsBeninHelpers::getDepartments();

        $this->levels = RobotsBeninHelpers::getLevels();

        $this->systems = RobotsBeninHelpers::getSytems();

        $this->geographic_positions = RobotsBeninHelpers::getGeographicPositions();


        if(session()->has('find_school_department') && session('find_school_department')){

            $this->department = session('find_school_department');

            $departments = RobotsBeninHelpers::getDepartments();

            $this->department_key = (array_keys($departments, $this->department))[0];

            $this->department_name = $this->department;

            if(session()->has('find_school_city') && session('find_school_city')){
            
                $this->city = session('find_school_city');
            }
        }

        if(session()->has('find_school_level') && session('find_school_level')){
            
            $this->level = session('find_school_level');
        }

        if(session()->has('find_school_system') && session('find_school_system')){
            
            $this->system = session('find_school_system');
        }

        if(session()->has('find_school_search') && session('find_school_search')){
            
            $this->search = session('find_school_search');
        }
    }

    public function render()
    {
        return view('livewire.pages.school-finding-page');
    }

    public function findSchool()
    {
        $this->schools = self::searcher();

        $this->searching = true;
    }

    public function resetSearchData()
    {
        $this->reset('search', 'department', 'city', 'system', 'level');

        session()->forget('find_school_search');

        session()->forget('find_school_city');

        session()->forget('find_school_department');

        session()->forget('find_school_level');

        session()->forget('find_school_system');
    }

    public function updatedSearch($search)
    {
        if(strlen($search) > 4){

            session()->put('find_school_search', $search);
        }
    }

    public function updatedDepartment($department)
    {
        $this->resetErrorBag('department');

        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_key = (array_keys($departments, $department))[0];

        $this->department_name = $department;

        session()->put('find_school_department', $department);

    }


    public function updatedCity($city)
    {
        session()->put('find_school_city', $city);
    }

    public function updatedLevel($level)
    {
        session()->put('find_school_level', $level);
    }

    public function updatedSystem($system)
    {
        session()->put('find_school_system', $system);
    }

    public function searcher()
    {
        $this->searching = false;

        $query = School::query();

        if($this->system){

            $query->where('system', $this->system);

        }
        if($this->department){

            $query->where('department', $this->department);
            
        }
        if($this->level){

            $query->where('level', $this->level);
            
        }
        if($this->city){

            $query->where('city', $this->city);
            
        }
        if($this->search && strlen($this->search) > 4){

            $value = '%' . $this->search . '%';

            $query->whereAny(['name', 'simple_name', 'slug', 'contacts', 'created_by'], 'like', $value);
            
        }

        return $query->where('is_active', true)->get();
    }
}
