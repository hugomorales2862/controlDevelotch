<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Detalles del Rol') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('roles.index') }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                <a href="{{ route('roles.edit', $role) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Role Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">{{ $role->name }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                        Rol
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nombre</p>
                        <p class="text-sm font-medium text-white">{{ $role->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Usuarios Asignados</p>
                        <p class="text-sm font-medium text-white">{{ $role->users->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Section -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-bold text-white mb-4">Permisos Asignados</h3>
                @if($role->permissions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($role->permissions as $permission)
                            <div class="flex items-center p-3 bg-[#0B1120]/50 rounded-lg border border-[#1e293b]">
                                <svg class="w-5 h-5 text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-white">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400">No hay permisos asignados a este rol.</p>
                @endif
            </div>
        </div>

        <!-- Users Section -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-bold text-white mb-4">Usuarios con este Rol</h3>
                @if($role->users->count() > 0)
                    <div class="space-y-3">
                        @foreach($role->users as $user)
                            <div class="flex items-center justify-between p-4 bg-[#0B1120]/50 rounded-lg border border-[#1e293b]">
                                <div>
                                    <h4 class="font-medium text-white">{{ $user->name }}</h4>
                                    <p class="text-sm text-slate-400">{{ $user->email }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-medium bg-blue-500/20 text-blue-400">
                                    Usuario
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400">No hay usuarios asignados a este rol.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>