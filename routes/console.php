<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Ejecuta la revisión de suscripciones todos los días automáticamente.
Schedule::command('subscriptions:check-expired')->daily();

// Cerrar chats de soporte por inactividad tras 5 minutos
Schedule::call(function () {
    $inactiveTickets = \App\Models\Ticket::whereIn('status', ['new', 'open'])
        ->where('updated_at', '<=', \Carbon\Carbon::now()->subMinutes(5))
        ->get();

    $systemUser = \App\Models\User::role('admin')->first(); // Agente por defecto

    foreach ($inactiveTickets as $ticket) {
        $ticket->update(['status' => 'closed']);

        $message = \App\Models\TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => null, // Mensaje del sistema
            'message' => 'El chat ha sido finalizado automáticamente por inactividad (5 minutos sin respuestas).',
        ]);

        $html = view('portal.tickets._message', compact('message'))->render();
        broadcast(new \App\Events\MessageSent($message, $html));
        broadcast(new \App\Events\TicketStatusUpdated($ticket));
    }
})->everyMinute();
