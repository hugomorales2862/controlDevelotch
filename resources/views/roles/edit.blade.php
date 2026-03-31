<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">{{ __('Editar Rol') }}: {{ ucfirst($role->name) }}</h2>
    </x-slot>
    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre del Rol</label>
                        <input id="name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="name" value="{{ old('name', $role->name) }}" required />
                    </div>
                    @if($permissions->count())
                    <div>
                        <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-3">Permisos</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($permissions as $perm)
                                <label class="flex items-center space-x-2 bg-[#0B1120] border border-[#1e293b] rounded-lg px-3 py-2 hover:border-[#00f6ff]/30 transition-colors cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded bg-[#0B1120] border-[#1e293b] text-[#00f6ff] focus:ring-[#00f6ff]/20" {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-300">{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('roles.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">Actualizar Rol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
