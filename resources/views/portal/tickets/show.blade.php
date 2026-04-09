<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('portal.tickets') }}" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    Chat de Soporte <span class="text-[#00f6ff]">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                </h2>
            </div>
            <div>
                @php
                    $statusStyles = [
                        'new' => 'text-indigo-400 bg-indigo-500/10 border-indigo-500/20',
                        'open' => 'text-[#00f6ff] bg-[#00f6ff]/10 border-[#00f6ff]/20',
                        'pending' => 'text-amber-500 bg-amber-500/10 border-amber-500/20',
                        'resolved' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                        'closed' => 'text-slate-500 bg-slate-500/10 border-slate-500/20',
                    ];
                @endphp
                <span class="px-4 py-1.5 rounded-full border {{ $statusStyles[$ticket->status] ?? '' }} font-black uppercase text-[10px] tracking-widest">
                    {{ $ticket->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-4xl mx-auto">
        <div class="space-y-6">
            
            <!-- Context Header -->
            <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#00f6ff]/5 rounded-bl-full blur-3xl"></div>
                <h1 class="text-lg font-black text-white mb-2 leading-tight italic">{{ $ticket->subject }}</h1>
                <p class="text-slate-400 text-xs leading-relaxed opacity-70 mb-4">{{ $ticket->description }}</p>
                <div class="flex items-center justify-between text-[10px] text-slate-500 uppercase font-black tracking-tighter">
                    <span>Iniciado: {{ $ticket->created_at->format('d M, Y H:i') }}</span>
                    <span>Prioridad: {{ $ticket->priority }}</span>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messages-container" class="space-y-4 max-h-[600px] overflow-y-auto px-2 pb-4 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
                @foreach($ticket->messages as $message)
                    @include('portal.tickets._message', ['message' => $message])
                @endforeach
            </div>

            <!-- Chat Feedback (typing/sending) -->
            <div id="chat-feedback" class="hidden text-[10px] text-cyan-400 italic px-4 font-bold animate-pulse">
                Enviando mensaje...
            </div>

            <!-- Reply Form -->
            <div id="reply-form-container" class="{{ in_array($ticket->status, ['resolved', 'closed']) ? 'hidden' : '' }}">
                <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] p-4 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#00f6ff] to-blue-600"></div>
                    <form id="chat-form" action="{{ route('portal.tickets.message', $ticket) }}" method="POST" class="relative z-10">
                        @csrf
                        <div class="flex gap-4">
                            <textarea id="message-input" name="message" rows="1" required
                                      class="flex-1 bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-100 text-sm py-4 px-6 transition-all resize-none overflow-hidden placeholder:italic"
                                      placeholder="Escribe tu respuesta aquí... (Shift+Enter para nueva línea)"></textarea>
                            
                            <button type="submit" id="submit-btn"
                                    class="w-14 h-14 bg-gradient-to-tr from-[#00f2fe] to-[#4facfe] rounded-2xl flex items-center justify-center text-[#0B1120] hover:shadow-[0_0_20px_rgba(0,246,255,0.4)] transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Closed Message -->
            <div id="closed-message" class="{{ in_array($ticket->status, ['resolved', 'closed']) ? '' : 'hidden' }} bg-[#0B1120]/50 border border-slate-700/50 rounded-2xl p-6 text-center">
                <p class="text-slate-400 text-sm italic">
                    <svg class="w-8 h-8 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Esta conversación ha finalizado. Si necesitas nueva asistencia, por favor inicia un nuevo chat de soporte.
                </p>
                <a href="{{ route('portal.tickets') }}" class="inline-block mt-4 text-[#00f6ff] text-xs font-black uppercase tracking-widest hover:underline">Volver a mis chats</a>
            </div>
        </div>
    </div>

    <!-- AJAX Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chat-form');
            const container = document.getElementById('messages-container');
            const input = document.getElementById('message-input');
            const feedback = document.getElementById('chat-feedback');

            const scrollToBottom = () => {
                container.scrollTop = container.scrollHeight;
            };
            scrollToBottom();

            input.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
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

                feedback.classList.remove('hidden');
                input.value = '';
                input.style.height = 'auto';

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
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        container.insertAdjacentHTML('beforeend', data.html);
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    feedback.classList.add('hidden');
                });
            });

            // Recibir mensajes en vivo del administrador
            if (window.Echo) {
                const channel = window.Echo.private(`chat.{{ $ticket->id }}`);
                
                channel.listen('MessageSent', (e) => {
                    // Evitar duplicar el mensaje si fue enviado por nosotros mismos 
                    if (e.message.user_id !== {{ Auth::id() }}) {
                        const html = e.html || `
                            <div class="flex justify-start animate-in fade-in slide-in-from-bottom-2 duration-300">
                                <div class="max-w-[85%] sm:max-w-[70%] rounded-2xl p-4 bg-[#1e293b] border border-white/5 text-slate-300">
                                    <div class="flex items-center gap-3 mb-1.5 opacity-80">
                                        <span class="text-[9px] font-black uppercase tracking-widest">Soporte</span>
                                        <span class="text-[8px] font-bold text-slate-500 italic">Ahora</span>
                                    </div>
                                    <div class="text-sm leading-relaxed whitespace-pre-wrap">${e.message.message}</div>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', html);
                        scrollToBottom();
                    }
                })
                .listen('TicketStatusUpdated', (e) => {
                    console.log('Status updated:', e.status);
                    if (['resolved', 'closed'].includes(e.status)) {
                        document.getElementById('reply-form-container').classList.add('hidden');
                        document.getElementById('closed-message').classList.remove('hidden');
                        
                        // Opcional: Mostrar notificación visual
                        if(window.Swal) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Chat Finalizado',
                                text: 'Esta conversación ha sido cerrada por el equipo de soporte.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
