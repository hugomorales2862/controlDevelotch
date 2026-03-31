<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Modificar Tarea:') }} <span class="text-[#00f6ff]">{{ $task->title }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden drop-shadow-[0_0_15px_rgba(0,246,255,0.05)]">
            <div class="p-8">
                <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Project Selection -->
                        <div class="md:col-span-2">
                            <label for="project_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Proyecto / Aplicación</label>
                            <select id="project_id" name="project_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]">
                                <option value="">-- Seleccionar Proyecto --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }} ({{ $project->client->name ?? '?' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('project_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Resumen de la Tarea</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $task->title) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('title')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <label for="assigned_to" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Responsable Directo</label>
                            <select id="assigned_to" name="assigned_to"
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="">-- Sin Asignar --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estado</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>En Ejecución</option>
                                <option value="review" {{ old('status', $task->status) == 'review' ? 'selected' : '' }}>En Revisión</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Prioridad</label>
                            <select id="priority" name="priority" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                                <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>URGENTE / CRÍTICA</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label for="due_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Fecha de Entrega / Límite</label>
                            <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-400 focus:ring focus:ring-rose-400/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Time Tracking -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="estimated_hours" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estimado (H)</label>
                                <input id="estimated_hours" name="estimated_hours" type="number" step="0.5" value="{{ old('estimated_hours', $task->estimated_hours) }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-400 focus:ring focus:ring-indigo-400/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            </div>
                            <div>
                                <label for="actual_hours" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Real (H)</label>
                                <input id="actual_hours" name="actual_hours" type="number" step="0.5" value="{{ old('actual_hours', $task->actual_hours) }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-emerald-400 focus:ring focus:ring-emerald-400/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Detalles / Requerimientos</label>
                            <textarea id="description" name="description" rows="5" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">{{ old('description', $task->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Notas Adicionales (Opcional)</label>
                            <textarea id="notes" name="notes" rows="2" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 rounded-xl text-slate-400 py-4 px-5 shadow-sm transition-all">{{ old('notes', $task->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('tasks.index') }}" class="text-sm text-slate-500 hover:text-white mr-8 font-medium transition-colors uppercase tracking-widest italic">Descartar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.1)] hover:bg-[#00f6ff] hover:text-[#0B1120] hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Actualizar Tarea
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
