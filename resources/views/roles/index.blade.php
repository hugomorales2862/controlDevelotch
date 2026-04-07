<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">{{ __('Roles del Sistema') }}</h2>
            <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Rol
            </a>
        </div>
    </x-slot>
    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-xs font-bold text-slate-500 tracking-wider">
                        <th class="px-6 py-4">Rol</th>
                        <th class="px-6 py-4">Usuarios</th>
                        <th class="px-6 py-4">Permisos</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($roles as $role)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/30">{{ ucfirst($role->name) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $role->users_count }} usuario(s)</td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-500">{{ $role->permissions->count() }} permiso(s)</span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    @can('editar roles')
                                    <a href="{{ route('roles.edit', $role) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors">Editar</a>
                                    @endcan
                                    @if($role->users_count === 0)
                                    @can('eliminar roles')
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors">Eliminar</button>
                                    </form>
                                    @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center"><p class="text-sm font-medium text-slate-400">No hay roles definidos</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
