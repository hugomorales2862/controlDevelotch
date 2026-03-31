<?php

namespace App\Services;

use App\Models\CashBox;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentReceipt;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentService
{
    /**
     * Procesa un pago de forma completamente atómica.
     *
     * Si cualquier paso falla (registro de caja, generación de comprobante,
     * actualización de factura), se hace rollback completo para evitar
     * descuadres contables.
     *
     * @param  array{
     *     invoice_id: int,
     *     bank_account_id: int,
     *     payment_method: string,
     *     amount: float,
     *     paid_at: string,
     *     reference: ?string,
     *     subscription_id: ?int,
     *     concept: ?string,
     * } $data
     *
     * @return array{payment: Payment, receipt: PaymentReceipt, cashbox: CashBox}
     * @throws Throwable
     */
    public function process(array $data): array
    {
        return DB::transaction(function () use ($data) {

            // ── 1. Crear el Pago ─────────────────────────────────────────────
            $payment = Payment::create([
                'invoice_id'      => $data['invoice_id'],
                'bank_account_id' => $data['bank_account_id'],
                'user_id'         => Auth::id(),
                'subscription_id' => $data['subscription_id'] ?? null,
                'payment_method'  => $data['payment_method'],
                'amount'          => $data['amount'],
                'paid_at'         => $data['paid_at'],
                'reference'       => $data['reference'] ?? null,
            ]);

            // ── 2. Actualizar estado de la Factura ───────────────────────────
            $invoice = Invoice::findOrFail($data['invoice_id']);
            $totalPaid = $invoice->payments()->sum('amount') + $data['amount'];

            $invoice->update([
                'status' => $totalPaid >= $invoice->total ? 'paid' : 'partial',
            ]);

            // ── 3. Registrar Movimiento en Caja Chica (Ingreso) ──────────────
            $concepto = $data['concept']
                ?? "Pago factura #{$invoice->number} — {$invoice->client->name}";

            $cashbox = CashBox::registrarMovimiento([
                'concepto'       => $concepto,
                'monto'          => $data['amount'],
                'tipo'           => 'ingreso',
                'cashable_type'  => Payment::class,
                'cashable_id'    => $payment->id,
                'user_id'        => Auth::id(),
                'notas'          => "Método: {$data['payment_method']} | Ref: " . ($data['reference'] ?? 'N/A'),
            ]);

            // ── 4. Generar Comprobante de Pago ───────────────────────────────
            $receipt = PaymentReceipt::create([
                'number'      => PaymentReceipt::generateNumber(),
                'payment_id'  => $payment->id,
                'user_id'     => Auth::id(),
                'client_id'   => $invoice->client_id,
                'cash_box_id' => $cashbox->id,
                'amount'      => $data['amount'],
                'currency'    => 'GTQ',
                'concept'     => $concepto,
                'status'      => 'emitido',
                'metadata'    => [
                    'invoice_number'    => $invoice->number,
                    'payment_method'    => $data['payment_method'],
                    'subscription_id'   => $data['subscription_id'] ?? null,
                    'bank_account_id'   => $data['bank_account_id'],
                    'saldo_caja_nuevo'  => $cashbox->saldo_nuevo,
                ],
            ]);

            return [
                'payment' => $payment,
                'receipt' => $receipt,
                'cashbox' => $cashbox,
            ];
        });
    }

    /**
     * Registra un egreso manual en caja (gastos, compras de suministros, etc.)
     *
     * @param array{concepto: string, monto: float, user_id: int, notas: ?string} $data
     */
    public function registrarEgreso(array $data): CashBox
    {
        return DB::transaction(function () use ($data) {
            return CashBox::registrarMovimiento([
                'concepto' => $data['concepto'],
                'monto'    => $data['monto'],
                'tipo'     => 'egreso',
                'user_id'  => Auth::id(),
                'notas'    => $data['notas'] ?? null,
            ]);
        });
    }
}
