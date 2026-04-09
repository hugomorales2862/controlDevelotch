<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Mail\GenericNotification;
use App\Events\MessageSent;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PortalController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }
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

    public function tickets()
    {
        $client = Auth::user()->client;
        
        // Obtener los últimos 5 tickets para el historial unificado
        $recentTickets = Ticket::where('client_id', $client->cli_id)
            ->latest()
            ->take(5)
            ->with(['messages.user', 'owner'])
            ->get();

        // Unificar y ordenar todos los mensajes
        $unifiedMessages = collect();
        foreach ($recentTickets->reverse() as $ticket) {
            foreach ($ticket->messages as $msg) {
                $msg->context_ticket_id = $ticket->id;
                $msg->context_subject = $ticket->subject;
                $unifiedMessages->push($msg);
            }
        }
        $unifiedMessages = $unifiedMessages->sortBy('created_at');

        // Identificar el ticket activo para el formulario de respuesta
        $activeTicket = $recentTickets->whereNotIn('status', ['resolved', 'closed'])->first();

        return view('portal.tickets.index', compact('unifiedMessages', 'activeTicket', 'recentTickets'));
    }

    public function createTicket(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $client = Auth::user()->client;

        $ticket = Ticket::create([
            'client_id' => $client->cli_id,
            'user_id' => Auth::id(),
            'subject' => mb_substr($validated['message'], 0, 80),
            'description' => $validated['message'],
            'status' => 'new',
            'priority' => 'medium',
        ]);

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        $this->notifyAdmins($ticket, "Nuevo chat iniciado por {$client->name}: {$ticket->subject}");
        
        $html = view('portal.tickets._message', compact('message'))->render();
        broadcast(new MessageSent($message, $html))->toOthers();

        // Enviar invitación de DeveloAI
        $aiMessage = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => null, // Sistema
            'message' => '¡Hola! Soy **DeveloAI**, tu asistente inteligente. He recibido tu solicitud. ¿Cómo prefieres continuar?

[DEVELO_AI_CHOICE]',
        ]);

        $aiHtml = view('portal.tickets._message', ['message' => $aiMessage])->render();
        broadcast(new MessageSent($aiMessage, $aiHtml));
        broadcast(new \App\Events\TicketStatusUpdated($ticket));

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('portal.tickets')
            ]);
        }

        return redirect()->route('portal.tickets');
    }

    public function showTicket(Ticket $ticket)
    {
        $client = Auth::user()->client;

        if ($ticket->client_id !== $client->cli_id) {
            abort(403, 'No tienes permiso para ver este ticket.');
        }

        $ticket->load(['messages.user', 'owner']);
        return view('portal.tickets.show', compact('ticket'));
    }

    public function addMessage(Request $request, Ticket $ticket)
    {
        $client = Auth::user()->client;

        if ($ticket->client_id !== $client->cli_id) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            abort(403, 'Esta conversación ha sido finalizada.');
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        $html = view('portal.tickets._message', compact('message'))->render();
        broadcast(new MessageSent($message, $html))->toOthers();

        // Si el ticket está en modo AI, responder automáticamente
        if ($ticket->handler_mode === 'ai') {
            $aiResponse = $this->gemini->getResponse($client, $validated['message'], "Ticket #{$ticket->id}: {$ticket->subject}");
            
            $aiMessage = TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => null, // Representa a DeveloAI
                'message' => $aiResponse,
            ]);

            $aiHtml = view('portal.tickets._message', ['message' => $aiMessage])->render();
            broadcast(new MessageSent($aiMessage, $aiHtml));
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mensaje enviado',
                'html' => $html
            ]);
        }

        return back();
    }

    public function selectHandler(Request $request, Ticket $ticket)
    {
        $client = Auth::user()->client;
        if ($ticket->client_id !== $client->cli_id) { abort(403); }
        
        $mode = $request->input('mode');
        if (!in_array($mode, ['human', 'ai'])) { abort(400); }

        $ticket->update(['handler_mode' => $mode]);

        $systemText = $mode === 'ai' 
            ? '🤖 **DeveloAI Activado.** Estaré encantado de ayudarte con tus dudas sobre facturación o servicios. ¿En qué puedo ayudarte?'
            : '👨‍💻 **Asignado a un asesor.** En breve un agente humano revisará tu mensaje. Puedes seguir escribiendo aquí.';

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => null,
            'message' => $systemText,
        ]);

        $html = view('portal.tickets._message', compact('message'))->render();
        broadcast(new MessageSent($message, $html));
        broadcast(new \App\Events\TicketStatusUpdated($ticket));

        return response()->json(['status' => 'success']);
    }

    private function notifyAdmins(Ticket $ticket, $content)
    {
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new GenericNotification("Actualización de Chat #{$ticket->id}", $content));
        }
    }

    public function invoices()
    {
        $client = Auth::user()->client;
        $invoices = Invoice::where('client_id', $client->cli_id)->latest()->paginate(10);
        return view('portal.invoices.index', compact('invoices'));
    }

    public function payments()
    {
        $client = Auth::user()->client;
        
        $invoiceIds = Invoice::where('client_id', $client->cli_id)->pluck('id');
        
        $payments = Payment::whereIn('invoice_id', $invoiceIds)
                           ->latest()
                           ->paginate(10);
                           
        return view('portal.payments.index', compact('payments'));
    }
}
