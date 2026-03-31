<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Comprobantes de Pago') }}
            </h2>
            <a href="{{ route('invoices.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Crear Comprobante
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Comprobante #</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Vencimiento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Total (GTQ)</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-white group-hover:text-[#00f6ff] transition-colors">{{ $invoice->invoice_number }}</div>
                                    <div class="text-[10px] text-slate-500 font-bold uppercase">{{ $invoice->issue_date->format('d M, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $invoice->client->name ?? '?' }}</div>
                                    <div class="text-xs text-slate-500 italic">{{ $invoice->client->company ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-bold {{ $invoice->isOverdue() ? 'text-rose-500 animate-pulse' : 'text-slate-400' }}">
                                        {{ $invoice->due_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-[9px] text-slate-500 uppercase tracking-tighter">
                                        {{ $invoice->due_date->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-white">Q{{ number_format($invoice->total, 2) }}</div>
                                    <div class="text-[9px] text-slate-500 uppercase">Total Final</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'draft' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'sent' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'paid' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'overdue' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'cancelled' => 'bg-red-900/20 text-red-400 border-red-900/40',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-black tracking-widest rounded border {{ $statusStyles[$invoice->status] ?? '' }}">
                                        {{ $invoice->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-slate-400 hover:text-white transition-colors" title="Ver comprobante">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors" title="Editar comprobante">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('invoices.destroy', $invoice) }}" onsubmit="return confirm('¿Seguro que desea eliminar este comprobante?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors" title="Eliminar comprobante">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22"/></svg>
                                            </button>
                                        </form>
                                        <a href="{{ route('invoices.pdf', $invoice) }}" class="text-slate-400 hover:text-emerald-400 transition-colors" title="Descargar PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 italic uppercase tracking-widest text-[10px]">
                                    No se han emitido comprobantes recientemente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
