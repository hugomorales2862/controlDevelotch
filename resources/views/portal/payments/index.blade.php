<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Estado de Pagos') }}
            </h2>
            <a href="{{ route('portal.dashboard') }}" class="text-slate-500 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 mb-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-bl-full blur-3xl"></div>
            
            <table class="min-w-full divide-y divide-[#1e293b] relative z-10">
                <thead class="bg-[#1e293b]/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Recibo / Ref.</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Factura</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha de Pago</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Método</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Monto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-emerald-400 text-sm">{{ $payment->receipt_number ?? $payment->reference ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-300 text-sm">
                                {{ $payment->invoice->invoice_number ?? 'Pendiente' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-300 text-sm">
                                {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y') : '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 uppercase text-[10px] font-black tracking-widest rounded border bg-slate-800/50 text-slate-400 border-slate-700">
                                    {{ $payment->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-black text-white">Q{{ number_format($payment->amount, 2) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic text-sm">
                                No hay pagos registrados a tu nombre.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 border-t border-[#1e293b] pt-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
