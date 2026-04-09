<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Mis Facturas') }}
            </h2>
            <a href="{{ route('portal.dashboard') }}" class="text-slate-500 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 mb-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-bl-full blur-3xl"></div>
            
            <table class="min-w-full divide-y divide-[#1e293b] relative z-10">
                <thead class="bg-[#1e293b]/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">No. Documento</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha Emisión</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-white text-sm">{{ $invoice->invoice_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-300 text-sm">
                                {{ $invoice->issue_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-300 text-sm">
                                {{ $invoice->due_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-black text-[#00f6ff]">Q{{ number_format($invoice->total, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $labels = [
                                        'draft' => 'Borrador',
                                        'sent' => 'Enviada',
                                        'paid' => 'Pagada',
                                        'partial' => 'Parcial',
                                        'overdue' => 'Vencida',
                                        'cancelled' => 'Anulada'
                                    ];
                                    $colors = [
                                        'draft' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                        'sent' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'paid' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        'partial' => 'bg-[#00f6ff]/10 text-[#00f6ff] border-[#00f6ff]/20',
                                        'overdue' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        'cancelled' => 'bg-red-500/20 text-red-500 border-red-500/40 line-through',
                                    ];
                                    $lbl = $labels[$invoice->status] ?? $invoice->status;
                                    $col = $colors[$invoice->status] ?? 'bg-slate-500/10 text-slate-400';
                                @endphp
                                <span class="px-2 py-1 uppercase text-[10px] font-black tracking-widest rounded border {{ $col }}">
                                    {{ $lbl }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic text-sm">
                                No tienes facturas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4 border-t border-[#1e293b] pt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
