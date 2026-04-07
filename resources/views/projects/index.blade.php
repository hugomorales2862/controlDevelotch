<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Gestión de Proyectos') }}
            </h2>
            <a href="{{ route('projects.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300 shadow-[0_0_15px_rgba(0,246,255,0.1)]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Proyecto
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Proyecto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Progreso</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($projects as $project)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white group-hover:text-[#00f6ff] transition-colors">{{ $project->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $project->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-300 font-medium">{{ $project->client->name ?? 'Sin Cliente' }}</div>
                                    <div class="text-xs text-slate-500 italic">{{ $project->client->company ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'planning' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'active' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'on_hold' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'cancelled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        ];
                                        $color = $statusColors[$project->status] ?? 'bg-slate-500/10 text-slate-400 border-slate-500/20';
                                    @endphp
                                    <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-wider rounded-full border {{ $color }}">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-[#1e293b] rounded-full h-1.5 max-w-[100px]">
                                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <span class="text-[10px] text-slate-500 mt-1 block">45% completado</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        @can('ver proyectos')
                                        <a href="{{ route('projects.show', $project) }}" class="text-slate-400 hover:text-white transition-colors" title="Ver Detalle">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        @endcan
                                        @can('editar proyectos')
                                        <a href="{{ route('projects.edit', $project) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @endcan
                                        @can('eliminar proyectos')
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline-block delete-form">
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
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <span>No hay proyectos registrados aún.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
