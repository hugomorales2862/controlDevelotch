<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Contactos de ') . $client->name }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('clients.show', $client) }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver al Cliente</a>
                <a href="{{ route('clients.contacts.create', $client) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Contacto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-xs font-bold text-slate-500 tracking-wider">
                        <th class="px-6 py-4">Contacto</th>
                        <th class="px-6 py-4">Cargo</th>
                        <th class="px-6 py-4">Teléfono</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold border border-[#1e293b] shadow-[0_0_10px_rgba(0,246,255,0.1)]">
                                        {{ substr($contact->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">{{ $contact->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-300">{{ $contact->role ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $contact->phone ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $contact->email ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    @can('ver contactos')
                                    <a href="{{ route('clients.contacts.show', [$client, $contact]) }}" class="text-[#00f6ff] hover:text-white bg-[#00f6ff]/10 hover:bg-[#00f6ff]/20 px-2.5 py-1.5 rounded-lg border border-[#00f6ff]/20 transition-colors">Ver</a>
                                    @endcan
                                    @can('editar contactos')
                                    <a href="{{ route('clients.contacts.edit', [$client, $contact]) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors">Editar</a>
                                    @endcan
                                    @can('eliminar contactos')
                                    <form action="{{ route('clients.contacts.destroy', [$client, $contact]) }}" method="POST" class="inline-block delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors">Eliminar</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-slate-400">No hay contactos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">{{ $contacts->links() }}</div>
        @endif
    </div>
</x-app-layout>
