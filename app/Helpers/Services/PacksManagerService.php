<?php
namespace App\Helpers\Services;


class PacksManagerService{

	public static function getPacks()
	{
		return [
			'Basic' => "Basic",
			'Pro' => "Pro",
			'Premium' => "Premium",
			'Premium-Gold' => "Premium-Gold"
		];

	}


	public static function getPrivileges($pack = null)
	{
		$data = [
			'Basic' => [
				"Publications des images",
				"Publications des infos|Communiqués|Offres",
				"Publicité de votre école sur la plateforme",
			],
			'Pro' => [
				"Publications des images",
				"Publications des statistiques de votre école aux examens",
				"Possibilité d'enroler des assistants pour la gestion adéquate de votre école",
				"Publications des infos|Communiqués|Offres",
				"Publicité de votre école sur la plateforme",
				"Notification en temps réels par email",
				"Votre école apparaît en première page sur la plateforme",
			],
			'Premium' => [
				"Publications des images",
				"Publications des statistiques de votre école aux examens",
				"Possibilité d'enroler des assistants pour la gestion adéquate de votre école",
				"Publications des infos|Communiqués|Offres",
				"Publicité de votre école sur la plateforme",
				"Notification en temps réels par email",
				"Notification en temps réels par sms",
				"Votre école apparaît en première page sur la plateforme",
				"Classement dans les écoles élites pour les visiteurs et système de suivi|like par les internautes",
				"Recever de façon instantanée des notifications de tous ceux qui visitent votre page",
			],
			'Premium-Gold' => [
				"Publications des images",
				"Publications des statistiques de votre école aux examens",
				"Possibilité d'enroler des assistants pour la gestion adéquate de votre école",
				"Publications des infos|Communiqués|Offres",
				"Publicité de votre école sur la plateforme",
				"Notification en temps réels par email",
				"Notification en temps réels par sms",
				"Votre école apparaît en première page sur la plateforme",
				"Classement dans les écoles élites pour les visiteurs et système de suivi|like par les internautes",
				"Recever de façon instantanée des notifications de tous ceux qui visitent votre page",
				"Une semaine gratuite après expiration de votre abonement"
			]

		];

		return $pack ? ($data[$pack] ? $data[$pack] : []) : $data;

	}


	public static function getDetails($pack)
	{
		$data = [
			'Basic' => [
				'max_images' => 8,
				'max_assistants' => 0,
				'max_stats' => 0,
				'max_infos' => 8,
				'notify_by_email' => false,
				'notify_by_sms' => false,

			],
			'Pro' => [
				'max_images' => 16,
				'max_assistants' => 2,
				'max_stats' => 3,
				'max_infos' => 16,
				'notify_by_email' => true,
				'notify_by_sms' => false,


			],
			'Premium' => [
				'max_images' => 32,
				'max_assistants' => 4,
				'max_stats' => 6,
				'max_infos' => 32,
				'notify_by_email' => true,
				'notify_by_sms' => true,


			],
			'Premium-Gold' => [
				'max_images' => 50,
				'max_assistants' => 10,
				'max_stats' => 15,
				'max_infos' => 25,
				'notify_by_email' => true,
				'notify_by_sms' => true,
			]

		];

		return $pack ? ($data[$pack] ? $data[$pack] : []) : $data;
	}


	public static function getIASIAccessLevel($pack = null)
	{
		$data = [
			'Basic' => 'ii',
			'Pro' => 'iasi',
			'Premium' => 'iasi',
			'Premium-Gold' => 'iasi',
		];

		return $pack ? ($data[$pack] ? $data[$pack] : []) : $data;
	}
}