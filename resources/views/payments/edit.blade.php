<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Editar Pago') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('payments.update', $payment) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Invoice -->
                        <div>
                            <label for="invoice_id" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Factura</label>
                            <select id="invoice_id" name="invoice_id" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="">Seleccionar Factura</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" {{ old('invoice_id', $payment->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                        {{ $invoice->number }} - {{ $invoice->client->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('invoice_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Bank Account -->
                        <div>
                            <label for="bank_account_id" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Cuenta Bancaria</label>
                            <select id="bank_account_id" name="bank_account_id" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="">Seleccionar Cuenta</option>
                                @foreach($bankAccounts as $account)
                                    <option value="{{ $account->id }}" {{ old('bank_account_id', $payment->bank_account_id) == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('bank_account_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Método de Pago</label>
                            <select id="payment_method" name="payment_method" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="">Seleccionar Método</option>
                                <option value="efectivo" {{ old('payment_method', $payment->payment_method) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="transferencia" {{ old('payment_method', $payment->payment_method) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="cheque" {{ old('payment_method', $payment->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="tarjeta" {{ old('payment_method', $payment->payment_method) == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="otro" {{ old('payment_method', $payment->payment_method) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Monto</label>
                            <input id="amount" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Paid At -->
                        <div>
                            <label for="paid_at" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Fecha de Pago</label>
                            <input id="paid_at" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="date" name="paid_at" value="{{ old('paid_at', $payment->paid_at->format('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('paid_at')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Reference -->
                        <div>
                            <label for="reference" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Referencia (Opcional)</label>
                            <input id="reference" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="reference" value="{{ old('reference', $payment->reference) }}" />
                            <x-input-error :messages="$errors->get('reference')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-[#1e293b]">
                        <a href="{{ route('payments.show', $payment) }}" class="mr-4 text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl font-bold text-sm text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                            Actualizar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>