<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Abrir Nuevo Ticket de Soporte') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('tickets.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-6">
                        <!-- Client -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Cliente Afectado</label>
                            <select id="client_id" name="client_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all">
                                <option value="">-- Seleccionar Cliente --</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}" {{ old('client_id') == $client->cli_id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->company }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Nivel de Prioridad / Urgencia</label>
                            <select id="priority" name="priority" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-500 rounded-xl text-white py-4 px-5 transition-all font-bold">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baja - Consulta General</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Media - Problema Menor</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta - Afectación de Servicio</option>
                                <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Crítica - Sistema Caído / Bloqueo Total</option>
                            </select>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Asunto / Resumen del Incidente</label>
                            <input id="subject" name="subject" type="text" value="{{ old('subject') }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]"
                                   placeholder="Ej: Fallo de conexión en base de datos de producción">
                            <x-input-error :messages="$errors->get('subject')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Descripción Detallada / Pasos para Reproducir</label>
                            <textarea id="description" name="description" rows="6" required
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-300 py-4 px-5 transition-all font-mono text-sm leading-relaxed">{{ old('description') }}</textarea>
                            <p class="mt-2 text-[10px] text-slate-500 uppercase tracking-tighter">Proporcione la mayor cantidad de información técnica posible.</p>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('tickets.index') }}" class="text-xs text-slate-500 hover:text-white mr-8 font-black uppercase tracking-widest transition-colors italic">Descartar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.3)]">
                            Abrir Ticket de Soporte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
