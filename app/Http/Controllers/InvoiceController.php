<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view invoices')->only(['index', 'show']);
        $this->middleware('permission:create invoices')->only(['create', 'store']);
        $this->middleware('permission:edit invoices')->only(['edit', 'update']);
        $this->middleware('permission:delete invoices')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['client', 'user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('company')->get();
        return view('invoices.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'total' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subTotal = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $taxRate = $validated['tax_rate'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $tax = round($subTotal * ($taxRate / 100), 2);
        $total = round($subTotal + $tax - $discount, 2);

        DB::transaction(function () use ($validated, $subTotal, $taxRate, $discount, $tax, $total) {
            Invoice::create([
                'client_id' => $validated['client_id'],
                'user_id' => Auth::id(),
                'invoice_number' => $validated['invoice_number'],
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'],
                'sub_total' => $subTotal,
                'tax' => $tax,
                'total' => $total,
                'tax_rate' => $taxRate,
                'discount' => $discount,
                'status' => 'draft',
                'notes' => $validated['notes'],
                'items' => $validated['items'],
            ]);
        });

        return redirect()->route('invoices.index')
            ->with('success', 'Comprobante de pago creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'user', 'payments']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('company')->get();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number,' . $invoice->id,
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'total' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subTotal = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $taxRate = $validated['tax_rate'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $tax = round($subTotal * ($taxRate / 100), 2);
        $total = round($subTotal + $tax - $discount, 2);

        $invoice->update([
            'client_id' => $validated['client_id'],
            'invoice_number' => $validated['invoice_number'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'sub_total' => $subTotal,
            'tax' => $tax,
            'total' => $total,
            'tax_rate' => $taxRate,
            'discount' => $discount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'items' => $validated['items'],
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Comprobante de pago actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Comprobante de pago eliminado correctamente.');
    }

    /**
     * Send invoice to client.
     */
    public function send(Invoice $invoice)
    {
        $invoice->update(['status' => 'sent']);

        // TODO: Send email notification to client

        return redirect()->back()
            ->with('success', 'Invoice sent to client successfully.');
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);

        return redirect()->back()
            ->with('success', 'Invoice marked as paid successfully.');
    }

    /**
     * Generate PDF for invoice.
     */
    public function generatePdf(Invoice $invoice)
    {
        $invoice->load(['client', 'user']);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
        ])->setPaper('letter', 'portrait');

        $filename = "invoice-{$invoice->invoice_number}.pdf";
        return $pdf->download($filename);
    }
}

