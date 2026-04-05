<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Prospect;
use App\Models\Service;
use App\Models\QuoteItem;
use App\Notifications\QuoteSent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver cotizaciones')->only(['index', 'show']);
        $this->middleware('permission:crear cotizaciones')->only(['create', 'store']);
        $this->middleware('permission:editar cotizaciones')->only(['edit', 'update']);
        $this->middleware('permission:eliminar cotizaciones')->only(['destroy']);
        $this->middleware('permission:enviar cotizaciones')->only(['send']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Auto-expire quotes that have passed their valid_until date
        Quote::where('status', '!=', 'expired')
            ->where('valid_until', '<', now()->toDateString())
            ->whereIn('status', ['draft', 'sent'])
            ->update(['status' => 'expired']);

        $quotes = Quote::with(['quoteable', 'user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('company')->get();
        $prospects = Prospect::orderBy('company_name')->get();
        $services = Service::orderBy('name')->get();

        $initialQuoteable = null;
        if ($request->has(['quoteable_type', 'quoteable_id'])) {
            $initialQuoteable = $request->quoteable_type . '|' . $request->quoteable_id;
        }

        return view('quotes.create', compact('clients', 'prospects', 'services', 'initialQuoteable'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quoteable_type' => 'required|string|in:App\Models\Client,App\Models\Prospect',
            'quoteable_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'valid_until' => 'required|date|after:today',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'nullable|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.description' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $quote = Quote::create([
                'quoteable_type' => $validated['quoteable_type'],
                'quoteable_id' => $validated['quoteable_id'],
                'user_id' => Auth::id(),
                'reference' => 'QT-' . strtoupper(uniqid()),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'valid_until' => $validated['valid_until'],
                'notes' => $validated['notes'],
                'status' => 'draft',
            ]);

            foreach ($validated['items'] as $itemData) {
                QuoteItem::create([
                    'quote_id' => $quote->id,
                    'service_id' => $itemData['service_id'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'description' => $itemData['description'],
                    'line_total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }

            $quote->calculateTotal();
        });

        return redirect()->route('quotes.index')
            ->with('success', 'Cotización creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        $quote->load(['quoteable', 'user', 'items.service']);
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        $clients = Client::orderBy('company')->get();
        $prospects = Prospect::orderBy('company_name')->get();
        $services = Service::orderBy('name')->get();
        $quote->load('items.service');
        return view('quotes.edit', compact('quote', 'clients', 'prospects', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'quoteable_type' => 'required|string|in:App\Models\Client,App\Models\Prospect',
            'quoteable_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'valid_until' => 'required|date',
            'status' => 'required|in:draft,sent,approved,rejected,expired',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'nullable|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $quote) {
            $quote->update([
                'quoteable_type' => $validated['quoteable_type'],
                'quoteable_id' => $validated['quoteable_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'valid_until' => $validated['valid_until'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);

            // Delete existing items and recreate
            $quote->items()->delete();

            foreach ($validated['items'] as $itemData) {
                QuoteItem::create([
                    'quote_id' => $quote->id,
                    'service_id' => $itemData['service_id'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'description' => $itemData['description'],
                    'line_total' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }

            $quote->calculateTotal();
        });

        return redirect()->route('quotes.index')
            ->with('success', 'Cotización actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('quotes.index')
            ->with('success', 'Cotización eliminada correctamente.');
    }

    /**
     * Send quote to client.
     */
    public function send(Quote $quote)
    {
        // Marcar como enviada primero (independiente del correo)
        $quote->load('items.service', 'quoteable');
        $quote->update(['status' => 'sent']);

        $emailSent = false;

        try {
            if ($quote->quoteable && method_exists($quote->quoteable, 'notify') && $quote->quoteable->email) {
                // Generar PDF adjunto
                $pdf = Pdf::loadView('quotes.pdf', compact('quote'))
                    ->setPaper('letter', 'portrait');
                $pdfContent = $pdf->output();
                $filename = "Cotizacion-{$quote->reference}.pdf";

                $quote->quoteable->notify(new QuoteSent($quote, $pdfContent, $filename));
                $emailSent = true;
            }
        } catch (\Throwable $e) {
            report($e);
        }

        if ($emailSent) {
            return redirect()->back()
                ->with('success', 'Cotización enviada. El PDF fue adjuntado al correo del destinatario.');
        }

        return redirect()->back()
            ->with('success', 'Cotización marcada como enviada. (El correo no pudo ser entregado — verifique la config SMTP).');
    }

    /**
     * Download quote as PDF.
     */
    public function pdf(Quote $quote)
    {
        $quote->load('items.service', 'quoteable');

        $pdf = Pdf::loadView('quotes.pdf', compact('quote'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("Cotizacion-{$quote->reference}.pdf");
    }

    /**
     * Approve quote.
     */
    public function approve(Quote $quote)
    {
        $quote->update(['status' => 'approved']);

        // Si el destinatario es un Prospecto, convertirlo automáticamente a Cliente al ganar la cotización
        if ($quote->quoteable_type === \App\Models\Prospect::class) {
            $prospect = $quote->quoteable;
            if ($prospect && $prospect->status !== 'converted') {
                $client = $prospect->toClient();
                // Opcional: El método toClient ya actualiza las cotizaciones asociadas.
            }
        }

        return redirect()->back()
            ->with('success', 'Cotización aprobada correctamente. El prospecto ha sido promovido a Cliente.');
    }

    /**
     * Reject quote.
     */
    public function reject(Quote $quote)
    {
        $quote->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', 'Quote rejected successfully.');
    }
}
