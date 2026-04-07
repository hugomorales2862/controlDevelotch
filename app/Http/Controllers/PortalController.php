<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Dashboard principal del cliente
     */
    public function dashboard()
    {
        $user = Auth::user();
        $client = $user->client;

        if (!$client) {
            return redirect()->route('dashboard')->with('error', 'No tienes un perfil de cliente asociado.');
        }

        $activeTicketsCount = Ticket::where('client_id', $client->cli_id)
            ->whereNotIn('status', ['resolved', 'closed'])
            ->count();

        return view('portal.dashboard', compact('client', 'activeTicketsCount'));
    }

    /**
     * Listado de tickets del cliente
     */
    public function tickets()
    {
        $client = Auth::user()->client;
        $tickets = Ticket::where('client_id', $client->cli_id)->latest()->paginate(10);
        
        return view('portal.tickets.index', compact('tickets'));
    }

    /**
     * Crear un nuevo ticket/chat desde el portal
     */
    public function createTicket(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $client = Auth::user()->client;

        // Crear el ticket automáticamente
        $ticket = Ticket::create([
            'client_id' => $client->cli_id,
            'user_id' => Auth::id(),
            'subject' => mb_substr($validated['message'], 0, 80),
            'description' => $validated['message'],
            'status' => 'new',
            'priority' => 'medium',
        ]);

        // Crear el primer mensaje del chat
        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        return redirect()->route('portal.tickets.show', $ticket)
            ->with('success', 'Tu conversación de soporte ha sido iniciada.');
    }

    /**
     * Chat/Detalle de un ticket para el cliente
     */
    public function showTicket(Ticket $ticket)
    {
        $client = Auth::user()->client;

        // Seguridad: solo puede ver sus propios tickets
        if ($ticket->client_id !== $client->cli_id) {
            abort(403, 'No tienes permiso para ver este ticket.');
        }

        $ticket->load(['messages.user', 'owner']);
        return view('portal.tickets.show', compact('ticket'));
    }

    /**
     * Añadir mensaje (Chat AJAX)
     */
    public function addMessage(Request $request, Ticket $ticket)
    {
        $client = Auth::user()->client;

        if ($ticket->client_id !== $client->cli_id) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        // Si el ticket estaba cerrado, quizás reabrirlo o dejarlo como está depende de política
        // Aquí lo dejamos en "open" si el cliente responde
        if (in_array($ticket->status, ['resolved', 'closed'])) {
            $ticket->update(['status' => 'open']);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mensaje enviado',
                'html' => view('portal.tickets._message', ['message' => $message])->render()
            ]);
        }

        return back()->with('success', 'Respuesta enviada.');
    }

    /**
     * Vista de Facturas (Placeholder)
     */
    public function invoices()
    {
        return view('portal.placeholder', ['title' => 'Mis Facturas']);
    }

    /**
     * Vista de Pagos (Placeholder)
     */
    public function payments()
    {
        return view('portal.placeholder', ['title' => 'Mis Pagos']);
    }
}
