<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{ticketId}', function ($user, $ticketId) {
    if ($user->hasRole('admin')) {
        return true;
    }
    
    if ($user->client) {
        $ticket = \App\Models\Ticket::find($ticketId);
        return $ticket && $ticket->client_id === $user->client->cli_id;
    }

    return false;
});
Broadcast::channel('admin.tickets', function ($user) {
    return $user->hasRole('admin') || $user->hasRole('staff');
});
