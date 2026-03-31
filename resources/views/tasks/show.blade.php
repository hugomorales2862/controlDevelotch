<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('tasks.index') }}" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    {{ __('Detalle de Tarea') }}
                </h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('tasks.edit', $task) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#1e293b] rounded-xl font-bold text-xs text-slate-300 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar Tarea
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 max-w-5xl mx-auto space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8">
                    <div class="flex items-center gap-3 mb-6">
                        @php
                            $statusColors = [
                                'pending' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                'in_progress' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                'review' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            ];
                            $color = $statusColors[$task->status] ?? $statusColors['pending'];
                        @endphp
                        <span class="px-3 py-1 text-[10px] uppercase font-bold tracking-wider rounded-full border {{ $color }}">
                            {{ $task->status }}
                        </span>
                        <span class="text-slate-500 text-xs">ID: #TSK-{{ $task->id }}</span>
                    </div>

                    <h1 class="text-3xl font-black text-white mb-6 leading-tight">{{ $task->title }}</h1>
                    
                    <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed">
                        <p class="whitespace-pre-line">{{ $task->description ?: 'Sin descripción detallada.' }}</p>
                    </div>

                    @if($task->notes)
                        <div class="mt-8 pt-8 border-t border-[#1e293b]">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Notas Internas</h4>
                            <div class="bg-[#0B1120] p-4 rounded-xl border border-[#1e293b] text-sm text-slate-400 font-mono italic">
                                {{ $task->notes }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Activity / History (Placeholder for now) -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Auditoría de Actividad
                    </h3>
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div class="w-2 bg-[#1e293b] rounded-full"></div>
                            <div>
                                <p class="text-xs text-slate-400">Tarea creada el {{ $task->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="space-y-6">
                <!-- Meta Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden">
                    <div class="p-6 space-y-6">
                        <div>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-2">Proyecto Padre</p>
                            <a href="{{ route('projects.show', $task->project_id) }}" class="text-sm font-bold text-[#00f6ff] hover:underline block">
                                {{ $task->project->name ?? 'Independiente' }}
                            </a>
                        </div>
                        
                        <div class="border-t border-[#1e293b] pt-6">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-2">Responsable</p>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#0B1120] border border-[#1e293b] flex items-center justify-center text-xs font-bold text-slate-400">
                                    {{ substr($task->assignedUser->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-white">{{ $task->assignedUser->name ?? 'Sin asignar' }}</span>
                            </div>
                        </div>

                        <div class="border-t border-[#1e293b] pt-6">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-2">Prioridad</p>
                            @php
                                $priorityColors = [
                                    'low' => 'text-slate-400',
                                    'medium' => 'text-indigo-400',
                                    'high' => 'text-amber-400',
                                    'urgent' => 'text-rose-500 font-black',
                                ];
                            @endphp
                            <span class="text-sm font-black uppercase {{ $priorityColors[$task->priority] ?? 'text-white' }}">
                                {{ $task->priority }}
                            </span>
                        </div>

                        <div class="border-t border-[#1e293b] pt-6">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-2">Entrega Comprometida</p>
                            <p class="text-sm font-black text-rose-500">
                                {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Por definir' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Time Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4 italic">Esfuerzo Logístico</h4>
                    <div class="flex items-center justify-between">
                        <div class="text-center flex-1 border-r border-[#1e293b]">
                            <p class="text-[10px] uppercase text-slate-500 mb-1">Estimado</p>
                            <p class="text-lg font-black text-white">{{ $task->estimated_hours ?: '0' }}h</p>
                        </div>
                        <div class="text-center flex-1">
                            <p class="text-[10px] uppercase text-slate-500 mb-1">Real</p>
                            <p class="text-lg font-black text-emerald-400">{{ $task->actual_hours ?: '0' }}h</p>
                        </div>
                    </div>
                    @if($task->estimated_hours > 0 && $task->actual_hours > 0)
                        <div class="mt-4 w-full bg-[#1e293b] rounded-full h-1">
                            @php
                                $percent = ($task->actual_hours / $task->estimated_hours) * 100;
                            @endphp
                            <div class="bg-{{ $percent > 100 ? 'rose' : 'emerald' }}-500 h-1 rounded-full" style="width: {{ min($percent, 100) }}%"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
