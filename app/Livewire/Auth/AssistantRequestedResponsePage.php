<?php

namespace App\Livewire\Auth;

use Akhaled\LivewireSweetalert\Toast;
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

    public $key_expired = false;

    public $not_request_sent = false;

    public $request_approved_successfully = false;

    
    public function mount($request_uuid, $assistant_uuid, $sender_uuid, $token = null)
    {
        if($request_uuid && $assistant_uuid && $sender_uuid){

            $request = AssistantRequest::where('uuid', $request_uuid)->firstOrFail();

            if($request){

                if($request->user->uuid == $sender_uuid && $request->assistant()->uuid == $assistant_uuid){

                    if($request->status !== 'Approuvé'){

                        $this->request_uuid = $request_uuid;

                        $this->assistant_request = $request;

                        $this->assistant = $request->assistant();

                        $this->sender_uuid = $sender_uuid;

                        $this->sender = $request->user;

                        if($token){

                            $this->token = $token;

                            self::approvedRequest();

                        }

                    }
                    else{

                        return redirect($request->assistant()->to_profil_route());

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

        $check = Hash::check($token, $hash_key);

        if($check){

            $this->key_expired = Carbon::parse($this->assistant_request->delay)->timestamp  >= Carbon::today()->timestamp;

            if(!$this->key_expired){

                DB::beginTransaction();

                try {
                    
                    $this->assistant->update(['assistant_of' => $this->sender->id]);

                    $this->request->update(['status' => 'Approuvé', 'approved_at' => Carbon::today()]);

                    DB::commit();


                    DB::afterCommit(function(){

                        $this->request_approved_successfully = true;

                        // Notify


                    });


                } catch (\Throwable $th) {
                    
                    DB::rollBack();

                    $this->toast("Une erreure s'est produite, veuillez vérifier la requête et réessayer!", 'error');
                }
            }
        }

    }


    public function submit()
    {
        $this->validate();

        self::approvedRequest();
    }
}
