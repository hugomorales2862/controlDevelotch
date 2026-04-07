<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('portal.dashboard') }}" class="text-slate-500 hover:text-[#00f6ff] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                    Mis <span class="text-[#00f6ff]">Conversaciones</span>
                </h2>
            </div>
            <form method="POST" action="{{ route('client.auth.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0B1120] border border-[#1e293b] text-slate-400 hover:border-rose-500/50 hover:text-rose-400 transition-all text-xs font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Salir
                </button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <!-- Iniciar nuevo chat -->
        <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 mb-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#00f6ff] to-indigo-600"></div>
            <form method="POST" action="{{ route('portal.tickets.create') }}" class="flex gap-4 relative z-10">
                @csrf
                <textarea name="message" rows="1" required
                          class="flex-1 bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-100 text-sm py-4 px-6 transition-all resize-none placeholder:italic placeholder:text-slate-600"
                          placeholder="Escribe aquí para iniciar una nueva conversación..."></textarea>
                <button type="submit"
                        style="background: linear-gradient(135deg, #00f2fe, #4facfe);"
                        class="px-6 rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-widest hover:shadow-[0_0_25px_rgba(0,246,255,0.4)] transition-all duration-300 whitespace-nowrap">
                    + Nuevo Chat
                </button>
            </form>
        </div>

        <!-- Listado de conversaciones -->
        <div class="space-y-3">
            @forelse($tickets as $ticket)
                <a href="{{ route('portal.tickets.show', $ticket) }}" class="block group bg-[#0f172a] rounded-2xl border border-[#1e293b] p-5 hover:border-[#00f6ff]/30 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full {{ in_array($ticket->status, ['resolved', 'closed']) ? 'bg-slate-600' : 'bg-[#00f6ff]' }}"></div>
                    <div class="flex items-center justify-between ml-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[9px] font-mono text-[#00f6ff]/50">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                                @php
                                    $statusColors = [
                                        'new' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'open' => 'bg-[#00f6ff]/10 text-[#00f6ff] border-[#00f6ff]/20',
                                        'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                        'resolved' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                        'closed' => 'bg-slate-500/10 text-slate-500 border-slate-500/20',
                                    ];
                                    $statusLabels = [
                                        'new' => 'Nuevo',
                                        'open' => 'Abierto',
                                        'pending' => 'Pendiente',
                                        'resolved' => 'Resuelto',
                                        'closed' => 'Cerrado',
                                    ];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest border {{ $statusColors[$ticket->status] ?? 'bg-slate-500/10 text-slate-500 border-slate-500/20' }}">
                                    {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                </span>
                            </div>
                            <p class="text-sm font-bold text-white truncate italic">{{ $ticket->subject }}</p>
                        </div>
                        <div class="flex items-center gap-4 ml-4 shrink-0">
                            <span class="text-[10px] text-slate-500 italic">{{ $ticket->updated_at->diffForHumans() }}</span>
                            <div class="p-2 rounded-xl bg-white/5 group-hover:bg-[#00f6ff]/10 group-hover:text-[#00f6ff] transition-all text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-full bg-[#0f172a] border border-[#1e293b] flex items-center justify-center mx-auto mb-6 text-slate-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-slate-500 italic text-sm font-bold">Aún no tienes conversaciones.</p>
                    <p class="text-slate-600 text-xs mt-1">Usa el campo de arriba para iniciar tu primer chat con nuestro equipo.</p>
                </div>
            @endforelse
        </div>

        @if($tickets->hasPages())
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
