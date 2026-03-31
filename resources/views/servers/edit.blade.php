<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Gestionar VPS:') }} <span class="text-[#00f6ff]">{{ $server->hostname }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('servers.update', $server) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Hostname -->
                        <div>
                            <label for="hostname" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Hostname / Etiqueta</label>
                            <input id="hostname" name="hostname" type="text" value="{{ old('hostname', $server->hostname) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 transition-all">
                            <x-input-error :messages="$errors->get('hostname')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- IP Address -->
                        <div>
                            <label for="ip_address" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Dirección IP Publica</label>
                            <input id="ip_address" name="ip_address" type="text" value="{{ old('ip_address', $server->ip_address) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-[#00f6ff] font-mono py-4 px-5 transition-all">
                            <x-input-error :messages="$errors->get('ip_address')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Client -->
                        <div>
                            <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Cliente Propietario</label>
                            <select id="client_id" name="client_id" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all">
                                @foreach($clients as $client)
                                    <option value="{{ $client->cli_id }}" {{ old('client_id', $server->client_id) == $client->cli_id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->company }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Provider / Region -->
                        <div>
                            <label for="provider" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Proveedor / Región</label>
                            <div class="grid grid-cols-2 gap-4">
                                <input id="provider" name="provider" type="text" value="{{ old('provider', $server->provider) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 text-xs">
                                <input id="region" name="region" type="text" value="{{ old('region', $server->region) }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 text-xs">
                            </div>
                        </div>

                        <!-- OS -->
                        <div>
                            <label for="os" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Sistema Operativo</label>
                            <input id="os" name="os" type="text" value="{{ old('os', $server->os) }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 transition-all">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estado del Servidor</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 transition-all">
                                <option value="active" {{ old('status', $server->status) == 'active' ? 'selected' : '' }}>Activo / Operativo</option>
                                <option value="inactive" {{ old('status', $server->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                <option value="suspended" {{ old('status', $server->status) == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                <option value="terminated" {{ old('status', $server->status) == 'terminated' ? 'selected' : '' }}>Terminado / Borrado</option>
                            </select>
                        </div>

                        <!-- Technical Specs -->
                        <div class="md:col-span-2 grid grid-cols-3 gap-6 bg-[#0B1120] p-6 rounded-2xl border border-white/5">
                            <div>
                                <label for="cpu_cores" class="block font-black text-[9px] text-[#00f6ff] uppercase tracking-tighter mb-2 italic">vCores de CPU</label>
                                <input id="cpu_cores" name="cpu_cores" type="number" value="{{ old('cpu_cores', $server->cpu_cores) }}" required
                                       class="block w-full bg-[#0f172a] border border-[#1e293b] rounded-xl text-white py-3 px-4">
                            </div>
                            <div>
                                <label for="ram_gb" class="block font-black text-[9px] text-[#00f6ff] uppercase tracking-tighter mb-2 italic">RAM (GB)</label>
                                <input id="ram_gb" name="ram_gb" type="number" value="{{ old('ram_gb', $server->ram_gb) }}" required
                                       class="block w-full bg-[#0f172a] border border-[#1e293b] rounded-xl text-white py-3 px-4">
                            </div>
                            <div>
                                <label for="storage_gb" class="block font-black text-[9px] text-[#00f6ff] uppercase tracking-tighter mb-2 italic">SSD/NVMe (GB)</label>
                                <input id="storage_gb" name="storage_gb" type="number" value="{{ old('storage_gb', $server->storage_gb) }}" required
                                       class="block w-full bg-[#0f172a] border border-[#1e293b] rounded-xl text-white py-3 px-4">
                            </div>
                        </div>

                        <!-- Dates and Costs -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="monthly_cost" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Costo Mensual ($)</label>
                                <input id="monthly_cost" name="monthly_cost" type="number" step="0.01" value="{{ old('monthly_cost', $server->monthly_cost) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-[#00f6ff] py-4 px-5 font-bold">
                            </div>
                            <div>
                                <label for="setup_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Fecha de Alta</label>
                                <input id="setup_date" name="setup_date" type="date" value="{{ old('setup_date', $server->setup_date ? $server->setup_date->format('Y-m-d') : '') }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 text-xs">
                            </div>
                            <div>
                                <label for="expiry_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Vencimiento</label>
                                <input id="expiry_date" name="expiry_date" type="date" value="{{ old('expiry_date', $server->expiry_date ? $server->expiry_date->format('Y-m-d') : '') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 text-xs">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Notas Técnicas</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-slate-300 py-4 px-5 transition-all">{{ old('notes', $server->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('servers.index') }}" class="text-xs text-slate-500 hover:text-white mr-8 font-black uppercase tracking-widest transition-colors italic">Descartar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-500 hover:bg-[#00f6ff] hover:text-[#0B1120]">
                            Actualizar Servidor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
