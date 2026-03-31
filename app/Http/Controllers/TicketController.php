<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view tickets')->only(['index', 'show']);
        $this->middleware('permission:create tickets')->only(['create', 'store']);
        $this->middleware('permission:edit tickets')->only(['edit', 'update']);
        $this->middleware('permission:delete tickets')->only(['destroy']);
    }

    public function index()
    {
        $tickets = Ticket::with(['client', 'owner'])->latest()->paginate(15);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $clients = Client::orderBy('company')->get();
        return view('tickets.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        $ticket = Ticket::create([
            'client_id' => $validated['client_id'],
            'user_id' => Auth::id(), // Assigned to the creator initially
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status' => 'new',
            'priority' => $validated['priority'],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket de soporte creado con éxito.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['client', 'owner', 'messages.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $clients = Client::orderBy('company')->get();
        return view('tickets.edit', compact('ticket', 'clients'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,open,pending,resolved,closed',
            'priority' => 'required|in:low,medium,high,critical',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket actualizado con éxito.');
    }

    public function addMessage(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        // If ticket was new, mark as open
        if ($ticket->status == 'new') {
            $ticket->update(['status' => 'open']);
        }

        return redirect()->back()->with('success', 'Mensaje enviado.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado.');
    }
}
