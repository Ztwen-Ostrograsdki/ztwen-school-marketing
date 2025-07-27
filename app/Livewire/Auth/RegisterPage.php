<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\ModelsRobots;
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
    
    public $user;

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

    public $marital_status;

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

                    $this->user = $user;

                    $this->title = "Mise à jour du compte " . $user->email;

                    self::setDefaultValues();
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

    public function setDefaultValues()
    {
        $this->email = $this->user->email;

        $this->firstname = $this->user->firstname;

        $this->lastname = $this->user->lastname;

        $this->contacts = $this->user->contacts;

        $this->address = $this->user->address;

        $this->gender = $this->user->gender;

        $this->pseudo = $this->user->pseudo;

        $this->marital_status = $this->user->marital_status;

        $this->photo_path = $this->user->photo_path;

        $this->department = $this->user->department;

        $this->city = $this->user->city;

        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_key = (array_keys($departments, $this->department))[0];

        $this->department_name = $this->department;

        $this->photo_path = $this->user->profil_photo;

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

            if(!$this->user->profil_photo || ($this->user->profil_photo && !Storage::disk('public')->exists($this->user->profil_photo))){

                $this->validate(
                    [
                        'firstname' => 'required|string',
                        'lastname' => 'required|string',
                        'contacts' => 'required|string',
                        'department' => 'required|string',
                        'city' => 'required|string',
                        'lastname' => 'required|string',
                        'gender' => 'required|string',
                        'profil_photo' => 'required|image|mimes:jpeg,png,jpg|max:4000',
                    ]
                );

                if($this->validatePhoneNumber()){

                    self::updator();

                }
                else{

                    return $this->addError('contacts', "Le format des contacts est incorrect");

                }

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
                    ]
                );
                if($this->validatePhoneNumber()){

                    self::updatorWithoutProfilPhoto();

                }
                else{

                    return $this->addError('contacts', "Le format des contacts est incorrect");

                }
            }

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
                    'email' => 'required|email|unique:users|min:3|max:255',
                    'password' => 'string|required|min:4|confirmed',
                    'profil_photo' => 'required|image|mimes:jpeg,png,jpg|max:4000',
                ]
            );

            if($this->validatePhoneNumber()){

                self::creator();

            }
            else{

                return $this->addError('contacts', "Le format des contacts est incorrect");

            }
        }
    }

    public function updator()
    {
        
        $user = false;

        $photo_root = "profil_photos";
        
        DB::beginTransaction();

        try {

            if (!Storage::disk('public')->exists($photo_root)) {

                Storage::disk('public')->makeDirectory($photo_root);
            }

            if(!Storage::disk('public')->exists($photo_root)){

                $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

                return;
            }

            $this->extension = $this->profil_photo->extension();

            $this->file_name = self::fileNameGenerator();

            $profil_upadted = self::profilPhotoUpdater($photo_root);

            session()->put('registring_photo_path', $this->photo_path);

            session()->put('old_profil_photo_path', $this->user->profil_photo);
            
            if($profil_upadted){

                $data = [
                    'department' => $this->department_name,
                    'city' => $this->city,
                    'contacts' => $this->contacts,
                    'gender' => ucwords($this->gender),
                    'marital_status' => ucwords($this->marital_status),
                    'pseudo' => ucwords($this->pseudo),
                    'firstname' => Str::upper($this->firstname),
                    'lastname' => ucwords($this->lastname),
                    'profil_photo' => $this->photo_path,
                ];

                if($data){

                    if(true){ //Véfifier si connecter ici

                        $user = $this->user->update($data);

                        if($user){

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
                    else{

                        $message = "L'incription a échoué, vous n'êtes pas connecté à internet!";

                        self::deletePhotoFromStorage();

                        session()->flash('error', $message);

                        $this->toast($message, 'error', 7000);
                    }

                    
                }
            }

            if($user){

                session()->forget('registring_photo_path');

                self::deletePhotoFromStorage(session('old_profil_photo_path'));
            }

            DB::commit();


        } catch (Throwable $e) {

            DB::rollBack(); // Annule tout

            self::deletePhotoFromStorage();

            $this->toast("Une erreure est survenue lors l'insertion de vos données dans la base de données: MESSAGE: " . $e->getMessage(), 'info');

            
        }
        
    }


    public function updatorWithoutProfilPhoto()
    {
        
        $user = false;

        DB::beginTransaction();

        try {

            if(true){

                $data = [
                    'department' => $this->department_name,
                    'city' => $this->city,
                    'contacts' => $this->contacts,
                    'gender' => ucwords($this->gender),
                    'marital_status' => ucwords($this->marital_status),
                    'pseudo' => ucwords($this->pseudo),
                    'firstname' => Str::upper($this->firstname),
                    'lastname' => ucwords($this->lastname),
                ];

                if($data){

                    if(true){ //Véfifier si connecter ici

                        $user = $this->user->update($data);

                        if($user){

                            $message = "Incription lancée avec succès! Un courriel vous a été envoyé pour confirmation, veuillez vérifier votre boite mail.";
                
                            $this->toast($message, 'success', 5000);

                            session()->flash('success', $message);

                        }
                        else{

                            $message = "L'incription a échoué! Veuillez réessayer!";
                
                            session()->flash('error', $message);
                
                            $this->toast($message, 'error', 7000);
                
                        }
                    }
                    else{

                        $message = "L'incription a échoué, vous n'êtes pas connecté à internet!";

                        session()->flash('error', $message);

                        $this->toast($message, 'error', 7000);
                    }

                    
                }
            }

            DB::commit();


        } catch (Throwable $e) {

            DB::rollBack(); // Annule tout

            $this->toast("Une erreure est survenue lors l'insertion de vos données dans la base de données: MESSAGE: " . $e->getMessage(), 'info');

            
        }
        
    }



    

    public function creator()
    {
        
        $user = false;

        $sendEmailToUser = false;

        $this->pseudo = ModelsRobots::generatePseudo($this->firstname);
        
        $all_data_is_ok = true;

        $identifiant = "ZTW@MRKT-" . date('Y') . generateRandomNumber(6);

        $photo_root = "profil_photos";
        
        DB::beginTransaction();

        try {

            if (!Storage::disk('public')->exists($photo_root)) {

                Storage::disk('public')->makeDirectory($photo_root);
            }

            if(!Storage::disk('public')->exists($photo_root)){

                $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

                return;
            }

            $this->extension = $this->profil_photo->extension();

            $this->file_name = self::fileNameGenerator();

            // $this->profil_photo->storeAs($photo_root, $this->file_name . '.' . $this->extension);

            $this->profil_photo->storeAs($photo_root, $this->file_name . '.' . $this->extension, ['disk' => 'public']);

            $this->photo_path =  $photo_root . '/' . $this->file_name . '.' . $this->extension;

            session()->put('registring_photo_path', $this->photo_path);

            
            if($all_data_is_ok){

                $data = [
                    'department' => $this->department_name,
                    'city' => $this->city,
                    'contacts' => $this->contacts,
                    // 'address' => ucwords($this->address),
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

                    if(__isConnectedToInternet()){

                        $user = User::create($data);

                        if($user){

                            $sendEmailToUser = $user->sendVerificationLinkOrKeyToUser();

                            $sendEmailToUser = true;
            
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
                    else{

                        $message = "L'incription a échoué, vous n'êtes pas connecté à internet!";

                        self::deletePhotoFromStorage();

                        session()->flash('error', $message);

                        $this->toast($message, 'error', 7000);
                    }

                    
                }
            }

            

            if($user && $sendEmailToUser){

                redirect(route('email.verification', ['token' => env('APP_MY_TOKEN'), 'email' => $user->email]))->with('success', "Confirmer votre compte en renseignant le code qui vous été envoyé!");

                session()->forget('registring_photo_path');
            }

            DB::commit();


        } catch (Throwable $e) {

            DB::rollBack(); 

            self::deletePhotoFromStorage();

            $this->toast("Une erreure est survenue lors l'insertion de vos données dans la base de données: MESSAGE: " . $e->getMessage(), 'info');

            
        }
        
    }

    public function deletePhotoFromStorage($path = null)
    {

        if(!$path){

            $path = session('registring_photo_path');
        }

        if($path){

            if (Storage::disk('public')->exists($path)) {

                return Storage::disk('public')->delete($path);
            }
        }

    }

    public function fileNameGenerator()
    {
        return getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);
    }

    public function updatedEmail($email)
    {
        $this->resetErrorBag('email');
    }

    public function updatedProfilPhoto($profil_photo)
    {
        $this->resetErrorBag('profil_photo');
    }

    public function updatedDepartment($department)
    {
        $this->resetErrorBag('department');

        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_name = $departments[$department];

        $this->department_key = (array_keys($departments, $this->department_name))[0];
        
    }

    public function updatedLastname($lastname)
    {
        $this->resetErrorBag('lastname');
    }

    public function updatedFirstname($firstname)
    {
        $this->resetErrorBag('firstname');
    }

    public function updatedCity($city)
    {
        $this->resetErrorBag('city');
    }

    public function updatedGender($gender)
    {
        $this->resetErrorBag('gender');
    }

    public function updatedPassword($password)
    {
        $this->resetErrorBag('password');
    }

    public function updatedPasswordConfirmation($password_confirmation)
    {
        $this->resetErrorBag('password');

        if($password_confirmation === $this->password){

            $this->resetErrorBag('password');

        }
        
    }

    public function validatePhoneNumber()
    {
        $contacts = $this->contacts;

        $this->resetErrorBag('contacts');

        if(!$this->contacts){

            $this->addError('contacts', "Vous devez renseigner votre contact!");

            return false;
        }

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

                        return false;
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

                        return false;
                    }
                    else{
                        return true;
                    }
                }
                else{
                    $this->addError('contacts', "Le formats n'est pas conforme séparer vos numéros pas des tirets");

                    return false;
                }
            }

        }
        else{

            $this->addError('contacts', "Le formats des contacts n'est pas conforme");

            return false;
        }

        return true;
    }

    public function profilPhotoUpdater($root)
    {
        if($this->profil_photo){

            $this->extension = $this->profil_photo->extension();

            $this->file_name = self::fileNameGenerator();

            $save = $this->profil_photo->storeAs($root, $this->file_name . '.' . $this->extension, ['disk' => 'public']);

            $this->photo_path =  $root . '/' . $this->file_name . '.' . $this->extension;

            session()->put('registring_photo_path', $this->photo_path);

            if($save && Storage::disk('public')->exists($this->photo_path)){

                return true;

            }
            else{

                $this->toast("Une erreure est survenue, veuillez réessayer", 'error', 5000);

                return false;
            }
        }

        return false;
    }


}
