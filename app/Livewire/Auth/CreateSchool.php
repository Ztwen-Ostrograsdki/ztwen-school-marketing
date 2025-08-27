<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\ModelsRobots;
use App\Helpers\Robots\RobotsBeninHelpers;
use App\Helpers\Robots\SpatieManager;
use App\Models\School;
use App\Models\SchoolImage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Création | Edition d'école")]
class CreateSchool extends Component
{
    use WithFileUploads, Toast;

    public $user, $countries = [], $cities = [], $departments = [], $geographic_positions = [], $levels = [], $systems = [], $department_name, $department_key;

    public array $images = [];

    public $city;

    public $has_not_school = false;

    public $department;

    public $country = "Bénin";

    public $contacts;

    public $is_public = true;

    public $is_true = true;

    public $is_false = false;

    public $geographic_position;

    public $created_by;

    public $creation_year;

    public $capacity;

    public $name;

    public $system;

    public $simple_name;

    public $level;

    public $quotes;

    public $max_images = 2;

    public $school, $user_uuid, $school_id, $school_slug, $olds_images = [];

    public $error_message = '';

    public $folder = null;


    public function mount($user_uuid, $school_id = null, $school_slug = null)
    {
        
        if($user_uuid){

            $user = User::where('uuid', $user_uuid)->firstOrFail();

            if($user){

                $this->has_not_school = SpatieManager::ensureThatUserHasNotSchool(auth_user());

                $this->user_uuid = $user_uuid;

                $this->user = $user;
            }
        }

        self::setDefaultValues();


        if($school_slug && $school_id){

            $school = School::where('id', $school_id)->where('slug', $school_slug)->firstOrFail();

            if($school){

                $this->school = $school;

                self::setDefaultValues($school);
            }
            else{

                return abort(404);
            }
        }

    }

    public function setDefaultValues($school = null)
    {
        $this->countries = RobotsBeninHelpers::getCountries('nom');

        $this->cities = RobotsBeninHelpers::getCities();

        $this->departments = RobotsBeninHelpers::getDepartments();

        $this->levels = RobotsBeninHelpers::getLevels();

        $this->systems = RobotsBeninHelpers::getSytems();

        $this->geographic_positions = RobotsBeninHelpers::getGeographicPositions();

        if($school){

            $this->name = $school->name;

            $this->simple_name = $school->simple_name;

            $this->contacts = $school->contacts;

            $this->created_by = $school->created_by;

            $this->creation_year = $school->creation_year;

            $this->geographic_position = $school->geographic_position;

            $this->is_public = $school->is_public ? "true" : "false";

            $this->department_name = $school->department;

            $this->department = $school->department;

            $this->department_key = (array_keys($this->departments, $this->department_name))[0];


            $this->city = $school->city;

            $this->quotes = $school->quotes;

            $this->country = $school->country;

            $this->level = $school->level;

            $this->capacity = $school->capacity;

            $this->system = $school->system;

            $this->olds_images = $school->images;

            $this->folder = $school->folder;

        }
    }


    public function render()
    {

        return view('livewire.auth.create-school');
    }

    public function insert()
    {

        if(!$this->has_not_school) return false;

        if($this->school){

            $this->validate(
                [
                    'name' => 'required|string',
                    'simple_name' => 'required|string',
                    'contacts' => 'required|string',
                    'created_by' => 'required|string',
                    'creation_year' => 'required|string',
                    'geographic_position' => 'required|string',
                    'department' => 'required|string',
                    'city' => 'required|string',
                    'quotes' => 'required|string',
                    'country' => 'required|string',
                    'level' => 'required|string',
                    'capacity' => 'required|integer',
                    'system' => 'required|string',
                ]
            );
        }
        else{

            $this->validate(
                [
                    'name' => 'required|string',
                    'simple_name' => 'required|string',
                    'contacts' => 'required|string',
                    'created_by' => 'required|string',
                    'creation_year' => 'required|string',
                    'geographic_position' => 'required|string',
                    'department' => 'required|string',
                    'city' => 'required|string',
                    'quotes' => 'required|string',
                    'country' => 'required|string',
                    'level' => 'required|string',
                    'capacity' => 'required|integer',
                    'system' => 'required|string',
                    'images' => 'required|array|max:2', 
                    'images.*' => 'image|max:2048', 
                ]
            );
        }

        $v = self::validatePhoneNumber();

        if($v){

            if($this->school){

                self::updateSchool();

            }
            else{

                self::createSchool();

            }


        }
        else{

            $this->addError('contacts', "Le format des contacts est incorrect");

            return;
        }
    }

    public function createSchool()
    {
        $root_folder =  'ecoles/' . Str::random();

        session()->put('root_folder', $root_folder);

        $conflicted = School::where('name', $this->name)->where('simple_name', $this->simple_name)->where('contacts', $this->contacts)->exists();

        if($conflicted){

            $this->addError('name', "Il semble que cette école existe déjà");

            $this->addError('simple_name', "Il semble que cette école existe déjà");

            $this->toast("Il semble que cette école existe déjà", 'wraning');

            return;

        }

        
        DB::beginTransaction();

        try {

            $images_treated = self::imagesUploader($root_folder, $this->images);

            if($images_treated && !$this->error_message){

                $data = [
                    'name' => $this->name,
                    'simple_name' => $this->simple_name,
                    'contacts' => $this->contacts,
                    'is_public' => self::getIsPublicValue(),
                    'created_by' => $this->created_by,
                    'creation_year' => $this->creation_year,
                    'geographic_position' => $this->geographic_position,
                    'department' => $this->department_name,
                    'city' => $this->city,
                    'quotes' => $this->quotes,
                    'country' => $this->country,
                    'level' => $this->level,
                    'capacity' => $this->capacity,
                    'system' => $this->system,
                    'profil_images' => $images_treated,
                    'user_id' => auth_user_id(),
                    'folder' => $root_folder,
                ];

                $school = School::create($data);

                if(!$school){

                    Storage::disk('public')->deleteDirectory(session('root_folder'));

                    return $this->toast("Une erreure s'est produite lors de la migration des données!", 'error');

                }
                else{

                    $this->toast("La procédure de création de votre a été lancée", 'success');

                }

            }
            else{


                $this->toast("La requête n'a pas pu être traitée", 'error');

                return false;

            }

            session()->forget('root_folder');

            DB::commit();

            DB::afterCommit(function() use($school){

                if($school){

                    $this->toast("Votre école a été créée", 'success');

                    redirect($school->to_profil_route());
                }

            });
            
        } catch (\Throwable $th) {

            Storage::disk('public')->deleteDirectory(session('root_folder'));

            DB::rollBack();

            return $this->toast($this->error_message ? $this->error_message : "Une erreure est survenue: " . $th->getMessage(), 'error');

        }
    }

    public function updateSchool()
    {
        $conflicted = School::where('name', $this->name)->where('simple_name', $this->simple_name)->where('contacts', $this->contacts)->where('id', '<>', $this->school->id)->exists();

        if($conflicted){

            $this->addError('name', "Il semble que cette école existe déjà");

            $this->addError('simple_name', "Il semble que cette école existe déjà");

            $this->toast("Il semble que cette école existe déjà", 'wraning');

            return;

        }

        
        DB::beginTransaction();

        try {

            if(true){

                $data = [
                    'name' => $this->name,
                    'simple_name' => $this->simple_name,
                    'contacts' => $this->contacts,
                    'is_public' => self::getIsPublicValue(),
                    'created_by' => $this->created_by,
                    'creation_year' => $this->creation_year,
                    'geographic_position' => $this->geographic_position,
                    'department' => $this->department_name,
                    'city' => $this->city,
                    'quotes' => $this->quotes,
                    'country' => $this->country,
                    'level' => $this->level,
                    'capacity' => $this->capacity,
                    'system' => $this->system,
                ];

                $done = $this->school->update($data);

                if(!$done){

                    return $this->toast("Une erreure s'est produite lors de la mise à jour des données de votre école!", 'error');

                }
                else{

                    $this->toast("La procédure de mise à jour de votre a été lancée", 'success');

                }

            }
            else{


                $this->toast("La requête n'a pas pu être traitée", 'error');

                return false;

            }

            DB::commit();

            DB::afterCommit(function(){

                redirect($this->school->to_profil_route());


            });
            
        } catch (\Throwable $th) {

            DB::rollBack();

            return $this->toast($this->error_message ? $this->error_message : "Une erreure est survenue: " . $th->getMessage(), 'error');

        }

    }

    public function imagesUploader($root_folder, $images)
    {
        if (!Storage::disk('public')->exists($root_folder)) {

            Storage::disk('public')->makeDirectory($root_folder);
        }

        if(!Storage::disk('public')->exists($root_folder)){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

            return;
        }

        $images_paths = [];

        foreach($images as $image){

            $extension = $image->extension();

            $file_name = Str::slug($this->name) . '-' . getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(6);

            $save = $image->storeAs($root_folder, $file_name . '.' . $extension, ['disk' => 'public']);

            if($save){

                $images_paths[] = $root_folder . '/' . $file_name . '.' . $extension;
            }
            else{

                $this->error_message = "Une erreure est survenue lors du stockage des images, veuillez réessayer";
                
                return false;
            }
        }

        if(count($images_paths) == count($images)){

            return $images_paths;

        }

        $this->error_message = "Une erreure est survenue lors du stockage des images, veuillez réessayer";

        return false;
            
    }

    public function updatedDepartment($department)
    {
        $this->resetErrorBag('department');

        $departments = RobotsBeninHelpers::getDepartments();

        $this->department_key = (array_keys($departments, $department))[0];

        $this->department_name = $department;

    }

    public function updatedName($name)
    {
        $this->resetErrorBag('name');
    }

    public function updatedContacts($contacts)
    {
        $this->resetErrorBag('contacts');
    }

    public function updatedCity($city)
    {
        $this->resetErrorBag('city');
    }

    public function updatedCapacity($capacity)
    {
        $this->resetErrorBag('capacity');
    }

    public function updatedCountry($country)
    {
        $this->resetErrorBag('capacity');
    }

    public function updatedSimpleName($simple_name)
    {
        $this->resetErrorBag('simple_name');
    }

    public function updatedQuotes($quotes)
    {
        $this->resetErrorBag('quotes');
    }

    public function updatedLevel($level)
    {
        $this->resetErrorBag('level');
    }

    public function updatedSystem($system)
    {
        $this->resetErrorBag('system');
    }

    public function updatedImages()
    {
        $this->resetErrorBag();
    }

    public function updatedIsPublic($value)
    {
        if($value) $this->is_public = true;

        else $this->is_public = false;

    }
    
    public function getIsPublicValue()
    {
        return $this->is_public;
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);

        $this->images = array_values($this->images); 
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
}
