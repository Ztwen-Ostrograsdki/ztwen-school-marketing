<?php

namespace App\Models;

use App\Events\NewPackSubscriptionCreatedEvent;
use App\Events\PackSubscriptionWasUpdatedEvent;
use App\Helpers\Robots\ModelsRobots;
use App\Helpers\Services\EmailTemplateBuilder;
use App\Jobs\JobToDelayedSubscription;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Jobs\JobToSendSubcriptionDetailsToTheSubcriber;
use App\Mail\MailToSendSubscriptionRefCodeToUser;
use App\Models\AssistantRequest;
use App\Models\Info;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\School;
use App\Models\SchoolImage;
use App\Models\Stat;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use App\Observers\ObserveSubscription;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

#[ObservedBy(ObserveSubscription::class)]
class Subscription extends Model
{
            
    protected $fillable = [
        'uuid',
        'unique_price',
        'months',
        'free_days',
        'observation',
        'validate_at',
        'will_closed_at',
        'privileges',
        'max_images',
        'max_stats',
        'max_infos',
        'max_assistants',
        'on_page',
        'amount',
        'seen_by',
        'notify_by_email',
        'notify_by_sms',
        'discount',
        'promoting',
        'payment_status',
        'is_active',
        'user_id',
        'payment_id',
        'school_id',
        'pack_id',
        'validate',
        'ref_key',

    ];

    protected $casts = [
        'privileges' => 'array',
        'will_closed_at' => 'datetime',
        'validate_at' => 'datetime',

    ];

    public static function booted()
    {
        static::creating(function ($subscription){

            $subscription->uuid = Str::uuid();

        });
        
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subscriber()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function images()
    {
        return $this->hasMany(SchoolImage::class);
    }

    public function infos()
    {
        return $this->hasMany(Info::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function assistants()
    {
        return $this->hasMany(AssistantRequest::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function to_details_route()
    {
        return route('subscription.details', ['subscription_uuid' => $this->uuid, 'subscription_key' => $this->ref_key]);
    }

    protected function remainingAssistants() : Attribute
    {
        $max_assistants = $this->max_assistants;

        $assistants_enrolleds = count($this->assistants);

        return Attribute::get(fn() => $max_assistants - $assistants_enrolleds);
    }

    public function assistable() : Attribute
    {
        return Attribute::get(fn() => $this->remainingAssistants > 0);
    }

    protected function remainingInfos() : Attribute
    {
        $max_infos = $this->max_infos;

        $infos_publisheds = count($this->infos);

        return Attribute::get(fn() => $max_infos - $infos_publisheds);
    }

    protected function infosable() : Attribute
    {
        return Attribute::get(fn() => $this->remainingInfos > 0);
    }


    protected function remainingStats() : Attribute
    {
        $max_stats = $this->max_stats;

        $stats_publisheds = count($this->stats);

        return Attribute::get(fn() => $max_stats - $stats_publisheds);
    }

    protected function statisable() : Attribute
    {
        return Attribute::get(fn() => $this->remainingStats > 0);
    }


    protected function remainingImages() : Attribute
    {
        $max_images = $this->max_images;

        $images_publisheds = count($this->images);

        return Attribute::get(fn() => $max_images - $images_publisheds);
    }

    protected function imageable() : Attribute
    {
        return Attribute::get(fn() => $this->remainingImages > 0);
    }

    protected function remainingDaysColor() : Attribute
    {
        return Attribute::get(fn() => self::getRemainingTextCss());
    }

    public function getRemainingTextCss()
    {
        Carbon::setLocale('fr');

        $from = $this->will_closed_at;

        $to = Carbon::today();

        $target = Carbon::parse($from);

        $joursRestants = $to->diffInDays($target, false);

        if($joursRestants >= 30) $css = "text-green-500";

        elseif(self::numberIsBetween($joursRestants, 20, 30)) $css = "text-yellow-300";
        
        elseif(self::numberIsBetween($joursRestants, 15, 20)) $css = "text-orange-500";

        elseif(self::numberIsBetween($joursRestants, 7, 15)) $css = "text-orange-300";

        elseif(self::numberIsBetween($joursRestants, 3, 7)) $css = "text-red-300";
        
        elseif(self::numberIsBetween($joursRestants, 1, 3)) $css = "text-red-400";

        elseif($joursRestants == 1) $css = "text-red-500";

        elseif($joursRestants < 0) $css = "text-fuchsia-600 animate-pulse";

        return $css;
            
    }


    public function numberIsBetween($number, $start, $end, $strict = false) : bool
    {
        return $number < $end && $number >= $start;
    }

    protected function remainingsDays() : Attribute
    {
        Carbon::setLocale('fr');

        $from = $this->will_closed_at;

        $to = Carbon::today();

        $target = Carbon::parse($from);

        $joursRestants = floor($to->diffInDays($target, false));

        return Attribute::get(fn() => $joursRestants);
    }



    public function getMaxRemainings() : array
    {
        $max_assistants = $this->max_assistants;

        $max_infos = $this->max_infos;

        $max_stats = $this->max_stats;

        $max_images = $this->max_images;

        $images_uploadeds = count($this->images);

        $stats_publisheds = count($this->stats);

        $infos_publisheds = count($this->infos);

        $assistants_enrolleds = count($this->assistants);

        return [
            'max_assistants' => $max_assistants - $assistants_enrolleds,
            'max_infos' => $max_infos - $infos_publisheds,
            'max_stats' => $max_stats - $stats_publisheds,
            'max_images' => $max_images - $images_uploadeds,
        ];
    }


    public function __subcriptionApprobationManager(?User $admin_validator = null)
    {
        DB::beginTransaction();

        $today = now();

        $subscriber = $this->subscriber;

        try {

            $subscription_data = [
                'free_days' => 3,
                'validate_at' => $today,
                'will_closed_at' => Carbon::now()->addMonths($this->months),
                'payment_status' => "Payé",
                'is_active' => true,
            ];

            $payment_data = [
                'email' => $this->email,
                'contacts' => $this->contacts,
                'amount' => $this->amount,
                'observation' => $this->observation,
                'user_id' => $this->user_id,
                'school_id' => $this->school_id,
                'pack_id' => $this->pack_id,
                'subscription_id' => $this->id,
                'payment_status' => $this->payment_status,
                'validate' => true,
                'payed_at' => $today,
            ];

            $this->update($subscription_data);

            $payment = Payment::create($payment_data);

            DB::commit();

            DB::afterCommit(function() use ($payment, $subscriber, $admin_validator){

                $message = "Votre demande d'abonnement ref:{$this->ref_key} du pack {$this->pack->name} a été approuvé et activé avec succès. Votre abonnement est à présent actif!";

                Notification::sendNow([$this->user], new RealTimeNotification($message));

                $lien = $subscriber->to_subscribes_route();

                $greating = $subscriber->greatingMessage($subscriber->getUserNamePrefix(true, false)) . ", ";

                JobToSendSimpleMailMessageTo::dispatch($subscriber->email, $greating, $message, "SOUSCRIPTION " . $this->ref_key . " VALIDEE - ABONNEMENT ACTIVE ", null, $lien);

                $message_to_admins = "L'abonnement ref:{$this->ref_key} du pack {$this->pack->name} fait par {$this->user->getFullName()} a été validé avec succès!";

                if($admin_validator){

                    Notification::sendNow([auth_user()], new RealTimeNotification($message_to_admins));

                }
                else{

                    $admins = ModelsRobots::getAllAdmins();

                    if(!empty($admins)){

                        Notification::sendNow($admins, new RealTimeNotification($message_to_admins));
                    }
                }
                return $payment;

            });
            

        } catch (\Throwable $th) {

            DB::rollBack();

            if($admin_validator) : 

                Notification::sendNow([$admin_validator], new RealTimeNotification("La validation de l'abonnement ref:{$this->ref_key} du pack {$this->pack->name} fait par {$this->user->getFullName()} a échoué! : " . $th->getMessage()));

                return false;

            else :
                $admins = ModelsRobots::getAllAdmins();

                if(!empty($admins)){

                    Notification::sendNow($admins, new RealTimeNotification("La validation de l'abonnement ref:{$this->ref_key} du pack {$this->pack->name} fait par {$this->user->getFullName()} a échoué! : " . $th->getMessage()));
                }

                return false;

            endif;
        }
    }


    public function joinSchoolDataToACurrentSubscription()
    {
        
    }


    public function __notifySubscriberToFinalyseSubscriptionByPayingToValidateIt(?User $admin_validator = null)
    {
        if(!$this->validated_at){

            $user = $this->subscriber;

            $lien = $user->to_subscribes_route();

            $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

            $message = "Vous avez lancé une demande d'abonnement pour le pack " . $this->pack->name . " pour votre école " . $this->school->name . " depuis le " . __formatDateTime($this->created_at) . ". Afin de voir votre abonnement validé et actif, nous vous demandons de procéder au payement par dépôt électronique comme prévu! Un autre mail vous sera envoyé avec des détails du payement à effectuer!";

            JobToSendSimpleMailMessageTo::dispatch($user->email, $greating, $message, "DEMANDE DE VALIDATION DE LA SOUSCRIPTION " . $this->ref_key, null, $lien);

            $this->__sendSubcriptionDetailsToSubscriber();

            Notification::sendNow([$this->subscriber], new RealTimeNotification($message));

        }
    }


    public function __rememberDaysRemainingToSubscriber(?User $admin_validator = null)
    {
        if($this->will_closed_at && $this->will_closed_at > now() && $this->is_active){

            $user = $this->subscriber;

            $lien = $user->to_subscribes_route();

            $greating = $user->greatingMessage($user->getUserNamePrefix(true, false)) . ", ";

            $message = "Nous voulons vous repeler que votre abonnement actif " . $this->ref_key . " pour votre école " . $this->school->name . " actif depuis le " . __formatDateTime($this->payement->created_at) . " expire le " . __formatDateTime($this->will_closed_at) . ", soit  " . __formatDateDiff($this->will_closed_at) . " exactement.";

            JobToSendSimpleMailMessageTo::dispatch($user->email, $greating, $message, "RAPPEL NOMBRE DE JOURS RESTANTS DE L'ABONNEMENT " . $this->ref_key, null, $lien);

            Notification::sendNow([$this->subscriber], new RealTimeNotification($message));

        }
        else{


        }
    }

    public function __markAsExpired(?User $admin_validator = null)
    {
        JobToDelayedSubscription::dispatch($this, $admin_validator);
    }

    public function __sendSubcriptionDetailsToSubscriber()
    {
        JobToSendSubcriptionDetailsToTheSubcriber::dispatch($this)->delay(now()->addMinutes(2));
    }


    public function __notifyAdminsThatPaymentHasBeenDone()
    {
        if(!$this->validated_at){

            $admins = ModelsRobots::getAllAdmins();

            $subscriber = $this->subscriber;

            $subscriber_name = $subscriber->getUserNamePrefix(true, false);

            $lien = route('admin.packs.subscriptions.list');

            $message = $subscriber_name . " reclame la validation de sa demande d'abonnement pour le pack " . $this->pack->name . " de son école école " . $this->school->name . " dont la référence est " . $this->ref_key . ". En effet, il a déjà effectuer le payement pour cette demande!";

            if(!empty($admins)){

                foreach($admins as $admin) :

                    $greating = $admin->greatingMessage($admin->getUserNamePrefix(true, false)) . ", ";

                    JobToSendSimpleMailMessageTo::dispatch($admin->email, $greating, $message, "RECLAMATION DE LA VALIDATION DE LA SOUSCRIPTION " . $this->ref_key, null, $lien);

                endforeach;

                Notification::sendNow($admins, new RealTimeNotification($message));
            }

        }
    }


    public function hasPlannedDelayedTask($report = null) : bool
    {
        if(!$report){
            return JobTaskPlannedOnModel::where('model_id', $this->id)
                                    ->where('model_class', get_class($this))
                                    ->first() !== null;
        }
        else{
            return JobTaskPlannedOnModel::where('model_id', $this->id)
                                    ->where('model_class', get_class($this))
                                    ->where('report', $report)
                                    ->first() !== null;
        }

    }


    public function deletePlannedTask($report = null)
    {
        if($report) :
            return 
            JobTaskPlannedOnModel::where('model_id', $this->id)
                                    ->where('model_class', get_class($this))
                                    ->where('report', $report)
                                    ->delete();
        else :
            return 
            JobTaskPlannedOnModel::where('model_id', $this->id)
                                    ->where('model_class', get_class($this))
                                    ->delete();
        endif;
    }

    public function definePlannedTask($report, $job_id = null, $batch_id = null, $payload = null, $status = null)
    {
        if(!$report) $report = config('app.subcriptions_task_report');

        DB::beginTransaction();

        try {

            if($this->hasPlannedDelayedTask($report)){
            
                self::deletePlannedTask($report);
            }

            JobTaskPlannedOnModel::create([
                'job_id' => $job_id,
                'batch_id' => $batch_id,
                'model_id' => $this->id,
                'model_class' => get_class($this),
                'payload' => $payload,
                'status' => $status,
                'report' => $report
            ]);
            
            DB::commit();

        
        } catch (\Throwable $th) {

            DB::rollBack();
            
        }
    }

    
}
