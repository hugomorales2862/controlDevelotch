<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Gestión de Dominios') }}
            </h2>
            <a href="{{ route('domains.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Registrar Dominio
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Nombre de Dominio</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Vencimiento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($domains as $domain)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-black text-white group-hover:text-[#00f6ff] transition-colors lowercase">{{ $domain->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $domain->client->name ?? '?' }}</div>
                                    <div class="text-xs text-slate-500 italic">{{ $domain->client->company ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $isExpiring = $domain->expires_at && $domain->expires_at->diffInDays(now()) < 30;
                                        $isExpired = $domain->expires_at && $domain->expires_at->isPast();
                                    @endphp
                                    <div class="text-xs font-bold {{ $isExpired ? 'text-rose-500' : ($isExpiring ? 'text-amber-500' : 'text-emerald-400') }}">
                                        {{ $domain->expires_at ? $domain->expires_at->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <div class="text-[9px] text-slate-500 uppercase tracking-tighter">
                                        {{ $domain->expires_at ? $domain->expires_at->diffForHumans() : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'expired' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'pending_transfer' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'suspended' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                        ];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-black tracking-widest rounded border {{ $statusStyles[$domain->status] ?? '' }}">
                                        {{ $domain->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('domains.edit', $domain) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic uppercase tracking-widest text-[10px]">
                                    No hay dominios en la base de datos central.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $domains->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
