<?php
namespace App\Helpers\Services;


use App\Jobs\JobToDelayedSubscription;
use App\Models\School;

class SubscriptionsDelayedService{


	//@array of schools $var = schools 
	//@return void
	public static function runner($schools = null)
	{
		if(!$schools){
			$auth = auth_user();

			if($auth){

				$current_subscription = $auth->current_subscription;

				if($current_subscription && $current_subscription->is_active && $current_subscription->will_closed_at < now()){

					JobToDelayedSubscription::dispatch($current_subscription)->withoutOverlapping();
				}
			}
		}
		else{

			if(count($schools) > 0){

				foreach($schools as $school){

					$current_subscription = $school->current_subscription;

					if($current_subscription && $current_subscription->is_active && $current_subscription->will_closed_at < now()){

						JobToDelayedSubscription::dispatch($current_subscription);
					}
				}
			}
		}
	}
}