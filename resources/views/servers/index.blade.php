<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Infraestructura VPS') }}
            </h2>
            <a href="{{ route('servers.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Nuevo Servidor
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Hostname / IP</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Especificaciones</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($servers as $server)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white group-hover:text-[#00f6ff] transition-colors">{{ $server->hostname }}</div>
                                    <div class="text-xs text-slate-500 font-mono italic">{{ $server->ip_address }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $server->client->name ?? '?' }}</div>
                                    <div class="text-xs text-slate-500">{{ $server->client->company ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <span class="px-2 py-0.5 bg-slate-800 text-slate-400 text-[10px] rounded border border-white/5">{{ $server->cpu_cores }} vCPU</span>
                                        <span class="px-2 py-0.5 bg-slate-800 text-slate-400 text-[10px] rounded border border-white/5">{{ $server->ram_gb }}GB RAM</span>
                                        <span class="px-2 py-0.5 bg-slate-800 text-slate-400 text-[10px] rounded border border-white/5">{{ $server->storage_gb }}GB SSD</span>
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-1 uppercase">{{ $server->os }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'inactive' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'suspended' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'terminated' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        ];
                                        $statusColor = $statusStyles[$server->status] ?? $statusStyles['inactive'];
                                    @endphp
                                    <span class="px-2 py-1 text-[9px] uppercase font-black tracking-wider rounded border {{ $statusColor }}">
                                        {{ $server->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        @can('ver servidores')
                                        <a href="{{ route('servers.show', $server) }}" class="text-slate-400 hover:text-white transition-colors" title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        @endcan
                                        @can('editar servidores')
                                        <a href="{{ route('servers.edit', $server) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @endcan
                                        @can('eliminar servidores')
                                        <form action="{{ route('servers.destroy', $server) }}" method="POST" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">
                                    No hay servidores registrados en la flota.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $servers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
