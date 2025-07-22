<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public', function () {
    return true;
});


Broadcast::channel('master', function ($user) {

    return $user->isMaster();
});

Broadcast::channel('confirmeds', function ($user) {

    return $user->email_verified_at !== null;

});


Broadcast::channel('admin', function ($user) {

    return $user->isAdminsOrMaster();
});

