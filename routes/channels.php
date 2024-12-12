<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiver}', function ($user, $receiver) {
    return Auth::check();
});