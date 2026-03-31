<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Gestionar Proyecto:') }} <span class="text-[#00f6ff]">{{ $project->name }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Project Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Nombre del Proyecto</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $project->name) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Client Selection -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Cliente Principal</label>
                            <select id="client_id" name="client_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]">
                                <option value="">-- Seleccionar Cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}" {{ old('client_id', $project->client_id) == $client->cli_id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->company }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <label for="assigned_to" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Responsable / PM</label>
                            <select id="assigned_to" name="assigned_to"
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="">-- Sin Asignar --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $project->assigned_to) == $user->id ? 'selected' : '' }}>
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
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all border-l-4 {{ $project->status == 'active' ? 'border-emerald-500' : 'border-slate-500' }}">
                                <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Planeación / Discovery</option>
                                <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>En Desarrollo / Activo</option>
                                <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>En Pausa</option>
                                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Entregado / Finalizado</option>
                                <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Prioridad</label>
                            <select id="priority" name="priority" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all border-l-4 {{ $project->priority == 'urgent' ? 'border-rose-500' : ($project->priority == 'high' ? 'border-amber-500' : 'border-indigo-500') }}">
                                <option value="low" {{ old('priority', $project->priority) == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ old('priority', $project->priority) == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ old('priority', $project->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                                <option value="urgent" {{ old('priority', $project->priority) == 'urgent' ? 'selected' : '' }}>URGENTE</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Presupuesto ($)</label>
                            <input id="budget" name="budget" type="number" step="0.01" value="{{ old('budget', $project->budget) }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('budget')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 md:col-span-1">
                            <div>
                                <label for="start_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Inicio</label>
                                <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            </div>
                            <div>
                                <label for="due_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Entrega</label>
                                <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $project->due_date ? $project->due_date->format('Y-m-d') : '') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-rose-400 font-bold py-4 px-5 shadow-sm transition-all">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Descripción General del Proyecto</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">{{ old('description', $project->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Notas Técnicas / Internas (Opcional)</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 rounded-xl text-slate-300 py-4 px-5 shadow-sm transition-all">{{ old('notes', $project->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('projects.index') }}" class="text-sm text-slate-500 hover:text-white mr-8 font-medium transition-colors uppercase tracking-widest italic">Cancelar Cambios</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.1)] hover:bg-[#00f6ff] hover:text-[#0B1120] hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
