<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\PaymentReceipt;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function index()
    {
        $payments = \App\Models\Payment::with(['invoice.client', 'user', 'receipt'])
            ->latest()
            ->paginate(20);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $invoices     = Invoice::with('client')->where('status', '!=', 'paid')->get();
        $bankAccounts = BankAccount::all();

        return view('payments.create', compact('invoices', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id'      => 'required|exists:invoices,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'payment_method'  => 'required|in:efectivo,transferencia,cheque,tarjeta,otro',
            'amount'          => 'required|numeric|min:0.01',
            'paid_at'         => 'required|date',
            'reference'       => 'nullable|string|max:100',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        try {
            $result = $this->paymentService->process($validated);

            return redirect()
                ->route('payments.receipt', $result['payment']->id)
                ->with('success', "✅ Pago registrado exitosamente. Comprobante: {$result['receipt']->number}");
        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withInput()
                ->with('error', '❌ Error al procesar el pago. Los cambios fueron revertidos. Intente nuevamente.');
        }
    }

    public function show(\App\Models\Payment $payment)
    {
        $payment->load(['invoice.client', 'user', 'receipt', 'bankAccount', 'cashBoxEntry']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Vista de comprobante — soporta modo térmico (80mm) y carta.
     */
    public function receipt(\App\Models\Payment $payment, Request $request)
    {
        $payment->load(['invoice.client', 'user', 'receipt.cashBox', 'bankAccount']);
        $receipt = $payment->receipt;

        if (!$receipt) {
            abort(404, 'Comprobante no encontrado.');
        }

        // Marcar como impreso la primera vez
        if (!$receipt->printed_at) {
            $receipt->marcarImpreso();
        }

        $modo = $request->get('modo', 'carta'); // 'termico' | 'carta'

        return view('payments.receipt', compact('payment', 'receipt', 'modo'));
    }

    /**
     * Descarga el comprobante como PDF carta.
     */
    public function receiptPdf(\App\Models\Payment $payment)
    {
        $payment->load(['invoice.client', 'user', 'receipt.cashBox', 'bankAccount']);
        $receipt = $payment->receipt;

        if (!$receipt) {
            abort(404, 'Comprobante no encontrado.');
        }

        $pdf = Pdf::loadView('payments.receipt', [
            'payment' => $payment,
            'receipt' => $receipt,
            'modo'    => 'pdf',
        ])->setPaper('letter', 'portrait');

        $filename = "comprobante-{$receipt->number}.pdf";

        return $pdf->download($filename);
    }

    public function edit(\App\Models\Payment $payment)
    {
        // Only allow editing if not processed or something, but for now, allow
        $invoices = Invoice::with('client')->get();
        $bankAccounts = BankAccount::all();
        return view('payments.edit', compact('payment', 'invoices', 'bankAccounts'));
    }

    public function update(Request $request, \App\Models\Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'payment_method' => 'required|in:efectivo,transferencia,cheque,tarjeta,otro',
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'required|date',
            'reference' => 'nullable|string|max:100',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(\App\Models\Payment $payment)
    {
        // Perhaps check if can be deleted
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Pago eliminado exitosamente.');
    }

    /**
     * Registrar egreso manual desde caja chica.
     */
    public function egreso(Request $request)
    {
        $validated = $request->validate([
            'concepto' => 'required|string|max:255',
            'monto'    => 'required|numeric|min:0.01',
            'notas'    => 'nullable|string',
        ]);

        try {
            $this->paymentService->registrarEgreso($validated);
            return back()->with('success', '✅ Egreso registrado en caja.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', '❌ Error al registrar el egreso.');
        }
    }
}
