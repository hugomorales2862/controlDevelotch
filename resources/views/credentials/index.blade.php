<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Credenciales Técnicas') }}
            </h2>
            <a href="{{ route('credentials.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Credencial
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-xs font-bold text-slate-500 tracking-wider">
                        <th class="px-6 py-4">Servidor</th>
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4">Contraseña</th>
                        <th class="px-6 py-4">Llave SSH</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($credentials as $credential)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold border border-[#1e293b] shadow-[0_0_10px_rgba(0,246,255,0.1)]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $credential->vpsServer->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-[#00f6ff] opacity-70">{{ $credential->vpsServer->ip_address ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $credential->username }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-[#0B1120] rounded border border-[#1e293b] text-xs text-rose-400 font-mono">••••••••</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($credential->ssh_key)
                                    <span class="text-xs text-teal-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 9.125a2.483 2.483 0 004.838 0l6.865-4.226a.5.5 0 000-.858l-6.865-4.227a2.483 2.483 0 00-4.838 0L2.166 4.042a.5.5 0 000 .858z" clip-rule="evenodd"></path></svg>
                                        Presente
                                    </span>
                                @else
                                    <span class="text-xs text-slate-600">Ninguna</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    @can('editar credenciales')
                                    <a href="{{ route('credentials.edit', $credential) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors">
                                        Editar
                                    </a>
                                    @endcan
                                    @can('eliminar credenciales')
                                    <form action="{{ route('credentials.destroy', $credential) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                No hay credenciales registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($credentials->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                {{ $credentials->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
