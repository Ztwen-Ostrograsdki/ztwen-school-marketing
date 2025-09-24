<?php
namespace App\Helpers\Robots;

use App\Models\AssistantRequest;
use App\Models\School;
use App\Models\User;

trait SpatieManager{

	public static function getMemberDashboard($user_id = null)
	{
		return self::getUserDashboard($user_id);
	}

	public static function ensureThatUserHasNotSchool(User $user)
	{
		return count($user->schools) < 1;
	}


	public static function getUserDashboard($user_id = null)
	{
		if(!$user_id) $user = User::find(auth_user_id());

		else $user = User::find($user_id);

		if($user->isAdminsOrMaster()) 

			return [
				'dashboard' => "Tableau de bord",
				'stats' => "Statistiques plateforme",
				'spatie-roles' => "Les roles (admins)",
				'roles' => "Les Postes",
				// 'spatie-permissions' => "Les permissions (admins)",
				'users-list' => "Utilisateurs",
				'payments' => "Les Payements",
				'schools' => "Les Lycées et centres",
				'laws' => "Le règlement intérieur",
				// 'subjects' => "Les Sujets de discussion",
				'infos' => "Les Communiqués",
				'epreuves' => "Les Epreuves",
				'supports-files' => "Les Supports de cours",
				'epreuves-exams-list' => "Les Epreuves d'examens",
		
			];
		else

			if($user->hasRole(['schools-manager'])) return [
				'schools' => "Les Lycées et centres",
			];

			if($user->hasRole(['users-manager', 'members-manager'])) return [
				'users-list' => "Utilisateurs",
				'members-list' => "Liste des membres",
				'members' => "Profil des membres",
				'members-cards' => "Cartes de membre",
			];

			if($user->hasRole(['epreuves-manager'])) return [
				'epreuves' => "Les Epreuves",
				'epreuves-exams-list' => "Les Epreuves d'examens",
				'supports-files' => "Les Supports de cours",
			];
			
			if($user->hasRole(['schools-manager'])) return [
				'schools' => "Les Lycées et centres",
			];
			
			if($user->hasRole(['infos-manager'])) return [
				'infos' => "Les Communiqués",
			];
			else return [];




	}


	public static function getPermissions(?string $data = null) : ?array
	{
		$permissions_on_users = [
			'edit users', 
			'delete users',
			'view users',
			'assign roles', 
			'access dashboard', 
			'update settings'
		];
		
		$permissions_on_epreuves = [
			'edit epreuves', 
			'delete epreuves', 
			'create epreuve'
		];

		$permissions_on_packs = [
			'edit packs', 
			'delete packs', 
			'create packs'
		];

		$permissions_on_subscriptions = [
			'edit subscriptions', 
			'delete subscriptions', 
			'create subscriptions'
		];

		$permissions_on_assistants = [
			'edit assistants', 
			'delete assistants', 
			'create assistants'
		];

		$permissions_on_stats = [
			'edit stats', 
			'delete stats', 
			'create stats'
		];

		$permissions_on_school_images = [
			'edit school images', 
			'delete school images', 
			'create school images'
		];

		$permissions_on_infos = [
			'create infos',
			'edit infos', 
			'delete infos',
		];

		$permissions_on_schools = [
			'create schools', 
			'edit schools', 
			'delete schools',
		];


		$permissions_on_admins = [
			'create admins', 
			'edit admins', 
			'delete admins',
		]; 
		
		$permissions_on_payments = [
			'create payments', 
			'edit payments', 
			'delete payments',
		];
		
		$permissions_on_transactions = [
			'create transactions', 
			'edit transactions', 
			'delete transactions',
		];
		
		if($data){

			$existed = ${$data};

			if($data) return $existed;

			return null;


		}


		return array_merge(
			$permissions_on_users, 
			$permissions_on_epreuves,
			$permissions_on_infos,
			$permissions_on_schools,
			$permissions_on_admins,
			$permissions_on_stats,
			$permissions_on_infos,
			$permissions_on_packs,
			$permissions_on_subscriptions,
			$permissions_on_payments,
			$permissions_on_school_images,
			$permissions_on_assistants,
			$permissions_on_transactions,

		);
	}

	public static function getRoles() : ?array
	{
		$roles = [
			'master', 
			'admin-1', 
			'admin-2', 
			'admin-3', 
			'admin-4', 
			'admin-5', 
			'infos-manager', 
			'epreuves-manager', 
			'viewer', 
			'schools-manager', 
			'accounts-manager', 
			'destroyer', 
			'user-account-reseter', 
			'payments-manager', 
			'transactions-manager', 
			'stats-manager',
			'school-images-manager',
			'asssistants-manager',
			'infos-manager',
			'packs-manager',
			'subscriptions-manager',

		];

		return $roles;
	}


	public static function translateRoleName($role_name)
	{
		$data = [

			'master' => "Master (Tous les rôles) Indestructible", 
			'admin-1' => "Admin niveau 1", 
			'admin-2' => "Admin niveau 2", 
			'admin-3'=> "Admin niveau 3",
			'admin-4'=> "Admin niveau 4",
			'admin-5'=> "Admin niveau 5",
			'epreuves-manager'=> "Gestion des épreuves",
			'viewer'=> "Lecture seule",
			'schools-manager'=> "Gestion des écoles",
			'account-manager'=> "Gestion des comptes utilisateurs",
			'destroyer'=> "Destructeur",
			'user-account-reseter'=> "Réinitialisation de compte utilisateur",
			'payments-manager'=> "Gestion des payements",
			'assistants-manager'=> "Gestion des assistants",
			'packs-manager'=> "Gestion des packs",
			'subscriptions-manager'=> "Gestion des souscriptions | abonnements",
			'transactions-manager'=> "Gestion des transactions",
			'stats-manager'=> "Gestion des statistiques",
			'infos-manager'=> "Gestion des communiqués | infos | annonces",
			'school-images-manager'=> "Gestion des images des écoles",

		];

		return $role_name && isset($data[$role_name]) ? $data[$role_name] : $role_name ;


	}

	public static function getAssistantRolables()
	{
		return [
			'assistants-manager',
			'packs-manager',
			'subscriptions-manager',
			'transactions-manager',
			'stats-manager',
			'infos-manager',
			'school-images-manager',
		];
	}


	public static function translatePermissionName($permission_name)
	{
		$data = [

			'edit users' => "Editer les utilisateurs", 
			'delete users' => "Supprimer les utilisateurs",
			'view users' => "Parcourir les utilisateurs",
			'assign roles' => "Attribuer des rôles", 
			'access dashboard' => "Accès à la page d'administration", 
			'update settings' => "Mettre à jour les réglages",
			'edit epreuves' => "Editer les épreuves", 
			'delete epreuves' => "Supprimer les épreuves", 
			'create epreuve' => "Créer les épreuves",
			'create infos' => "Créer les communiqués | infos | annonces",
			'edit infos' => "Editer les communiqués | infos | annonces", 
			'delete infos' => "Supprimer les communiqués | infos | annonces",
			'create schools' => "Créer les écoles", 
			'edit schools' => "Editer les écoles", 
			'delete schools' => "Supprimer les écoles",
			'create admins' => "Créer des roles et permissions administrateurs", 
			'edit admins' => "Editer des roles et permissions administrateurs", 
			'delete admins' => "Supprimer des roles et permissions administrateurs",
			'create payments' => "Enregistrer un payement", 
			'edit payments' => "Editer un payement", 
			'delete payments' => "Supprimer un payement",
			'create transactions' => "Enregistrer une transaction", 
			'edit transactions' => "Editer une transaction", 
			'delete transactions' => "Supprimer une transaction",
			'create school images' => "Enregistrer les images d'une école", 
			'edit school images' => "Editer les images d'une école", 
			'delete school images' => "Supprimer les images d'une école",
			'create packs' => "Enregistrer un pack", 
			'edit packs' => "Editer un pack", 
			'delete packs' => "Supprimer un pack",
			'create stats' => "Enregistrer une statistique", 
			'edit stats' => "Editer une statistique", 
			'delete stats' => "Supprimer une statistique",
			'create subscriptions' => "Enregistrer une souscription | un abonnement", 
			'edit subscriptions' => "Editer une souscription | un abonnement", 
			'delete subscriptions' => "Supprimer une souscription | un abonnement",
			'create assistants' => "Enregistrer un assistant", 
			'edit assistants' => "Editer un assistant", 
			'delete assistants' => "Supprimer un assistant",

		];

		return $permission_name && isset($data[$permission_name]) ? $data[$permission_name] : $permission_name;
	}

	public static function ensureThatUserCan(?array $roles = [])
	{
		$admin = User::find(auth_user_id());

		if($roles !== [] && $roles !== null){

			$cannot = !$admin->isAdminsOrMaster() && !$admin->hasRole($roles);

		}
		else{

			$cannot = !$admin->isAdminsOrMaster();

		}

		if($cannot) return redirect()->to('/403');

	}

	public static function ensureThatAssistantCan($user_id, $school_id, ?array $roles = [], $redirect_if_unauthorized = false)
	{

		$assistant = User::find($user_id);

		$school = School::where('id', $school_id)->first();

		if(!$school->current_subscription){

			return $redirect_if_unauthorized ? redirect()->to('/403') : false;

		}
		if($school && $school->user_id == $user_id){

			return true;
		}

		if($school){

			if($assistant->assist_this_school($school_id)){

				$assistant_request = AssistantRequest::where('assistant_id', $user_id)->where('school_id', $school_id)->whereNotNull('approved_at')->where('is_active', true)->first();
			
				if(!$assistant_request) return false;
				
				foreach($roles as $role){

					if(in_array($role, $assistant_request->privileges)){

						return true;
					}
				}

				return $redirect_if_unauthorized ? redirect()->to('/403') : false;

			}
			else{

				return $redirect_if_unauthorized ? redirect()->to('/403') : false;


			}

		}

		return $redirect_if_unauthorized ? redirect()->to('/403') : false;

		
	}




}