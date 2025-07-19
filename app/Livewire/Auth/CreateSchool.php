<?php

namespace App\Livewire\Auth;

use App\Helpers\Robots\RobotsBeninHelpers;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Ajiut d'une nouvelle ecole")]
class CreateSchool extends Component
{
    public $uuid, $countries = [], $cities = [], $departments = [], $levels = [], $systems = [], $department_name, $department_key;

    public $images;

    public $city;

    public $department;

    public $country;

    public $contacts;

    public $capacity;

    public $name;

    public $system;

    public $simple_name;

    public $level;


    public function mount($uuid)
    {
        $this->uuid = $uuid;


        $this->countries = RobotsBeninHelpers::getCountries('nom');

        $this->cities = RobotsBeninHelpers::getCities();

        $this->departments = RobotsBeninHelpers::getDepartments();

        $this->levels = RobotsBeninHelpers::getLevels();

        $this->systems = RobotsBeninHelpers::getSytems();

    }
    public function render()
    {

        return view('livewire.auth.create-school');
    }

    public function updatedDepartment($department)
    {
        $departments = RobotsBeninHelpers::getDepartments();


        $this->department_key = array_keys($departments, $department)[0];
    }


    public function insert()
    {

    }
}
