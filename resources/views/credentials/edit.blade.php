<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Editar Credencial Técnica') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('credentials.update', $credential) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Server Selection -->
                        <div class="md:col-span-2">
                            <label for="vps_server_id" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Servidor VPS / Hosting</label>
                            <select id="vps_server_id" name="vps_server_id" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="">Seleccione un servidor</option>
                                @foreach($servers as $server)
                                    <option value="{{ $server->id }}" {{ (old('vps_server_id', $credential->vps_server_id) == $server->id) ? 'selected' : '' }}>
                                        {{ $server->hostname }} ({{ $server->ip_address }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('vps_server_id')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Usuario</label>
                            <input id="username" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="username" value="{{ old('username', $credential->username) }}" required placeholder="root, admin, etc." />
                            <x-input-error :messages="$errors->get('username')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nueva Contraseña (Opcional)</label>
                            <input id="password" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="password" name="password" placeholder="Dejar en blanco para mantener" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- SSH Key -->
                        <div class="md:col-span-2">
                            <label for="ssh_key" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Llave SSH (Opcional)</label>
                            <textarea id="ssh_key" name="ssh_key" rows="6" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4 font-mono text-sm" placeholder="-----BEGIN OPENSSH PRIVATE KEY-----...">{{ old('ssh_key', $credential->ssh_key) }}</textarea>
                            <x-input-error :messages="$errors->get('ssh_key')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('credentials.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">
                            Actualizar Credencial
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
