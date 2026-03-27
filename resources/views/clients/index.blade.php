<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Clientes') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Cliente
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        


        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-xs font-bold text-slate-500 tracking-wider">
                        <th class="px-6 py-4">Cliente / Empresa</th>
                        <th class="px-6 py-4">Contacto</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($clients as $client)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold border border-[#1e293b] shadow-[0_0_10px_rgba(0,246,255,0.1)]">
                                        {{ substr($client->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $client->name }}</div>
                                        <div class="text-xs text-[#00f6ff] uppercase tracking-wider font-semibold mt-0.5">{{ $client->company ?: 'Independiente' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $client->email }}</div>
                                <div class="text-xs text-slate-500">{{ $client->phone ?: 'Sin teléfono' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('clients.show', $client) }}" class="text-[#00f6ff] hover:text-white bg-[#00f6ff]/10 hover:bg-[#00f6ff]/20 px-2.5 py-1.5 rounded-lg border border-[#00f6ff]/20 transition-colors">
                                        Ver
                                    </a>
                                    <a href="{{ route('clients.edit', $client) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors">
                                        Editar
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-sm font-medium text-slate-400">No hay clientes registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($clients->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
