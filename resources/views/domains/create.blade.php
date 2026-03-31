<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Registrar Nuevo Dominio') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('domains.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Domain Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Nombre del Dominio (FQDN)</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-black py-5 px-6 transition-all lowercase shadow-[0_0_15px_rgba(0,246,255,0.05)]"
                                   placeholder="ejemplo.com">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Client -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Cliente Propietario</label>
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

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Estado Inicial</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all uppercase text-[10px] font-black">
                                <option value="active">Activo / Vinculado</option>
                                <option value="pending_transfer">En Proceso de Transferencia</option>
                                <option value="suspended">Suspendido / Off</option>
                            </select>
                        </div>

                        <!-- Expiration -->
                        <div class="md:col-span-2">
                            <label for="expires_at" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Fecha de Vencimiento / Renovación</label>
                            <input id="expires_at" name="expires_at" type="date" value="{{ old('expires_at') }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-500 rounded-xl text-rose-400 font-bold py-4 px-5 transition-all">
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('domains.index') }}" class="text-xs text-slate-500 hover:text-white mr-8 font-black uppercase tracking-widest transition-colors italic">Cancelar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_20px_rgba(0,246,255,0.2)] hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Registrar Dominio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
