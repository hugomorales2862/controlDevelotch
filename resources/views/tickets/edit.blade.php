<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tickets.show', $ticket) }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                Gestionar Ticket: <span class="text-[#00f6ff] lowercase">#{{ $ticket->id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Client (Read-only for context) -->
                        <div class="md:col-span-2">
                            <label class="block font-semibold text-xs text-slate-500 uppercase tracking-widest mb-2 italic">Cliente Referencia (No editable)</label>
                            <div class="bg-[#0B1120]/50 border border-[#1e293b] rounded-xl py-4 px-5 text-slate-400 font-bold">
                                {{ $ticket->client->name }} ({{ $ticket->client->company }})
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Estado del Ticket</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all font-bold">
                                <option value="new" {{ old('status', $ticket->status) == 'new' ? 'selected' : '' }}>Nuevo / Sin Abrir</option>
                                <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>Abierto / En Proceso</option>
                                <option value="pending" {{ old('status', $ticket->status) == 'pending' ? 'selected' : '' }}>En Espera / Pendiente Cliente</option>
                                <option value="resolved" {{ old('status', $ticket->status) == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                <option value="closed" {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>Cerrado Permanente</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Nivel de Prioridad</label>
                            <select id="priority" name="priority" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-500 rounded-xl text-white py-4 px-5 transition-all font-bold">
                                <option value="low" {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                                <option value="critical" {{ old('priority', $ticket->priority) == 'critical' ? 'selected' : '' }}>Crítica</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Assigned User (Reassign) -->
                        <div class="md:col-span-2">
                            <label for="user_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Responsable Asignado</label>
                            <select id="user_id" name="user_id"
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all font-bold">
                                <option value="">-- Sin Asignar / Sin Propietario --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $ticket->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Subject -->
                        <div class="md:col-span-2">
                            <label for="subject" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Asunto / Resumen del Incidente</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject', $ticket->subject) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]">
                            <x-input-error :messages="$errors->get('subject')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Descripción Detallada / Pasos para Reproducir</label>
                            <textarea id="description" name="description" rows="6" required
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-300 py-4 px-5 transition-all font-mono text-sm leading-relaxed">{{ old('description', $ticket->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-xs text-slate-500 hover:text-white mr-8 font-black uppercase tracking-widest transition-colors italic">Cancelar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-12 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-300 hover:bg-[#00f6ff] hover:text-[#0B1120] shadow-[0_0_20px_rgba(0,246,255,0.1)]">
                            Actualizar Gestión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
