<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Cotizaciones Emitidas') }}
            </h2>
            <a href="{{ route('quotes.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Crear Cotización
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Referencia / Título</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Validez</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($quotes as $quote)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-black text-[#00f6ff] mb-1 italic">{{ $quote->reference }}</div>
                                    <div class="text-sm font-bold text-white group-hover:text-amber-400 transition-colors">{{ $quote->title ?: 'Sin título' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">
                                        {{ $quote->quoteable_type === 'App\Models\Client' ? ($quote->quoteable->name ?? '?') : ($quote->quoteable->company_name ?: $quote->quoteable->contact_name ?? '?') }}
                                    </div>
                                    <div class="text-xs text-slate-500 italic">
                                        {{ $quote->quoteable_type === 'App\Models\Client' ? 'Cliente' : 'Prospecto' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-white">Q{{ number_format($quote->total, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'draft' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'sent' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'approved' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'rejected' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'expired' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        ];
                                        $statusColor = $statusStyles[$quote->status] ?? $statusStyles['draft'];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider rounded border {{ $statusColor }}">
                                        {{ $quote->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs {{ $quote->valid_until && $quote->valid_until->isPast() ? 'text-rose-500' : 'text-slate-400' }}">
                                        {{ $quote->valid_until ? $quote->valid_until->format('d/m/Y') : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3 items-center">
                                        @if($quote->status == 'draft')
                                            <form action="{{ route('quotes.send', $quote) }}" method="POST" class="confirm-form" 
                                                  data-title="Enviar Cotización" 
                                                  data-text="Se enviará la propuesta comercial por correo al destinatario." 
                                                  data-confirm-text="Sí, enviar ahora" 
                                                  data-icon="info">
                                                @csrf
                                                <button type="submit" class="text-indigo-400 hover:text-white transition-colors" title="Enviar por Correo">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('quotes.show', $quote) }}" class="text-slate-400 hover:text-white transition-colors" title="Ver Detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('quotes.edit', $quote) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 italic">
                                    No hay cotizaciones registradas actualmente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $quotes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
