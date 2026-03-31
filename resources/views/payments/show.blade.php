<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Detalles del Pago') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('payments.index') }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                <a href="{{ route('payments.edit', $payment) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar</a>
                <a href="{{ route('payments.receipt', $payment) }}" class="text-sm font-medium text-[#0B1120] bg-emerald-400 hover:bg-emerald-300 border border-transparent px-4 py-2 rounded-lg shadow-[0_0_15px_rgba(52,211,153,0.3)] transition-all">Ver Recibo</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Payment Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Pago #{{ $payment->id }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        Procesado
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Factura</p>
                        <p class="text-sm font-medium text-white">{{ $payment->invoice->number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Cliente</p>
                        <p class="text-sm font-medium text-white">{{ $payment->invoice->client->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Monto</p>
                        <p class="text-sm font-medium text-white">${{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Método de Pago</p>
                        <p class="text-sm font-medium text-white">{{ $payment->payment_method }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Cuenta Bancaria</p>
                        <p class="text-sm font-medium text-white">{{ $payment->bankAccount->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Fecha de Pago</p>
                        <p class="text-sm font-medium text-white">{{ $payment->paid_at->format('d/m/Y') }}</p>
                    </div>
                    @if($payment->reference)
                        <div class="md:col-span-2">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Referencia</p>
                            <p class="text-sm font-medium text-white">{{ $payment->reference }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Receipt Info -->
        @if($payment->receipt)
            <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-bold text-white mb-4">Comprobante de Pago</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Número de Comprobante</p>
                            <p class="text-sm font-medium text-white">{{ $payment->receipt->number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Fecha de Emisión</p>
                            <p class="text-sm font-medium text-white">{{ $payment->receipt->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>