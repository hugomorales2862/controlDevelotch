<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentReceipt;
use App\Models\CashBoxMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class FinancialService
{
    /**
     * Process a payment, generate a receipt and update the cash box.
     */
    public function processPayment(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create the payment
            $payment = Payment::create($data);

            // 2. Generate and store the receipt
            $receiptNumber = PaymentReceipt::generateNumber();
            $receipt = PaymentReceipt::create([
                'payment_id' => $payment->id,
                'user_id' => Auth::id(),
                'number' => $receiptNumber,
                'metadata' => [
                    'client_id' => $payment->invoice->client_id ?? null,
                    'invoice_number' => $payment->invoice->number ?? null,
                    'method' => $payment->payment_method,
                ]
            ]);

            // 3. Update payment with receipt number for easy lookup
            $payment->update(['receipt_number' => $receiptNumber]);

            // 4. Register movement in Cash Box
            $previousBalance = CashBoxMovement::currentBalance();
            CashBoxMovement::create([
                'user_id' => Auth::id(),
                'payment_id' => $payment->id,
                'concept' => "Cobro de Factura: " . ($payment->invoice->number ?? $payment->id),
                'amount' => $payment->amount,
                'type' => 'income',
                'previous_balance' => $previousBalance,
                'new_balance' => $previousBalance + $payment->amount,
            ]);

            return [
                'payment' => $payment,
                'receipt' => $receipt
            ];
        });
    }

    /**
     * Register a generic expense in the cash box.
     */
    public function processExpense(string $concept, float $amount, array $metadata = [])
    {
        return DB::transaction(function () use ($concept, $amount, $metadata) {
            $previousBalance = CashBoxMovement::currentBalance();
            
            if ($previousBalance < $amount) {
                throw new Exception("Saldo insuficiente en caja chica para este egreso.");
            }

            return CashBoxMovement::create([
                'user_id' => Auth::id(),
                'concept' => $concept,
                'amount' => $amount,
                'type' => 'expense',
                'previous_balance' => $previousBalance,
                'new_balance' => $previousBalance - $amount,
            ]);
        });
    }
}
