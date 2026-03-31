<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Lanzar Nuevo Proyecto') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('projects.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Project Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Nombre del Proyecto</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all"
                                   placeholder="Ej: Desarrollo E-commerce Develotech">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Client Selection -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Cliente Principal</label>
                            <select id="client_id" name="client_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]">
                                <option value="">-- Seleccionar Cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}" {{ old('client_id') == $client->cli_id ? 'selected' : '' }}>
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
                                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estado Inicial</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>Planeación / Discovery</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>En Desarrollo / Activo</option>
                                <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>En Pausa</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Entregado / Finalizado</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Prioridad</label>
                            <select id="priority" name="priority" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>URGENTE</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Presupuesto ($)</label>
                            <input id="budget" name="budget" type="number" step="0.01" value="{{ old('budget') }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold py-4 px-5 shadow-sm transition-all"
                                   placeholder="0.00">
                            <x-input-error :messages="$errors->get('budget')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4 md:col-span-1">
                            <div>
                                <label for="start_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Inicio</label>
                                <input id="start_date" name="start_date" type="date" value="{{ old('start_date', date('Y-m-d')) }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            </div>
                            <div>
                                <label for="due_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Entrega</label>
                                <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-rose-400 font-bold py-4 px-5 shadow-sm transition-all">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Descripción General del Proyecto</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Notas Técnicas / Internas (Opcional)</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 rounded-xl text-slate-300 py-4 px-5 shadow-sm transition-all"
                                      placeholder="Servidores de staging, credenciales temporales, etc.">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('projects.index') }}" class="text-sm text-slate-500 hover:text-white mr-8 font-medium transition-colors uppercase tracking-widest italic">Cancelar Proceso</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.3)] hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Lanzar Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
