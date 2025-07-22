<?php

namespace App\Observers;

use App\Events\UserDataHasBeenUpdatedEvent;
use App\Models\User;
use Illuminate\Support\Str;

class ObserveUser
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if($user->id == 1 || $user->email == 'houndekz@gmail.com'){

            $user->forceFill([
                'email_verify_key' => null,
                'email_verified_at' => now(),
            ])->setRememberToken(Str::random(60));
    
            $user->save();

            $user->assignRole('master');
        }

        UserDataHasBeenUpdatedEvent::dispatch($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        UserDataHasBeenUpdatedEvent::dispatch($user);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleting(User $user): void
    {
        UserDataHasBeenUpdatedEvent::dispatch($user);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
