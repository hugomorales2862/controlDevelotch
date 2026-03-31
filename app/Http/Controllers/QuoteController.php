<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Service;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view quotes')->only(['index', 'show']);
        $this->middleware('permission:create quotes')->only(['create', 'store']);
        $this->middleware('permission:edit quotes')->only(['edit', 'update']);
        $this->middleware('permission:delete quotes')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::with(['client', 'user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('company')->get();
        $services = Service::orderBy('name')->get();
        return view('quotes.create', compact('clients', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
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
                'client_id' => $validated['client_id'],
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
            ->with('success', 'Quote created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        $quote->load(['client', 'user', 'items.service']);
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        $clients = Client::orderBy('company')->get();
        $services = Service::orderBy('name')->get();
        $quote->load('items.service');
        return view('quotes.edit', compact('quote', 'clients', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'valid_until' => 'required|date',
            'status' => 'required|in:draft,sent,approved,rejected,expired',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $quote) {
            $quote->update([
                'client_id' => $validated['client_id'],
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
            ->with('success', 'Quote updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('quotes.index')
            ->with('success', 'Quote deleted successfully.');
    }

    /**
     * Send quote to client.
     */
    public function send(Quote $quote)
    {
        $quote->update(['status' => 'sent']);

        // TODO: Send email notification to client

        return redirect()->back()
            ->with('success', 'Quote sent to client successfully.');
    }

    /**
     * Approve quote.
     */
    public function approve(Quote $quote)
    {
        $quote->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', 'Quote approved successfully.');
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
