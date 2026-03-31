<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Gestionar Dominio:') }} <span class="text-[#00f6ff] lowercase">{{ $domain->name }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('domains.update', $domain) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Domain Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Nombre del Dominio</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $domain->name) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-[#00f6ff] font-black py-4 px-5 transition-all lowercase">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Client -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Cliente Propietario</label>
                            <select id="client_id" name="client_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all">
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}" {{ old('client_id', $domain->client_id) == $client->cli_id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->company }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Estado Actual</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 transition-all uppercase text-[10px] font-black">
                                <option value="active" {{ old('status', $domain->status) == 'active' ? 'selected' : '' }}>Activo / Renovado</option>
                                <option value="pending_transfer" {{ old('status', $domain->status) == 'pending_transfer' ? 'selected' : '' }}>En Transferencia</option>
                                <option value="suspended" {{ old('status', $domain->status) == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                <option value="expired" {{ old('status', $domain->status) == 'expired' ? 'selected' : '' }}>Expirado / Caído</option>
                            </select>
                        </div>

                        <!-- Expiration -->
                        <div class="md:col-span-2">
                            <label for="expires_at" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Fecha de Vencimiento / Expiración</label>
                            <input id="expires_at" name="expires_at" type="date" value="{{ old('expires_at', $domain->expires_at ? $domain->expires_at->format('Y-m-d') : '') }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-rose-500 font-bold py-4 px-5 transition-all">
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('domains.index') }}" class="text-xs text-slate-500 hover:text-white mr-8 font-black uppercase tracking-widest transition-colors italic">Descartar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-500 hover:bg-[#00f6ff] hover:text-[#0B1120] hover:scale-105 active:scale-95">
                            Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
