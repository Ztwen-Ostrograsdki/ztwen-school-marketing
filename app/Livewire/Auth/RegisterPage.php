<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\RobotsBeninHelpers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class RegisterPage extends Component
{
    use Toast, WithFileUploads;
    
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

    public $city;

    public $department_key;

    public $department_name;

    public $updating = false;

    public $title = "Inscription";


    public function mount($uuid = null)
    {
        if($uuid){

            if(Auth::user()){

                $user = User::where('uuid', $uuid)->firstOrFail();

                if($user && $user->uuid == Auth::user()->uuid){

                    $this->updating = true;

                    $this->title = "Mise à jour des informations de " . $user->email;
                }
                else{

                    return abort(403);
                }

            }
            else{

                return to_route('login');
            }
        }
        
    }

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
        if(Auth::user() && $this->updating){


        }
        else{

            self::creator();
        }
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


    public function creator()
    {

        $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";
            
        return $this->toast($message, 'success', 5000);

        $user = false;

        $sendEmailToUser = false;

        $this->pseudo = '@' . Str::substr($this->firstname, 0, 3) . '.' . Str::substr($this->lastname, 0, 3) . '' . rand(20, 99);

        if($this->profil_photo){

            $this->validate(
                [
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'contacts' => 'required|string',
                    'department' => 'required|string',
                    'city' => 'required|string',
                    'lastname' => 'required|string',
                    'gender' => 'required|string',
                    'lastname' => 'required|string',
                    'email' => 'required|email|unique:users|min:3|max:255',
                    'password' => 'string|required|min:4|confirmed',
                    'profil_photo' => 'required|image|mimes:jpeg,png,jpg|max:4000',
                ]
            );
        }
        else{

            $this->validate(
                [
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'contacts' => 'required|string',
                    'department' => 'required|string',
                    'city' => 'required|string',
                    'lastname' => 'required|string',
                    'gender' => 'required|string',
                    'lastname' => 'required|string',
                    'email' => 'required|email|unique:users|min:3|max:255',
                    'password' => 'string|required|min:4|confirmed',
                ]
            );
        }

        $all_data_is_ok = true;

        $identifiant = "ZTW@MRKT-" . date('Y') . generateRandomNumber(6);

        $photo_root = "profil_photos";
        
        DB::beginTransaction();

        try {

            if($this->profil_photo){


                if (!Storage::disk('local')->exists($photo_root)) {

                    Storage::disk('local')->makeDirectory($photo_root);
                }

                if(!Storage::disk('local')->exists($photo_root)){

                    $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

                    // return  Notification::sendNow([auth_user()], new RealTimeNotificationGetToUser("Erreure stockage: La destination de sauvegarde est introuvable"));

                }

                $this->extension = $this->profil_photo->extension();

                $this->file_name = self::fileNameGenerator();

                $this->profil_photo->storeAs($photo_root, $this->file_name . '.' . $this->extension);

                $this->photo_path =  $photo_root . '/' . $this->file_name . '.' . $this->extension;
            
            }

            
            if($all_data_is_ok){

                $data = [
                    'matricule' => $this->matricule,
                    'job_city' => $this->job_city,
                    'job_department' => $this->job_department,
                    'grade' => $this->grade,
                    'school' => $this->school,
                    'contacts' => $this->contacts,
                    'address' => ucwords($this->address),
                    'gender' => ucwords($this->gender),
                    'marital_status' => ucwords($this->marital_status),
                    'pseudo' => ucwords($this->pseudo),
                    'password' => Hash::make($this->password),
                    'firstname' => Str::upper($this->firstname),
                    'lastname' => ucwords($this->lastname),
                    'auth_token' => Str::replace("/", $identifiant, Hash::make($identifiant)),
                    'email' => $this->email,
                    'profil_photo' => $this->photo_path,
                ];

                if($data){

                    $user = User::create($data);

                    if($user){

                        $sendEmailToUser = $user->sendVerificationLinkOrKeyToUser();
            
                        $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";
            
                        $this->toast($message, 'success', 5000);
        
                        session()->flash('success', $message);

                    }
                    else{

                        self::deletePhotoFromStorage();
            
                        $message = "L'incription a échoué! Veuillez réessayer!";
            
                        session()->flash('error', $message);
            
                        $this->toast($message, 'error', 7000);
            
                    }
                }
            }

            DB::commit();

            if($user && $sendEmailToUser){

                self::deletePhotoFromStorage();

                return redirect(route('email.verification', ['email' => $this->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");
            }


        } catch (Throwable $e) {

            DB::rollBack(); // Annule tout

            self::deletePhotoFromStorage();

            $this->toast("Une erreure est survenue lors l'insertion de vos données dans la base de données: MESSAGE: " . $e->getMessage(), 'info');

            
        }
        
    }

    public function deletePhotoFromStorage($path = null)
    {

        $path =  storage_path('app/') . $this->photo_path;

        if (Storage::disk('local')->exists($path)) {

            return Storage::disk('local')->delete($path);
        }

    }

    public function fileNameGenerator()
    {
        return getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);
    }
}
