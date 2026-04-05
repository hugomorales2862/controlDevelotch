<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // En un proyecto real esto chequearia policy, por ahora lo dejamos en true 
        // asumiendo que las rutas están protegidas en web.php
        return true; 
    }

    public function rules(): array
    {
        return [
            'invoice_id'      => 'required|exists:invoices,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'payment_method'  => 'required|in:efectivo,transferencia,cheque,tarjeta,otro',
            'amount'          => 'required|numeric|min:0.01',
            'paid_at'         => 'required|date',
            'reference'       => 'nullable|string|max:100',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ];
    }
}
