<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('tickets.index') }}" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    Ticket <span class="text-indigo-500">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                </h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('tickets.edit', $ticket) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#1e293b] rounded-xl font-bold text-xs text-slate-300 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all">
                    Gestionar Estado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar: Details -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status Card -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 shadow-xl overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#00f6ff]/5 rounded-bl-full blur-2xl"></div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 italic">Estado Actual</p>
                    @php
                        $statusStyles = [
                            'new' => 'text-indigo-400 bg-indigo-500/10 border-indigo-500/20',
                            'open' => 'text-[#00f6ff] bg-[#00f6ff]/10 border-[#00f6ff]/20',
                            'pending' => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                            'resolved' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                            'closed' => 'text-slate-500 bg-slate-500/10 border-slate-500/20',
                        ];
                    @endphp
                    <div class="px-4 py-3 rounded-xl border {{ $statusStyles[$ticket->status] ?? '' }} flex items-center justify-center font-black uppercase text-xs tracking-widest">
                        {{ $ticket->status }}
                    </div>

                    <div class="mt-8 pt-8 border-t border-white/5 space-y-4">
                        <div>
                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1">Prioridad</p>
                            <p class="text-sm font-black text-white uppercase">{{ $ticket->priority }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1">Cliente</p>
                            <p class="text-sm font-black text-[#00f6ff]">{{ $ticket->client->name ?? 'N/A' }}</p>
                            <p class="text-[10px] text-slate-500 italic">{{ $ticket->client->company ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1">Asignado a</p>
                            <p class="text-sm font-black text-white italic">{{ $ticket->owner->name ?? 'Sin asignar' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Messages -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Incident Header -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8 shadow-xl">
                    <h1 class="text-2xl font-black text-white mb-4 leading-tight">{{ $ticket->subject }}</h1>
                    <div class="p-6 bg-[#0B1120] rounded-2xl border border-white/5 text-slate-300 text-sm leading-relaxed whitespace-pre-line italic">
                        {{ $ticket->description }}
                    </div>
                    <div class="mt-4 flex items-center justify-between text-[10px] text-slate-500 uppercase font-bold tracking-tighter">
                        <span>Abierto por: {{ $ticket->owner->name ?? 'Sistema' }}</span>
                        <span>{{ $ticket->created_at->format('d M, Y H:i') }}</span>
                    </div>
                </div>

                <!-- Messages / Conversation -->
                <div class="space-y-4">
                    @foreach($ticket->messages as $message)
                        <div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] rounded-2xl p-6 {{ $message->user_id == Auth::id() ? 'bg-indigo-600/10 border border-indigo-500/20 text-white' : 'bg-[#1e293b] border border-white/5 text-slate-300' }}">
                                <div class="flex items-center gap-3 mb-2 underline decoration-[#00f6ff]/30">
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ $message->user->name }}</span>
                                    <span class="text-[9px] font-bold text-slate-500 opacity-70">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-sm leading-relaxed">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Message Form (Footer Chat style) -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-[#00f6ff]"></div>
                    <form action="{{ route('tickets.add-message', $ticket) }}" method="POST">
                        @csrf
                        <label for="message" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Añadir Respuesta / Comentario Técnico</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-300 text-sm py-4 px-5 transition-all mb-4"
                                  placeholder="Escriba aquí para responder..."></textarea>
                        
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-black text-[10px] text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Enviar Respuesta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
