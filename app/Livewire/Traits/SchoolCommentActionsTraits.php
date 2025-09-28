<?php

namespace App\Livewire\Traits;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\Robots\SpatieManager;
use App\Models\SchoolComment;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;

trait SchoolCommentActionsTraits{

	use Toast, Confirm;

    public function deleteComment($comment_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                    <p> Vous êtes sur le point de supprimer ce commentaire ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est irréversible, le commentaire sera définitivement! </p>";

        $options = ['event' => 'confirmCommentDeletion', 'confirmButtonText' => 'Supprimer commentaire', 'cancelButtonText' => 'Annulé', 'data' => ['comment_id' => $comment_id]];

        $this->confirm($html, $noback, $options);

    }

    #[On('confirmCommentDeletion')]
    public function confirmCommentRemoving($data)
    {
        $comment_id = $data['comment_id'];

        if($comment_id){

            $comment = SchoolComment::where('id', $comment_id)->first();

            if($comment){

                $message = "Le commentaire " . mb_substr($comment->content, 0, 10) . " a été supprimé avec succès!";

                $deleted = $comment->delete();

                if($deleted){

                    Notification::sendNow([auth_user()], new RealTimeNotification($message));

                    return;
                }
                else{
                    return $this->toast( "Une erreure s'est produite lors de la supression du commentaire << {$message} >> !", 'error');
                }
            }
            else{
                return $this->toast( "Erreur donnée introuvable!", 'error');
            }
        }
    }
    
	public function approveComment($comment_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment approuvé ou réafficher ce commentaire ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Il sera visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmToUnHiddenComment', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['comment_id' => $comment_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToUnHiddenComment')]
    public function onUnHideComment($data)
    {
        if($data){

            $comment_id = $data['comment_id'];

            if($comment_id){

                $comment = SchoolComment::find($comment_id);

                if($comment){

                    $message = "Le commentaire " . mb_substr($comment->content, 0, 10) . " a été approuvé avec succès!";

                    $hidden = $comment->update(['hidden' => false]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("Le commentaire n'a pas été approuvé suite à une erreure", 'error');
				}
            }
			else{

				return $this->toast("Le commentaire n'a pas été approuvé suite à une erreure", 'error');
			}
        }
    }

	public function hideComment($comment_id)
    {
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer ce commentaire ? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Il ne sera plus visible par vos visiteurs! </p>";

        $options = ['event' => 'confirmCommentHidden', 'confirmButtonText' => 'Masquer', 'cancelButtonText' => 'Annulé', 'data' => ['comment_id' => $comment_id]];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmCommentHidden')]
    public function onHideComment($data)
    {
        if($data){

            $comment_id = $data['comment_id'];

            if($comment_id){

                $comment = SchoolComment::find($comment_id);

                if($comment){

                    $message = "Le commentaire " . mb_substr($comment->content, 0, 10) . " a été masqué avec succès!";

                    $hidden = $comment->update(['hidden' => true]);

                    if($hidden){

                        Notification::sendNow([auth_user()], new RealTimeNotification($message));

                        return;
                    }

                }
				else{

					return $this->toast("Le commentaire n'a pas été masqué suite à une erreure", 'error');
				}
            }
			else{

				return $this->toast("Le commentaire n'a pas été masqué suite à une erreure", 'error');
			}
        }
    }

	public function hideAllComments()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment masquer tous les commentaires? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Ils ne seront plus visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToHideAllComments', 'confirmButtonText' => 'Masquer tout commentaire', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToHideAllComments')]
    public function onHideAllComments()
    {
        $message = "Touts les commentaires publiés sont à présents masqués!";

		$updates = $this->school->comments()->where('hidden', false)->update(['hidden' => true]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));
			return;
		}
    }

    public function unhideAllComments()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment approuver et réafficher tous les commentaires masqués? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Ils seront désormais visibles par vos visiteurs! </p>";

        $options = ['event' => 'confirmToUnHideAllComments', 'confirmButtonText' => 'Approuver et afficher tout', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToUnHideAllComments')]
    public function onUnHideAllComments()
    {
        $message = "Touts les commentaires publiés non affichés ou masqués sont à présents visibles!";

		$updates = $this->school->comments()->where('hidden', true)->update(['hidden' => false]);

		if($updates){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));
			return;
		}
    }

    public function deleteAllComments()
    { 
        SpatieManager::ensureThatAssistantCan(auth_user_id(), $this->school->id, [], true);

        $html = "<h6 class='font-semibold text-base text-sky-400 py-0 my-0'>
                    <p> Voulez-vous vraiment supprimer les 10 anciens commentaires publiés? </p>
                </h6>";

        $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Ils seront définitivement supprimés! </p>";

        $options = ['event' => 'confirmToDeleteAllComments', 'confirmButtonText' => 'Tout supprimer', 'cancelButtonText' => 'Annuler'];

        $this->confirm($html, $noback, $options);
    }

    #[On('confirmToDeleteAllComments')]
    public function ondeleteAllComments()
    {
        $message = "Les 10 anciens commentaires publiés ont été supprimés avec succès!";

		$deleteds = $this->school->comments()->orderBy('created_at', 'desc')->take(10)->delete();

		if($deleteds){

			Notification::sendNow([auth_user()], new RealTimeNotification($message));
			return;
		}
    }
}