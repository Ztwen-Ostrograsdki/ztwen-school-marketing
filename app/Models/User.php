<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Robots\ModelsRobots;
use App\Helpers\TraitsManagers\UserTrait;
use App\Observers\ObserveUser;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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

    public function current_subscription()
    {
        return $this->subscriptions()->where('is_active', true)->first();
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
}
