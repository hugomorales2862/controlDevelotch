<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('portal.dashboard') }}" class="text-slate-500 hover:text-[#00f6ff] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                    Centro de <span class="text-[#00f6ff]">Conversaciones</span>
                </h2>
            </div>
            <div class="flex items-center gap-4">
                @if($activeTicket)
                    <span class="px-3 py-1 bg-[#00f6ff]/10 border border-[#00f6ff]/20 text-[#00f6ff] text-[10px] font-black uppercase tracking-widest rounded-full animate-pulse">
                        Chat Activo #{{ $activeTicket->id }}
                    </span>
                @endif
                <form method="POST" action="{{ route('client.auth.logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-xl bg-[#0B1120] border border-[#1e293b] text-slate-400 hover:border-rose-500/50 hover:text-rose-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-[#0f172a] border border-[#1e293b] rounded-3xl overflow-hidden shadow-2xl flex flex-col relative" style="height: calc(100vh - 200px);">
            
            <!-- Context Header (Mini) -->
            <div class="bg-[#0B1120] border-b border-[#1e293b] p-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-blue-700 flex items-center justify-center text-white font-black">
                        S
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white leading-none">Soporte Técnico</h4>
                        <p class="text-[10px] text-slate-500 mt-1 italic">En línea para ayudarte</p>
                    </div>
                </div>
            </div>

            <!-- Messages Stream -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-6 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent flex flex-col" style="background-image: radial-gradient(circle at 20% 30%, rgba(0,246,255,0.03) 0, transparent 100%);">
                @php $lastTicketId = null; @endphp

                @forelse($unifiedMessages as $msg)
                    @if($lastTicketId !== $msg->context_ticket_id)
                        <div class="flex justify-center my-6">
                            <span class="px-4 py-1.5 bg-[#1e293b] text-[10px] text-slate-400 rounded-full border border-white/5 uppercase font-black tracking-widest shadow-xl">
                                Ticket #{{ str_pad($msg->context_ticket_id, 4, '0', STR_PAD_LEFT) }} - {{ $msg->context_subject }}
                            </span>
                        </div>
                        @php $lastTicketId = $msg->context_ticket_id; @endphp
                    @endif

                    @php
                        $isAdmin = $msg->user_id !== null && $msg->user->hasRole(['admin', 'staff']);
                    @endphp

                    <div class="flex {{ $isAdmin ? 'justify-start' : 'justify-end' }} animate-in fade-in slide-in-from-bottom-4 duration-300">
                        @if($msg->user_id === null && str_contains($msg->message, '[DEVELO_AI_CHOICE]'))
                            <div class="max-w-[85%] bg-[#0B1120] border border-[#00f6ff]/30 rounded-2xl p-6 shadow-[0_0_30px_rgba(0,246,255,0.1)] relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-400 to-blue-500 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                                        <svg class="w-6 h-6 text-[#0B1120]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8Z"/><path d="M12 6a1 1 0 0 0-1 1v3H8a1 1 0 0 0 0 2h3v3a1 1 0 0 0 2 0v-3h3a1 1 0 0 0 0-2h-3V7a1 1 0 0 0-1-1Z"/></svg>
                                    </div>
                                    <h5 class="text-sm font-black text-white uppercase tracking-tighter">DeveloAI <span class="text-cyan-400">Assistant</span></h5>
                                </div>
                                <p class="text-sm text-slate-300 mb-6 leading-relaxed">
                                    ¡Hola! Soy **DeveloAI**. He recibido tu solicitud. Para darte la mejor atención, ¿cómo prefieres continuar?
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button onclick="selectHandler('ai')" class="flex-1 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-[#0B1120] font-black text-[10px] uppercase tracking-widest rounded-xl hover:scale-105 transition-transform">
                                        Hablar con DeveloAI (IA)
                                    </button>
                                    <button onclick="selectHandler('human')" class="flex-1 px-4 py-3 bg-[#1e293b] text-slate-300 border border-slate-700 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all">
                                        Esperar un Asesor
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="max-w-[80%] sm:max-w-[70%] {{ $isAdmin ? 'bg-[#1e293b] text-slate-200 border border-white/5 rounded-2xl rounded-tl-none' : ($msg->user_id === null ? 'bg-slate-800/50 text-slate-300 border border-slate-700 rounded-2xl italic text-xs' : 'bg-gradient-to-br from-indigo-600 to-blue-700 text-white rounded-2xl rounded-tr-none shadow-[0_10px_20px_rgba(79,70,229,0.2)]') }} p-4 relative group">
                                <div class="flex items-center gap-2 mb-1.5 opacity-60">
                                    <span class="text-[9px] font-black uppercase tracking-widest">{{ $isAdmin ? ($msg->user->name ?? 'Soporte') : ($msg->user_id === null ? 'DeveloAI' : 'Tú') }}</span>
                                    <span class="text-[8px] font-medium">{{ $msg->created_at->format('H:i d/M') }}</span>
                                </div>
                                <div class="text-sm leading-relaxed whitespace-pre-wrap">{!! nl2br(e($msg->message)) !!}</div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="flex-1 flex flex-col items-center justify-center text-slate-500 italic">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <p class="font-bold">No hay mensajes previos.</p>
                        <p class="text-xs mt-1">Escribe abajo para iniciar tu primera consulta.</p>
                    </div>
                @endforelse
            </div>

            <!-- Feedback Label -->
            <div id="chat-feedback" class="hidden absolute bottom-24 left-6 text-[10px] text-cyan-400 font-black tracking-widest animate-pulse z-20">
                ENVIANDO MENSAJE...
            </div>

            <!-- Input Area -->
            <div class="p-6 bg-[#0B1120] border-t border-[#1e293b] shrink-0">
                <form id="chat-form" action="{{ $activeTicket ? route('portal.tickets.message', $activeTicket) : route('portal.tickets.create') }}" method="POST" class="flex gap-4">
                    @csrf
                    <textarea id="message-input" name="message" rows="1" required 
                              placeholder="{{ $activeTicket ? 'Escribe tu respuesta...' : 'Escribe aquí para iniciar un nuevo chat...' }}" 
                              class="flex-1 bg-[#1e293b] border border-[#334155] focus:border-[#00f6ff] text-slate-100 rounded-2xl py-4 px-6 resize-none shadow-inner text-sm transition-all focus:ring-0 placeholder:italic placeholder:text-slate-600"></textarea>
                    
                    <button type="submit" id="submit-btn" 
                            class="w-14 h-14 bg-gradient-to-tr from-[#00f2fe] to-[#4facfe] rounded-2xl flex items-center justify-center text-[#0B1120] hover:shadow-[0_0_20px_rgba(0,246,255,0.4)] transition-all duration-300 group">
                        <svg class="w-6 h-6 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Closed Template (Hidden) -->
    <template id="template-closed">
        <div class="flex justify-center my-6">
            <span class="px-4 py-1.5 bg-rose-500/10 text-[9px] text-rose-400 rounded-full border border-rose-500/20 uppercase font-black tracking-widest italic animate-bounce">
                ESTA CONVERSACIÓN HA FINALIZADO POR INACTIVIDAD
            </span>
        </div>
    </template>

    </template>

    <script>
        window.selectHandler = function(mode) {
            @if($activeTicket)
                fetch("{{ route('portal.tickets.select-handler', $activeTicket) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ mode: mode })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // El mensaje de confirmación llegará via Echo
                    }
                });
            @endif
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            const input = document.getElementById('message-input');
            const form = document.getElementById('chat-form');
            const feedback = document.getElementById('chat-feedback');

            const scrollToBottom = () => { container.scrollTop = container.scrollHeight; };
            scrollToBottom();

            input.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    document.getElementById('submit-btn').click();
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = input.value.trim();
                if (!message) return;

                // Verificamos si estamos en un ticket cerrado (por acción del backend o evento previo)
                // Si el input no está bloqueado, permitimos el envío.
                
                feedback.classList.remove('hidden');
                input.value = '';
                input.style.height = 'auto';

                // Inyectar localmente para feedback inmediato
                const html = `
                    <div class="flex justify-end fade-in">
                        <div class="max-w-[80%] sm:max-w-[70%] bg-gradient-to-br from-indigo-600 to-blue-700 text-white rounded-2xl rounded-tr-none p-4 shadow-lg relative">
                            <div class="flex items-center gap-2 mb-1.5 opacity-60 text-[9px] font-black uppercase tracking-widest">
                                <span>Tú</span>
                                <span>Ahora</span>
                            </div>
                            <div class="text-sm leading-relaxed whitespace-pre-wrap">${message}</div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
                scrollToBottom();

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(res => res.json())
                .then(data => {
                    // Si el servidor hizo un redirect (ej. al crear ticket), seguimos el redirect
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    if (data.status === 'success') {
                        // Si era un "nuevo ticket", recargamos para actualizar canales Echo
                        if (form.action.includes('create')) {
                            window.location.reload();
                        }
                    }
                })
                .finally(() => {
                    feedback.classList.add('hidden');
                });
            });

            // WebSockets - Escuchar todos los tickets del historial
            if (window.Echo) {
                @foreach($recentTickets as $ticket)
                    window.Echo.private(`chat.{{ $ticket->id }}`)
                        .listen('MessageSent', (e) => {
                            // Mostrar si no es nuestro O es un mensaje del sistema (user_id === null)
                                if (e.message.user_id === null || e.message.user_id !== {{ Auth::id() }}) {
                                    const isSystem = e.message.user_id === null;
                                    const isChoice = isSystem && e.message.message.includes('[DEVELO_AI_CHOICE]');
                                    
                                    let html = '';
                                    if (isChoice) {
                                        html = `
                                            <div class="flex justify-start animate-in fade-in slide-in-from-bottom-4 duration-300 my-4">
                                                <div class="max-w-[85%] bg-[#0B1120] border border-[#00f6ff]/30 rounded-2xl p-6 shadow-[0_0_30px_rgba(0,246,255,0.1)]">
                                                    <div class="flex items-center gap-3 mb-4">
                                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-400 to-blue-500 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-[#0B1120]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8Z"/><path d="M12 6a1 1 0 0 0-1 1v3H8a1 1 0 0 0 0 2h3v3a1 1 0 0 0 2 0v-3h3a1 1 0 0 0 0-2h-3V7a1 1 0 0 0-1-1Z"/></svg>
                                                        </div>
                                                        <h5 class="text-sm font-black text-white uppercase tracking-tighter">DeveloAI <span class="text-cyan-400">Assistant</span></h5>
                                                    </div>
                                                    <p class="text-sm text-slate-300 mb-6 leading-relaxed">
                                                        He recibido tu solicitud. ¿Cómo prefieres continuar la atención?
                                                    </p>
                                                    <div class="flex flex-col sm:flex-row gap-3">
                                                        <button onclick="selectHandler('ai')" class="flex-1 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-[#0B1120] font-black text-[10px] uppercase tracking-widest rounded-xl">Hablar con DeveloAI</button>
                                                        <button onclick="selectHandler('human')" class="flex-1 px-4 py-3 bg-[#1e293b] text-slate-300 border border-slate-700 font-bold text-[10px] uppercase tracking-widest rounded-xl">Esperar Asesor</button>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    } else {
                                        // Mensaje normal (IA o Humano)
                                        const isAi = e.message.user_id === null;
                                        
                                        // Solo usamos el estilo "centrado rosa" para mensajes muy cortos de sistema que no sean de la IA
                                        const isSystemStatus = isAi && e.message.message.length < 100 && 
                                                             (e.message.message.includes('Chat finalizado') || e.message.message.includes('Asignado a un asesor'));

                                        if (isSystemStatus) {
                                            html = `
                                                <div class="flex justify-center my-6 fade-in">
                                                    <span class="px-4 py-1.5 bg-rose-500/10 text-[9px] text-rose-400 rounded-full border border-rose-500/20 uppercase font-black tracking-widest italic text-center">
                                                        ${e.message.message}
                                                    </span>
                                                </div>
                                            `;
                                        } else {
                                            // Burbuja estilo Soporte (usamos el mismo color #1e293b para ambos)
                                            html = `
                                                <div class="flex justify-start fade-in mb-4">
                                                    <div class="max-w-[80%] sm:max-w-[70%] bg-[#1e293b] text-slate-200 border border-white/5 rounded-2xl rounded-tl-none p-4 relative shadow-lg">
                                                        <div class="flex items-center gap-2 mb-1.5 opacity-60 text-[9px] font-black uppercase tracking-widest">
                                                            <span class="${isAi ? 'text-cyan-400' : 'text-slate-400'}">${isAi ? 'DeveloAI' : 'Soporte'}</span>
                                                            <span>${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                                        </div>
                                                        <div class="text-sm leading-relaxed whitespace-pre-wrap">${e.message.message}</div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                    }
                                    container.insertAdjacentHTML('beforeend', html);
                                    scrollToBottom();
                                }
                            })
                        .listen('TicketStatusUpdated', (e) => {
                            if (['resolved', 'closed'].includes(e.status)) {
                                // En lugar de bloquear, preparamos para un nuevo ticket
                                form.action = "{{ route('portal.tickets.create') }}";
                                input.placeholder = "Inicia una nueva consulta...";
                                
                                const closedAlert = `
                                    <div class="flex justify-center my-6 fade-in">
                                        <span class="px-4 py-1.5 bg-rose-500/10 text-[9px] text-rose-400 rounded-full border border-rose-500/20 uppercase font-black tracking-widest italic text-center">
                                            Chat finalizado por soporte. Puedes escribir de nuevo para iniciar una nueva consulta.
                                        </span>
                                    </div>
                                `;
                                container.insertAdjacentHTML('beforeend', closedAlert);
                                scrollToBottom();
                            }
                        });
                @endforeach
            }
        });
    </script>
</x-app-layout>
