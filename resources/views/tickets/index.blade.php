<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Centro de Soporte y Tickets') }}
            </h2>
            <a href="{{ route('tickets.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Abrir Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Ticket # / Asunto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Prioridad</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Última Act.</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-[10px] font-black text-indigo-500 mb-1">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-sm font-bold text-white group-hover:text-[#00f6ff] transition-colors">{{ $ticket->subject }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $ticket->client->name ?? '?' }}</div>
                                    <div class="text-xs text-slate-500 italic">{{ $ticket->client->company ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $priorityStyles = [
                                            'low' => 'text-slate-400 bg-slate-400/10 border-slate-400/20',
                                            'medium' => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                                            'high' => 'text-rose-500 bg-rose-500/10 border-rose-500/20',
                                            'critical' => 'text-red-600 bg-red-600/20 border-red-600/40 animate-pulse',
                                        ];
                                        $pStyle = $priorityStyles[$ticket->priority] ?? $priorityStyles['low'];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-black tracking-widest rounded border {{ $pStyle }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'new' => 'bg-indigo-500/10 text-indigo-400',
                                            'open' => 'bg-[#00f6ff]/10 text-[#00f6ff]',
                                            'pending' => 'bg-amber-500/10 text-amber-400',
                                            'resolved' => 'bg-emerald-500/10 text-emerald-400',
                                            'closed' => 'bg-slate-500/10 text-slate-500',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider rounded border border-current {{ $statusStyles[$ticket->status] ?? '' }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs text-slate-500 italic">{{ $ticket->updated_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-slate-400 hover:text-white transition-colors" title="Gestionar Ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 italic">
                                    No hay tickets pendientes en la bandeja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
