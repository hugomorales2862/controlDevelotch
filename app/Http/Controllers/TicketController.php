<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\User;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\TicketStatusUpdated;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver tickets')->only(['index', 'show']);
        $this->middleware('permission:crear tickets')->only(['create', 'store']);
        $this->middleware('permission:editar tickets')->only(['edit', 'update']);
        $this->middleware('permission:eliminar tickets')->only(['destroy']);
    }

    public function index(Request $request)
    {
        // Obtain all clients who have tickets, and load their tickets and messages
        $clients = Client::whereHas('tickets')
            ->with(['tickets' => function($query) {
                // Load tickets ordered by most recent
                $query->orderBy('updated_at', 'desc')->with(['messages' => function($q) {
                    $q->orderBy('created_at', 'asc');
                }]);
            }])->get()->sortByDesc(function($client) {
                // Sort clients in the left panel by their most recently updated ticket
                return $client->tickets->first()->updated_at ?? null;
            });
        
        $activeClient = null;
        if ($request->has('client_id')) {
            $activeClient = $clients->firstWhere('cli_id', $request->client_id);
            if ($activeClient) {
                // If admin accesses it, mark their most recent 'new' ticket as open
                $latestNewTicket = $activeClient->tickets->where('status', 'new')->first();
                if ($latestNewTicket) {
                    $latestNewTicket->update(['status' => 'open', 'user_id' => Auth::id()]);
                    broadcast(new TicketStatusUpdated($latestNewTicket))->toOthers();
                }
            }
        }

        return view('tickets.index', compact('clients', 'activeClient'));
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

        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['client', 'owner', 'messages.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $clients = Client::orderBy('company')->get();
        $users = User::all();
        return view('tickets.edit', compact('ticket', 'clients', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:new,open,pending,resolved,closed',
            'priority' => 'required|in:low,medium,high,critical',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);
        broadcast(new TicketStatusUpdated($ticket))->toOthers();

        return redirect()->route('tickets.index', ['ticket_id' => $ticket->id]);
    }

    public function addMessage(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Ticket cerrado'], 403);
            }
            abort(403, 'Ticket cerrado');
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), // Enviar como el admin
            'message' => $validated['message'],
        ]);

        $statusChanged = false;
        if ($ticket->status === 'new') {
            $ticket->update(['status' => 'open', 'user_id' => Auth::id()]);
            $statusChanged = true;
        }

        $html = view('portal.tickets._message', compact('message'))->render();
        broadcast(new MessageSent($message, $html))->toOthers();
        
        if ($statusChanged) {
            broadcast(new TicketStatusUpdated($ticket))->toOthers();
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'html' => $html
            ]);
        }

        return redirect()->back();
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
