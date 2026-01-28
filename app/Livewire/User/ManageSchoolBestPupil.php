<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\SpatieManager;
use App\Models\School;
use App\Models\SchoolBestPupil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Mise à jour des données : LES MEILLEURS ELEVES")]
class ManageSchoolBestPupil extends Component
{
    use Toast, WithFileUploads;

    #[Validate('required|string')]
    public $pupil_name;

    #[Validate('numeric|between:11,20')]
    public $average;

    #[Validate('required|string')]
    public $mention;

    #[Validate('required|string')]
    public $exam;

    public $data_to_save = [];

    public $school_best_pupil;

    public $error_message = '';

    public $image;

    public $details = [];

    public $details_table = [];

    public $ranks = [];

    public $ranks_table = [];

    public $done = false;

    public $subject, $mark, $zone, $rank;
   

    public $school, $user_uuid, $school_uuid, $school_slug, $best_pupil_id, $best_pupil_uuid, $school_id;

    public function mount($school_uuid, $school_slug, $best_pupil_id = null, $best_pupil_uuid = null)
    {
        if($school_slug && $school_uuid){

            $school = School::where('uuid', $school_uuid)->where('slug', $school_slug)->firstOrFail();

            if($school){

                $this->school = $school;

                self::initializer($best_pupil_id, $best_pupil_uuid);
            }
            else{

                return abort(404);
            }
        }
        else{

            return abort(404);
        }

    }

    public function render()
    {
        $mentions = ['Assez-bien', 'Bien', 'Tres Bien', 'Excellente'];

        return view('livewire.user.manage-school-best-pupil', compact('mentions'));
    }

    public function initializer($best_pupil_id = null, $best_pupil_uuid = null)
    {
        if($best_pupil_id && $best_pupil_uuid){

            $school_best_pupil = SchoolBestPupil::where('school_id', $this->school->id)->where('uuid', $best_pupil_uuid)->where('id', $best_pupil_id)->firstOrFail();

            if($school_best_pupil){

                $this->school_best_pupil = $school_best_pupil;

                $this->pupil_name = $school_best_pupil->pupil_name;

                $this->exam = $school_best_pupil->exam;

                $this->details = $school_best_pupil->details;

                $this->ranks = $school_best_pupil->ranks;

            }
            else{

                return abort(404);
            }
        } 
    }

    public function save()
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, ['stats-manager'], true);
        
        if(!$this->school->current_subscription){

            return $this->toast("Vous n'avez aucun abonnement actif actuellement; veuillez en activer un avant d'effectuer cette action!", 'info');

            return;
        }

        if($this->image){

            $this->validate([
                'image' => 'image|max:2048',
            ]);
        }

        $this->validate();

        $image_path = null;

        $root_folder =  $this->school->bestsPupilsPhotosRootFolder;
        
        if($this->image) $image_path = self::imageUploader($root_folder, $this->image);


        $subjects_marks = $this->details_table;

        $created = SchoolBestPupil::create([
            'pupil_name' => $this->pupil_name,
            'mention' => $this->mention,
            'exam' => $this->exam,
            'average' => $this->average,
            'image_path' => $image_path,
            'school_id' => $this->school->id,
            'details' => $subjects_marks,
            'ranks' => $this->ranks_table,
        ]);

        if($created){

            $this->done = true;

            $this->resetErrorBag();

            $this->reset('mark', 'mention', 'average', 'image', 'details_table', 'ranks_table');

            $this->toast("La mise à jour des données s'est bien déroulée!", 'success');

        }
        
    }


    public function undone()
    {
        $this->done = false;

        $this->reset('pupil_name');
    }


    public function removeImage()
    {
        $this->resetErrorBag('image');

        $this->reset('image');
    }

    public function imageUploader($root_folder, $image)
    {

        if (!Storage::disk('public')->exists($root_folder)) {

            Storage::disk('public')->makeDirectory($root_folder);
        }

        if(!Storage::disk('public')->exists($root_folder)){

            $this->toast("Erreure stockage: La destination de sauvegarde est introuvable", 'error');

            return;
        }

        $extension = $image->extension();

        $image_path = null;

        $file_name = $this->school->getBestPupilPhotoName($this->pupil_name, $this->exam);

        $save = $image->storeAs($root_folder, $file_name . '.' . $extension, ['disk' => 'public']);

        if($save){

            $image_path = $root_folder . '/' . $file_name . '.' . $extension;
        }
        else{

            $this->error_message = "Une erreure est survenue lors du stockage l'image , veuillez réessayer";
            
            return false;
        }

        if($this->school->current_subscription){

            return $image_path;
        }
        else{

            $this->error_message = "Une erreure est survenue lors du stockage de l'image, Vous n'avez aucun abonnement actif";
        }

        $this->error_message = "Une erreure est survenue lors du stockage de l'image, veuillez réessayer";

        return false;
            
    }

    public function updatedSubject($subject)
    {
        $this->subject = Str::upper($subject);
    }

    public function pushIntoDetails()
    {
        $this->resetErrorBag('subject', 'mark');


        $this->validate([
            'subject' => 'required|string',
            'mark' => 'required|integer|between:11,20',
        ]);

        if($this->subject && $this->mark){

            $details_table = $this->details_table;

            if(!array_key_exists($this->subject, $details_table)){

                $details_table[Str::upper($this->subject)] = $this->mark;

                $this->details_table = $details_table;

                $this->reset('subject', 'mark');

            }
            else{

                $this->toast("Cette matière est déjà ajoutée!", "warning");

                $this->addError('subject', "Cette est déjà ajoutée!");
            }


        }
        else{

            if(!$this->subject){

                $this->addError('subject', "Veuillez indiquer la matière");
            }
            
            if(!$this->mark){

                $this->addError('mark', "La note obtenue est requise");
            }
        }
    }

    public function pushIntoRanks()
    {
        $this->validate([
            'zone' => 'required|string',
            'rank' => 'required|numeric|between:1,1000',
        ]);

        if($this->rank){

            $ranks_table = $this->ranks_table;

            if(!array_key_exists($this->zone, $ranks_table)){

                $ranks_table[$this->zone] = $this->rank;

                $this->ranks_table = $ranks_table;

                $this->reset('rank', 'zone');

            }
            else{

                $this->toast("Ce détail est déjà ajouté!", "warning");

                $this->addError('zone', "Ce détail est déjà ajouté!");
            }


        }
        else{

            $this->addError('zone', "Veuillez indiquer ce champ");
        }
    }

    public function removeRankFrom($zone)
    {
        $ranks_table = $this->ranks_table;

        if(array_key_exists($zone, $ranks_table)){

            unset($ranks_table[$zone]);

            $this->ranks_table = $ranks_table;

        }
        else{

            $this->toast("Cette donnée n'a pas été ajoutée!", "warning");
        }
    }



    public function removeDetailFrom($subject)
    {
        $details_table = $this->details_table;

        if(array_key_exists($subject, $details_table)){

            unset($details_table[$subject]);

            $this->details_table = $details_table;

        }
        else{

            $this->toast("Cette matière n'a pas été ajoutée!", "warning");
        }
    }

    public function refreshRanks()
    {
        $this->reset('ranks_table');
    }


    public function refreshDetails()
    {
        $this->reset('details_table');
    }

    public function updated($field)
    {
        $this->resetErrorBag($field);
    }
}
