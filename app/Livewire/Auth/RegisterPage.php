<?php

namespace App\Livewire\Auth;

use App\Helpers\Robots\RobotsBeninHelpers;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RegisterPage extends Component
{
    public $email;

    public $firstname;

    public $lastname;

    public $contacts;

    public $address;

    public $gender;

    public $password;
    
    public $profil_photo;

    public $password_confirmation;

    public $pseudo;

    public $file_name;

    public $extension;

    public $photo_path;

    public $department;

    public $department_key;

    public $department_name;

    public function render()
    {
        $cities = RobotsBeninHelpers::getCities();

        $departments = RobotsBeninHelpers::getDepartments();

        $genders = [
            'Féminin' => "Féminin",
            'Masculin' => "Masculin",
            'Autre' => "Autre",
        ];

        $marital_statuses = [

            'Marié' => "Marié",
            'Divorcé' => "Divorcé",
            'Célibataire' => "Célibataire",
            'Fiancé' => "Fiancé",
            'Autre' => "Autre",

        ];

        return view('livewire.auth.register-page', compact('departments', 'cities', 'genders', 'marital_statuses'));
    }

    public function register()
    {
        
    }


    public function updatedDepartment($department)
    {
        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_name = $departments[$department];

        $this->department_key = $department;
    }


    

    public function validatePhoneNumber()
    {
        $contacts = $this->contacts;

        $this->resetErrorBag('contacts');

        if(strlen($contacts) >= 10){

            if(strpos($contacts, "-")){

                $validator = true;

                $parts = explode("-", $contacts);

                foreach($parts as $number){

                    $validator = Validator::make(
                        data: [
                            'contacts' => $number
                        ],
                        rules: [
                            'contacts' => ['required', 'numeric', 'starts_with:01', 'digits:10']
                        ],
                    );

                    if($validator->fails()){

                        $this->addError('contacts', "Chaque numéro doit contenir au moins 10 chiffres");
                    }
                }
            }
            else{
                if(strlen($contacts) == 10){

                    $validator = Validator::make(
                        data: [
                            'contacts' => $contacts
                        ],
                        rules: [
                            'contacts' => ['required', 'numeric', 'starts_with:01', 'digits:10']
                        ],
                    );

                    if($validator->fails()){

                        $this->addError('contacts', "Chaque numéro doit contenir au moins 10 chiffres et commencer par 01");
                    }
                    else{
                        return true;
                    }
                }
                else{
                    $this->addError('contacts', "Le formats n'est pas conforme séparer vos numéros pas des tirets");
                }
            }

        }
        else{

            $this->addError('contacts', "Le formats des contacts n'est pas conforme");
        }

        return true;
    }
}
