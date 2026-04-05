<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                Registros de <span class="text-[#00f6ff]">Auditoría</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs uppercase bg-[#0B1120] text-slate-400 border-b border-[#1e293b]">
                        <tr>
                            <th scope="col" class="px-6 py-4">Fecha</th>
                            <th scope="col" class="px-6 py-4">Usuario</th>
                            <th scope="col" class="px-6 py-4">Acción</th>
                            <th scope="col" class="px-6 py-4">Tabla / Modelo</th>
                            <th scope="col" class="px-6 py-4">IP</th>
                            <th scope="col" class="px-6 py-4 text-center">Detalles</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($auditLogs as $log)
                            <tr class="hover:bg-[#0B1120]/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-6 py-4">
                                    {{ $log->user ? $log->user->name : 'Sistema (Auto)' }} 
                                    <span class="text-xs text-slate-500 block">{{ $log->user ? $log->user->email : '' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($log->action === 'created')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">CREADO</span>
                                    @elseif($log->action === 'updated')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">ACTUALIZADO</span>
                                    @elseif($log->action === 'deleted')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">ELIMINADO</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-500/10 text-slate-400 border border-slate-500/20">{{ strtoupper($log->action) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-[#00f6ff]">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</td>
                                <td class="px-6 py-4 text-xs text-slate-400">{{ $log->ip_address }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('audit-logs.show', $log->id) }}" class="inline-flex items-center p-2 bg-[#0B1120] rounded-lg text-[#00f6ff] hover:bg-[#00f6ff] hover:text-[#0B1120] border border-[#1e293b] hover:border-[#00f6ff] transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    No hay registros de auditoría disponibles en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($auditLogs->hasPages())
                <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                    {{ $auditLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
