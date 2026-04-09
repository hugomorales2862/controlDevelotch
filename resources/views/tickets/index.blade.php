<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ __('Centro de Soporte y Tickets') }}
            </h2>
            <a href="{{ route('tickets.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                + Abrir Ticket
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6" x-data="chatSystem()">
        <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl flex overflow-hidden shadow-2xl" style="height: calc(100vh - 200px);">
            
            <!-- Panel Izquierdo: Lista de Clientes -->
            <div class="w-1/3 border-r border-[#1e293b] flex flex-col bg-[#0B1120]">
                <div class="p-4 border-b border-[#1e293b] bg-[#0f172a]">
                    <input type="text" placeholder="Buscar cliente..." class="w-full bg-[#1e293b] border border-slate-700 rounded-xl text-sm text-slate-300 focus:border-[#00f6ff] placeholder:text-slate-500 py-2 px-4 shadow-inner" x-model="search">
                </div>
                
                <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
                    @forelse($clients as $client)
                        @php
                            $isActive = $activeClient && $activeClient->cli_id === $client->cli_id;
                            $latestTicket = $client->tickets->first();
                            $latestMsg = $latestTicket ? $latestTicket->messages->last() : null;
                            $statusColors = [
                                'new' => 'bg-indigo-500',
                                'open' => 'bg-[#00f6ff]',
                                'pending' => 'bg-amber-500',
                                'resolved' => 'bg-emerald-500',
                                'closed' => 'bg-slate-500',
                            ];
                            $statusColor = $latestTicket ? ($statusColors[$latestTicket->status] ?? 'bg-slate-500') : 'bg-slate-800';
                        @endphp
                        <a href="{{ route('tickets.index', ['client_id' => $client->cli_id]) }}" 
                           class="block p-4 border-b border-[#1e293b] hover:bg-[#1e293b]/50 transition-colors cursor-pointer {{ $isActive ? 'bg-[#1e293b]/80 border-l-4 border-l-[#00f6ff]' : '' }}"
                           id="client-list-item-{{ $client->cli_id }}"
                           x-show="search === '' || '{{ strtolower($client->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($client->company) }}'.includes(search.toLowerCase())">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-bold text-sm text-white truncate max-w-[70%]">
                                    {{ $client->name ?? $client->company }}
                                </h3>
                                <span class="text-[10px] text-slate-500">{{ $latestTicket ? $latestTicket->updated_at->format('H:i d/m') : '' }}</span>
                            </div>
                            <div class="text-xs text-slate-400 font-semibold mb-1 truncate">
                                {{ $client->company }}
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-[11px] text-slate-500 italic truncate flex-1">
                                    {{ $latestMsg ? Str::limit($latestMsg->message, 30) : 'Sin mensajes recientes' }}
                                </p>
                                <span class="w-2 h-2 rounded-full {{ $statusColor }} ml-2" title="Estado último ticket" id="status-dot-{{ $client->cli_id }}"></span>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-slate-500 italic text-sm">
                            No hay clientes con tickets.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Panel Derecho: Conversación Unificada -->
            <div class="w-2/3 flex flex-col relative bg-[#0f172a]">
                @if($activeClient)
                    @php
                        $latestActiveTicket = $activeClient->tickets->first();
                    @endphp
                    <!-- Header del Chat -->
                    <div class="p-4 border-b border-[#1e293b] flex justify-between items-center bg-[#0B1120] shrink-0 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#00f6ff]/5 to-transparent skew-x-12 translate-x-full"></div>
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-600 flex items-center justify-center text-slate-300 font-black text-sm relative">
                                {{ strtoupper(substr($activeClient->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-md">{{ $activeClient->name ?? $activeClient->company }}</h3>
                                <p class="text-xs text-[#00f6ff] opacity-80">{{ $activeClient->company }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 relative z-10">
                            @if($latestActiveTicket)
                                <span class="text-[10px] uppercase font-bold text-slate-500">Último Ticket: #{{ $latestActiveTicket->id }}</span>
                                <form action="{{ route('tickets.update', $latestActiveTicket) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="subject" value="{{ $latestActiveTicket->subject }}">
                                    <input type="hidden" name="description" value="{{ $latestActiveTicket->description }}">
                                    <input type="hidden" name="priority" value="{{ $latestActiveTicket->priority }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <select name="status" onchange="this.form.submit()" class="bg-[#1e293b] border-slate-700 text-xs text-white rounded-lg focus:ring-[#00f6ff] focus:border-[#00f6ff]">
                                        <option value="new" {{ $latestActiveTicket->status == 'new' ? 'selected' : '' }}>Nuevo</option>
                                        <option value="open" {{ $latestActiveTicket->status == 'open' ? 'selected' : '' }}>Abierto</option>
                                        <option value="pending" {{ $latestActiveTicket->status == 'pending' ? 'selected' : '' }}>En Espera</option>
                                        <option value="resolved" {{ $latestActiveTicket->status == 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                        <option value="closed" {{ $latestActiveTicket->status == 'closed' ? 'selected' : '' }}>Cerrado</option>
                                    </select>
                                </form>

                                <!-- Modo DeveloAI Toggle -->
                                <div class="flex items-center gap-2 bg-[#0B1120] border border-cyan-500/30 rounded-lg px-3 py-1 ml-2">
                                    <div class="w-2 h-2 rounded-full {{ $latestActiveTicket->handler_mode === 'ai' ? 'bg-cyan-400 animate-pulse' : 'bg-slate-500' }}"></div>
                                    <span class="text-[10px] font-bold text-white uppercase">{{ $latestActiveTicket->handler_mode === 'ai' ? 'DeveloAI Activo' : 'Manual' }}</span>
                                    @if($latestActiveTicket->handler_mode === 'ai')
                                        <button onclick="takeControl({{ $latestActiveTicket->id }})" class="text-[10px] bg-cyan-500 text-black px-2 py-0.5 rounded font-black hover:bg-cyan-400 transition-colors ml-1">TOMAR CONTROL</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mensajes de Chat (Unificados de todos los tickets) -->
                    <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent flex flex-col" style="background-image: radial-gradient(circle at center, rgba(30,41,59,0.3) 0, rgba(11,17,32,1) 100%);">
                        @php
                            // Unificar y ordenar todos los mensajes de todos los tickets del cliente
                            $allMessages = collect();
                            foreach($activeClient->tickets->reverse() as $ticket) {
                                foreach($ticket->messages as $msg) {
                                    $msg->context_ticket_id = $ticket->id;
                                    $allMessages->push($msg);
                                }
                            }
                            $lastTicketId = null;
                        @endphp

                        @foreach($allMessages->sortBy('created_at') as $msg)
                            @if($lastTicketId !== $msg->context_ticket_id)
                                <div class="flex justify-center my-4">
                                    <span class="px-3 py-1 bg-slate-800 text-[10px] text-slate-500 rounded-full border border-slate-700 uppercase font-bold tracking-widest">
                                        Ticket #{{ $msg->context_ticket_id }} - {{ $activeClient->tickets->find($msg->context_ticket_id)->subject }}
                                    </span>
                                </div>
                                @php $lastTicketId = $msg->context_ticket_id; @endphp
                            @endif

                            @php
                                $isAI = $msg->user_id === null && !str_contains($msg->message, 'finalizado');
                                $isAdmin = $msg->user_id !== null && $msg->user->hasRole(['admin', 'staff']);
                            @endphp
                            <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }} group fade-in">
                                <div class="max-w-[70%] {{ $isAdmin ? 'bg-indigo-600 text-white rounded-t-2xl rounded-bl-2xl rounded-br-sm' : 'bg-[#1e293b] text-slate-200 border border-slate-700/50 rounded-t-2xl rounded-br-2xl rounded-bl-sm' }} p-4 shadow-lg relative">
                                    <p class="text-sm leading-relaxed whitespace-pre-wrap {{ $isAI ? 'italic text-cyan-50' : '' }}">{{ $msg->message }}</p>
                                    <div class="text-[9px] font-black tracking-widest mt-2 flex justify-end gap-2 {{ $isAdmin ? 'text-indigo-200' : ($isAI ? 'text-cyan-400' : 'text-slate-500') }}">
                                        <span>{{ $isAdmin ? ($msg->user->name ?? 'Admin') : ($isAI ? 'DeveloAI' : ($activeClient->name ?? 'Cliente')) }}</span>
                                        <span>{{ $msg->created_at->format('H:i d/M') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Formulario Envío (Al último ticket abierto) -->
                    <div id="admin-reply-container" class="{{ ($latestActiveTicket && !in_array($latestActiveTicket->status, ['resolved', 'closed'])) ? '' : 'hidden' }} p-4 border-t border-[#1e293b] bg-[#0B1120] shrink-0">
                        <form id="chat-form" action="{{ route('tickets.add-message', $latestActiveTicket ?? 0) }}" method="POST" class="flex gap-4">
                            @csrf
                            <textarea id="message-input" name="message" rows="1" required placeholder="Responder..." class="flex-1 bg-[#1e293b] border-slate-700 focus:border-[#00f6ff] text-white rounded-xl resize-none py-3 px-4 shadow-inner text-sm max-h-32 transition-all"></textarea>
                            <button type="submit" id="submit-btn" class="w-14 h-14 shrink-0 rounded-xl bg-gradient-to-br from-[#00f2fe] to-[#4facfe] flex items-center justify-center text-[#0B1120] hover:scale-105 transition-transform shadow-lg shadow-cyan-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </form>
                    </div>

                    <div id="admin-closed-info" class="{{ ($latestActiveTicket && !in_array($latestActiveTicket->status, ['resolved', 'closed'])) ? 'hidden' : '' }} p-4 border-t border-[#1e293b] bg-[#0B1120] shrink-0 text-center">
                        <p class="text-xs text-slate-500 italic">El último ticket está resuelto o cerrado. El cliente no puede responder.</p>
                    </div>
                @else
                    <!-- Estado Vacío -->
                    <div class="flex-1 flex flex-col items-center justify-center text-slate-500 bg-[#0B1120]/50 relative overflow-hidden">
                        <div class="w-64 h-64 bg-[#00f6ff]/5 rounded-full blur-3xl absolute"></div>
                        <svg class="w-20 h-20 mb-6 text-slate-700 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <h2 class="text-xl font-bold text-slate-400 relative z-10">Selecciona un Cliente</h2>
                        <p class="text-sm relative z-10 mt-2">Haz clic en un cliente para ver su historial de soporte unificado.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Script de Alpine y Sockets -->
    <script>
        window.takeControl = function(ticketId) {
            fetch(`/portal/tickets/${ticketId}/select-handler`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ mode: 'human' })
            }).then(() => window.location.reload());
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('chatSystem', () => ({
                search: '',
                init() {
                    const activeClientId = {{ $activeClient ? $activeClient->cli_id : 'null' }};
                    
                    // WebSockets - Escuchar estado de tickets
                    if (window.Echo) {
                        window.Echo.private(`admin.tickets`)
                            .listen('TicketStatusUpdated', (e) => {
                                console.log('Admin status update:', e);
                                
                                // ¿El cliente existe en nuestra barra lateral?
                                const clientItem = document.getElementById(`client-list-item-${e.clientId}`);
                                
                                if(clientItem) {
                                    // Actualizar punto de estado en el panel izquierdo
                                    const dot = document.getElementById(`status-dot-${e.clientId}`);
                                    if(dot) {
                                        const colors = {
                                            'new': 'bg-indigo-500',
                                            'open': 'bg-[#00f6ff]',
                                            'pending': 'bg-amber-500',
                                            'resolved': 'bg-emerald-500',
                                            'closed': 'bg-slate-500'
                                        };
                                        dot.className = `w-2 h-2 rounded-full ${colors[e.status] || 'bg-slate-500'} ml-2`;
                                    }

                                    // Si es el cliente que tenemos abierto, actualizar formulario
                                    if(activeClientId && e.clientId == activeClientId) {
                                        // Si es un NUEVO ticket para el cliente activo, recargar para activar listeners del nuevo canal
                                        if (e.status === 'new') {
                                            window.location.reload();
                                            return;
                                        }

                                        const formContainer = document.getElementById('admin-reply-container');
                                        const infoContainer = document.getElementById('admin-closed-info');
                                        
                                        if(['resolved', 'closed'].includes(e.status)) {
                                            formContainer.classList.add('hidden');
                                            infoContainer.classList.remove('hidden');
                                        } else {
                                            formContainer.classList.remove('hidden');
                                            infoContainer.classList.add('hidden');
                                        }
                                    }
                                } else if (e.status === 'new') {
                                    // Si es un nuevo ticket de un cliente que NO está en la lista, refrescar para mostrarlo
                                    // Solo si el estado es 'new' (apertura) para evitar bucles innecesarios
                                    window.location.reload();
                                }
                            });
                    }

                    if (activeClientId) {
                        const container = document.getElementById('messages-container');
                        const scrollToBottom = () => { container.scrollTop = container.scrollHeight; };
                        scrollToBottom();

                        const input = document.getElementById('message-input');
                        if(input) {
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
                        }

                        // AJAX Envio
                        const form = document.getElementById('chat-form');
                        if(form) {
                            form.addEventListener('submit', function(e) {
                                e.preventDefault();
                                const message = input.value.trim();
                                if(!message) return;
                                
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
                                .then(res => res.json())
                                .then(data => {
                                    if(data.status === 'success') {
                                        const rawMsgDiv = document.createElement('div');
                                        rawMsgDiv.innerHTML = `
                                            <div class="flex justify-end group fade-in">
                                                <div class="max-w-[70%] bg-indigo-600 text-white rounded-t-2xl rounded-bl-2xl rounded-br-sm p-4 shadow-lg relative">
                                                    <p class="text-sm leading-relaxed whitespace-pre-wrap">${message}</p>
                                                    <div class="text-[9px] font-black tracking-widest mt-2 flex justify-end gap-2 text-indigo-200">
                                                        <span>{{ Auth::user()->name }}</span>
                                                        <span>Ahora</span>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                        container.appendChild(rawMsgDiv.firstElementChild);
                                        scrollToBottom();
                                    }
                                });
                            });
                        }

                        // Escuchar mensajes de todos los tickets del cliente activo
                        @if($activeClient)
                            @foreach($activeClient->tickets as $ticket)
                                if (window.Echo) {
                                    window.Echo.private(`chat.{{ $ticket->id }}`)
                                        .listen('MessageSent', (e) => {
                                            // Mostrar si no es nuestro O es un mensaje del sistema (user_id === null)
                                            if (e.message.user_id === null || e.message.user_id !== {{ Auth::id() }}) {
                                                const isAi = e.message.user_id === null && !e.message.message.includes('finalizado');
                                                const isSystem = e.message.user_id === null && !isAi;

                                                const htmlToAdd = `
                                                    <div class="flex ${isSystem ? 'justify-center' : 'justify-start'} group fade-in mb-4">
                                                        <div class="max-w-[70%] ${isSystem ? 'bg-slate-800 text-slate-400 border border-slate-700 text-[10px] uppercase font-bold tracking-widest px-3 py-1 rounded-full italic my-4' : 'bg-[#1e293b] text-slate-200 border border-slate-700/50 rounded-2xl rounded-tl-none p-4 shadow-lg'} relative">
                                                            <div class="${isSystem ? '' : 'flex flex-col'}">
                                                                <p class="${isSystem ? '' : 'text-sm leading-relaxed whitespace-pre-wrap ' + (isAi ? 'italic text-cyan-50' : '')}">${e.message.message}</p>
                                                                ${isSystem ? '' : `
                                                                    <div class="text-[9px] font-black tracking-widest mt-2 flex justify-end gap-2 ${isAi ? 'text-cyan-400' : 'text-slate-500'}">
                                                                        <span>${isAi ? 'DeveloAI' : (e.message.user ? e.message.user.name : 'Cliente')}</span>
                                                                        <span>Ahora</span>
                                                                    </div>
                                                                `}
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                                                container.insertAdjacentHTML('beforeend', htmlToAdd);
                                                scrollToBottom();
                                            }
                                        });
                                }
                            @endforeach
                        @endif
                    }
                }
            }));
        });
    </script>
</x-app-layout>
