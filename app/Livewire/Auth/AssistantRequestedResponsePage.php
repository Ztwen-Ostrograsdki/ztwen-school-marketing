<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\AssistantRequestApprovedEvent;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Models\AssistantRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title("Réponse à la requête de la demande d'assistance")]
class AssistantRequestedResponsePage extends Component
{
    use Toast;

    public $request_uuid;

    public $assistant_request;
    
    #[Validate('required|string')]
    public $token;

    public $assistant_uuid;

    public $assistant;

    public $sender_uuid;

    public $sender;

    public $school;

    public $key_expired = false;

    public $not_request_sent = false;

    public $request_approved_successfully = false;

    
    public function mount($request_uuid, $assistant_uuid, $sender_uuid, $token = null)
    {
        if($request_uuid && $assistant_uuid && $sender_uuid){

            $request = AssistantRequest::where('uuid', $request_uuid)->firstOrFail();

            if($request->director_id == auth_user()->id){

                return abort(403);
            }

            if($request){

                if($request->director->uuid == $sender_uuid && $request->assistant->uuid == $assistant_uuid){

                    if($request->status !== 'Approuvé'){

                        $this->request_uuid = $request_uuid;

                        $this->assistant_request = $request;

                        $this->school = $request->school;

                        $this->assistant = $request->assistant;

                        $this->sender_uuid = $sender_uuid;

                        $this->sender = $request->director;

                        if($token){

                            $this->token = $token;

                            self::approvedRequest();

                        }

                    }
                    else{

                        return redirect($request->assistant->to_profil_route());

                    }
                }
                else{

                    return abort(403);
                }

            }
            else{

                $this->not_request_sent = true;
            }

        }
        else{

            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.auth.assistant-requested-response-page');
    }


    public function approvedRequest()
    {
        $token = $this->token;

        $hash_key = $this->assistant_request->token;

        $delay = $this->assistant_request->delay;

        $check = Hash::check($token, $hash_key);

        if($check){

            $this->key_expired = $delay < now();

            if(!$this->key_expired){

                DB::beginTransaction();

                try {
                    
                    $this->assistant_request->update(['status' => 'Approuvé', 'approved_at' => now()]);

                    DB::commit();

                    DB::afterCommit(function(){

                        AssistantRequestApprovedEvent::dispatch($this->assistant_request);

                        $this->request_approved_successfully = true;

                        $message = "Votre demande d'assistance pour la gestion de l'école " . $this->school->name . " envoyée à " . $this->assistant->getUserNamePrefix(true, true) . " a été approuvé avec succès il y'a quelques minutes.";

                        JobToSendSimpleMailMessageTo::dispatch($this->assistant_request->director->email, $this->assistant_request->director->name, $message, "DEMANDE APPROUVEE", null, $this->assistant_request->director->to_my_assistants_list_route());

                    });


                } catch (\Throwable $th) {
                    
                    DB::rollBack();

                    $this->toast("Une erreure s'est produite, veuillez vérifier la requête et réessayer! : " . $th->getMessage(), 'error');
                }
            }
            else{

                $this->assistant_request->delete();

                return abort(419);
            }
        }

    }


    public function submit()
    {
        $this->validate();

        self::approvedRequest();
    }
}
