<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Embudo de Prospectos') }}
            </h2>
            <a href="{{ route('prospects.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Nuevo Prospecto
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Prospecto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Contacto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado del Prospecto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Industria</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($prospects as $prospect)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white">{{ $prospect->company_name }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase tracking-tighter">{{ $prospect->website }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $prospect->contact_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $prospect->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'new' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'contacted' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'qualified' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'proposal' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
                                            'lost' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'won' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        ];
                                        $statusLabels = [
                                            'new' => 'Nuevo Prospecto',
                                            'contacted' => 'Contactado',
                                            'qualified' => 'Calificado',
                                            'proposal' => 'Propuesta',
                                            'lost' => 'Perdido',
                                            'won' => 'Convertido',
                                        ];
                                        $statusColor = $statusStyles[$prospect->status] ?? $statusStyles['new'];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider rounded border {{ $statusColor }}">
                                        {{ $statusLabels[$prospect->status] ?? $prospect->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs text-slate-400">{{ $prospect->industry ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        @if($prospect->status != 'won')
                                            <form action="{{ route('prospects.convert', $prospect) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" title="Convertir a Cliente" class="text-emerald-500 hover:text-emerald-400 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('prospects.show', $prospect) }}" class="text-slate-400 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('prospects.edit', $prospect) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    No hay prospectos en el embudo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $prospects->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
