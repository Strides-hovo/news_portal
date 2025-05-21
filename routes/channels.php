<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('registered', function ($user) {
    return auth()->check();
});


Broadcast::channel('news', function ($user) {
    return auth()->check();
});
