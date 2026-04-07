<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Centro de Tareas') }}
            </h2>
            <a href="{{ route('tasks.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Nueva Tarea
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl overflow-hidden shadow-xl">
                <table class="min-w-full divide-y divide-[#1e293b]">
                    <thead class="bg-[#1e293b]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Tarea</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Proyecto</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Responsable</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Prioridad</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-[#1e293b]/20 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white">{{ $task->title }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase tracking-tighter">Vence: {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sin fecha' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-slate-400 font-medium">{{ $task->project->name ?? 'Independiente' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-800 border border-[#1e293b] flex items-center justify-center text-[8px] font-bold text-slate-400">
                                            {{ substr($task->assignedUser->name ?? '?', 0, 1) }}
                                        </div>
                                        <span class="text-xs text-slate-300 font-medium">{{ $task->assignedUser->name ?? 'Sin asignar' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            'in_progress' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'review' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        ];
                                        $statusColor = $statusStyles[$task->status] ?? $statusStyles['pending'];
                                    @endphp
                                    <span class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-wider rounded border {{ $statusColor }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $priorityStyles = [
                                            'low' => 'text-slate-500',
                                            'medium' => 'text-indigo-400',
                                            'high' => 'text-amber-500',
                                            'urgent' => 'text-rose-500 font-black glow-rose',
                                        ];
                                        $priorityColor = $priorityStyles[$task->priority] ?? 'text-white';
                                    @endphp
                                    <span class="text-[10px] uppercase font-black {{ $priorityColor }}">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        @can('ver tareas')
                                        <a href="{{ route('tasks.show', $task) }}" class="text-slate-400 hover:text-white transition-colors" title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        @endcan
                                        @can('editar tareas')
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @endcan
                                        @can('eliminar tareas')
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block delete-form">
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
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                    No hay tareas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-[#1e293b]/10">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
