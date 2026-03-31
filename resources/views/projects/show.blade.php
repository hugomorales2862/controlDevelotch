<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    {{ __('Proyecto:') }} <span class="text-[#00f6ff] glow-cyan">{{ $project->name }}</span>
                </h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('projects.edit', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#1e293b] rounded-xl font-bold text-xs text-slate-300 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar Proyecto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 max-w-7xl mx-auto space-y-8">
        <!-- Dashboard Header -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-[#1e293b] shadow-lg">
                <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-1">Estado Actual</p>
                @php
                    $statusColors = [
                        'planning' => 'text-slate-400',
                        'active' => 'text-indigo-400',
                        'on_hold' => 'text-amber-400',
                        'completed' => 'text-emerald-400',
                        'cancelled' => 'text-rose-400',
                    ];
                @endphp
                <p class="text-xl font-black {{ $statusColors[$project->status] ?? 'text-white' }} uppercase">
                    {{ $project->status }}
                </p>
            </div>
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-[#1e293b] shadow-lg">
                <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-1">Prioridad</p>
                <p class="text-xl font-black {{ $project->priority == 'urgent' ? 'text-rose-500' : 'text-white' }} uppercase">
                    {{ $project->priority }}
                </p>
            </div>
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-[#1e293b] shadow-lg">
                <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-1">Presupuesto</p>
                <p class="text-xl font-black text-[#00f6ff]">${{ number_format($project->budget, 2) }}</p>
            </div>
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-[#1e293b] shadow-lg text-right">
                <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-1">Fecha Límite</p>
                <p class="text-xl font-black text-rose-500">{{ $project->due_date ? $project->due_date->format('d/m/Y') : 'Sin definir' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Project Details -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-3 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Descripción y Alcance
                    </h3>
                    <div class="text-slate-300 leading-relaxed space-y-4">
                        <p>{{ $project->description ?: 'No hay descripción disponible para este proyecto.' }}</p>
                    </div>

                    @if($project->notes)
                        <div class="mt-8 pt-8 border-t border-[#1e293b]">
                            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Notas Técnicas</h4>
                            <div class="bg-[#0B1120] p-5 rounded-xl border border-[#1e293b] text-sm text-slate-400 font-mono italic">
                                {{ $project->notes }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Related Tasks -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden">
                    <div class="p-6 border-b border-[#1e293b] flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-3 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Tareas del Proyecto
                        </h3>
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-xs font-bold text-[#00f6ff] hover:underline uppercase tracking-widest">+ Añadir Tarea</a>
                    </div>
                    <div class="divide-y divide-[#1e293b]">
                        @forelse($project->tasks as $task)
                            <div class="p-5 hover:bg-[#1e293b]/20 transition-colors flex items-center justify-between group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#0B1120] border border-[#1e293b] flex items-center justify-center text-[#00f6ff]">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white group-hover:text-[#00f6ff] transition-colors">{{ $task->title }}</p>
                                        <p class="text-xs text-slate-500 italic">{{ $task->assignedUser->name ?? 'Sin asignar' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-[10px] uppercase font-bold px-2 py-1 rounded bg-[#0B1120] border border-[#1e293b] text-slate-400">
                                        {{ $task->status }}
                                    </span>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-slate-500 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-slate-500 text-sm">
                                Este proyecto no tiene tareas asignadas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Client Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Información del Cliente</h4>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 text-xl font-black">
                            {{ substr($project->client->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white leading-tight">{{ $project->client->name ?? 'Cliente Desconocido' }}</p>
                            <p class="text-xs text-slate-500 italic">{{ $project->client->company ?? 'Independiente' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('clients.show', $project->client_id) }}" class="block text-center py-3 bg-[#0B1120] border border-[#1e293b] rounded-xl text-xs font-bold text-slate-400 hover:text-white hover:border-slate-500 transition-all">Ver Ficha del Cliente</a>
                </div>

                <!-- Dates Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Cronograma</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Inicio</span>
                            <span class="text-white font-bold">{{ $project->start_date ? $project->start_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500 font-medium">Límite</span>
                            <span class="text-rose-500 font-bold">{{ $project->due_date ? $project->due_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm pt-4 border-t border-[#1e293b]">
                            <span class="text-slate-500 font-medium">Días Restantes</span>
                            <span class="text-white font-bold">
                                {{ $project->due_date ? now()->diffInDays($project->due_date, false) : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Responsible/Team -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Responsable</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-800 border border-[#1e293b] flex items-center justify-center text-[10px] font-bold text-slate-400">
                            {{ substr($project->assignedTo->name ?? '?', 0, 1) }}
                        </div>
                        <p class="text-sm font-medium text-slate-300">{{ $project->assignedTo->name ?? 'Sin asignar' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
