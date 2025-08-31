<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Robots\ModelsRobots;
use App\Helpers\TraitsManagers\UserTrait;
use App\Models\SubscriptionUpgradeRequest;
use App\Models\UserRole;
use App\Observers\ObserveUser;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(ObserveUser::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'gender',
        'contacts',
        'address',
        'city',
        'department',
        'pseudo',
        'identifiant',
        'profil_photo',
        'marital_status',
        'auth_token',
        'password_reset_key',
        'FEDAPAY_ID',
        'blocked',
        'blocked_at',
        'blocked_because',
        'wrong_password_tried',
        'uuid',
        'assistant_of'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'blocked_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public static function booted()
    {
        static::creating(function ($user){

            $user->uuid = Str::uuid();

            if($user->department && $user->city){

                $user->address = $user->city . " - " . $user->department;

            }
            else{

                $user->city = null;

                $user->department = null;
                
                $user->address = null;
            }

            $user->identifiant = $user->makeUserIdentifySequence();

        });

        static::updating(function ($user){

            if($user->department && $user->city){

                $user->address = $user->city . " - " . $user->department;

            }
            else{

                $user->city = null;

                $user->department = null;

                $user->address = null;
            }

            if($user->pseudo){

                if(substr($user->pseudo, 0, 1) !== '@'){

                    $user->pseudo = '@' . $user->pseudo;

                }

            }
            else{

                $user->pseudo = ModelsRobots::generatePseudo($user->firstname);
            }

        });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
    public function upgrade_subscription_requests()
    {
        return $this->hasMany(SubscriptionUpgradeRequest::class);
    }

    public function infos()
    {
        return $this->hasMany(Info::class);
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function school() 
    {
        if(count($this->schools) > 0){

            return $this->schools()->first();

        }

        return null;

    }



    public function current_subscription()
    {
        return $this->hasOne(Subscription::class)->whereNotNull('validate_at')->where('is_active', true)->where('will_closed_at', '>', now())->latest('will_closed_at');
    }

    public function non_validated_upgrade_request()
    {
        return $this->hasOne(SubscriptionUpgradeRequest::class)->whereNull('validate_at')->latest('created_at');
    }

    public function non_validated_subscription()
    {
        return $this->hasOne(Subscription::class)->whereNull('validate_at')->latest('created_at');
    }

    public function current_payment()
    {
        return $this->payments()->where('is_active', true)->first();
    }

    public function my_assistants()
    {
        return $this->hasMany(AssistantRequest::class, 'director_id');
    }

    public function my_directors()
    {
        return $this->hasMany(AssistantRequest::class, 'assistant_id');
    }

    public function my_chief()
    {
        return $this->assistant_of ? User::find($this->assistant_of) : null;
    }

    public function to_profil_route()
    {
        return route('user.profil', ['id' => $this->identifiant, 'uuid' => $this->uuid]);
    }
    
    public function to_subscribes_route()
    {
        return route('my.subscribes', ['id' => $this->identifiant, 'uuid' => $this->uuid]);
    }
    
    public function to_my_notifications_route()
    {
        return route('my.notifications', ['id' => $this->identifiant, 'uuid' => $this->uuid]);
    } 

    public function to_profil_edit_route()
    {
        return route('user.profil.edition', ['uuid' => $this->uuid]);
    }

    public function to_create_school_route()
    {
        return route('create.school', ['user_uuid' => $this->uuid]);
    }
    
    
    public function to_my_assistants_list_route()
    {
        return route('my.assistants', ['id' => $this->identifiant, 'uuid' => $this->uuid]);
    }
    
    public function to_my_receiveds_assistants_requests_list_route()
    {
        return route('my.assistants.requests', ['id' => $this->identifiant, 'uuid' => $this->uuid]);
    }

    public function getNotifications()
    {
        return $this->notifications;
    }

    public function getUnreadNotifications()
    {
        return $this->unreadNotifications;
    }

    public function getReadNotifications()
    {
        return $this->readNotifications;
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function confirmeds()
    {
        return $this->emailVerified();
    }

    public function assist_this_school($school_id, $with_author = false)
    {
        if($with_author && count($this->schools)){

            return $this->schools()->where('schools.id', $school_id)->exists();
        }

        return AssistantRequest::where('assistant_id', $this->id)->whereNotNull('approved_at')->where('is_active', true)->where('school_id', $school_id)->exists();

    }
}
