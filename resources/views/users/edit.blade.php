<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">{{ __('Editar Usuario') }}: {{ $user->name }}</h2>
    </x-slot>
    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre</label>
                            <input id="name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="name" value="{{ old('name', $user->name) }}" required />
                        </div>
                        <div>
                            <label for="email" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Correo</label>
                            <input id="email" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                        </div>
                        <div>
                            <label for="password" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nueva Contraseña (dejar vacío para mantener)</label>
                            <input id="password" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="password" name="password" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Confirmar</label>
                            <input id="password_confirmation" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="password" name="password_confirmation" />
                        </div>
                        <div class="md:col-span-2">
                            <label for="role" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Rol</label>
                            <select id="role" name="role" required class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('users.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
