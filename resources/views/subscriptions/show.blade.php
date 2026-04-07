<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('subscriptions.index') }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    Detalles de la <span class="text-[#00f6ff] glow-cyan">Suscripción</span>
                </h2>
            </div>
            <div class="flex items-center gap-3">
                @can('editar suscripciones')
                <a href="{{ route('subscriptions.edit', $subscription) }}" class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff]/40 rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Administrar
                </a>
                @endcan
                @can('eliminar suscripciones')
                <form action="{{ route('subscriptions.destroy', $subscription) }}" method="POST" class="inline-block delete-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-500/10 border border-rose-500/30 rounded-xl font-bold text-xs text-rose-400 uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all duration-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6 pb-12">

        {{-- Main Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Client Card --}}
            <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-xl overflow-hidden group">
                <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120] flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#00f6ff]">Información del Cliente</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-1 group-hover:glow-cyan transition-all">{{ $subscription->client->name ?? '—' }}</h3>
                    <p class="text-sm text-slate-400 mb-6">{{ $subscription->client->company ?? 'Particular' }}</p>
                    
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-slate-300">
                            <svg class="w-4 h-4 mr-3 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $subscription->client->email ?? 'Sin correo' }}
                        </div>
                        <div class="flex items-center text-sm text-slate-300">
                            <svg class="w-4 h-4 mr-3 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $subscription->client->phone ?? 'Sin teléfono' }}
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('clients.show', $subscription->client_id) }}" class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-[#00f6ff] hover:text-white transition-colors">
                            Ver Expediente Completo
                            <svg class="w-3 h-3 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Service Card --}}
            <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-xl overflow-hidden group">
                <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120] flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#00f6ff]">Servicio Contratado</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-1 group-hover:glow-cyan transition-all">{{ $subscription->service->name ?? '—' }}</h3>
                    <p class="text-sm text-[#00f6ff] font-bold mb-6">Q{{ number_format($subscription->service->price ?? 0, 2) }} / {{ $subscription->service->duration_days ?? 0 }} días</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-[#0B1120]/50 p-3 rounded-xl border border-[#1e293b]">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ciclo de Cobro</span>
                            <span class="text-sm font-black text-white uppercase">{{ $subscription->billing_cycle ?? 'Mensual' }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-[#0B1120]/50 p-3 rounded-xl border border-[#1e293b]">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</span>
                            @php
                                $statusStyles = [
                                    'active' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'suspended' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'canceled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                ];
                                $currentStatus = $subscription->status ?? 'canceled';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusStyles[$currentStatus] ?? $statusStyles['canceled'] }}">
                                {{ $currentStatus }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dates & Progress --}}
        <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-xl overflow-hidden">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Control de Vigencia</span>
                            @php
                                $start = \Carbon\Carbon::parse($subscription->start_date);
                                $end = \Carbon\Carbon::parse($subscription->end_date);
                                $total = $start->diffInDays($end) ?: 1;
                                $passed = $start->diffInDays(now(), false);
                                $progress = ($passed > 0) ? min(100, round(($passed / $total) * 100)) : 0;
                                $expired = $end->isPast();
                            @endphp
                            <span class="text-xs font-black {{ $expired ? 'text-rose-500' : 'text-[#00f6ff]' }}">{{ $progress }}% Completado</span>
                        </div>
                        <div class="w-full bg-[#0B1120] rounded-full h-3 border border-[#1e293b] overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] shadow-[0_0_10px_rgba(0,246,255,0.3)] transition-all duration-1000" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500">
                            <span>Desde: {{ $start->format('d/m/Y') }}</span>
                            <span>Hasta: {{ $end->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <div class="text-center p-6 bg-[#0B1120] rounded-2xl border border-[#1e293b] w-full">
                            @if($expired)
                                <p class="text-[10px] font-bold uppercase tracking-widest text-rose-500 mb-1">Servicio Vencido</p>
                                <p class="text-2xl font-black text-rose-400">Hace {{ $end->diffForHumans() }}</p>
                            @else
                                <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 mb-1">Tiempo Restante</p>
                                <p class="text-2xl font-black text-[#00f6ff] glow-cyan">Faltan {{ now()->diffInDays($end) }} Días</p>
                                <p class="text-[10px] text-slate-500 mt-1 italic">Vence el {{ $end->isoFormat('LL') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features of the service --}}
        @if($subscription->service && $subscription->service->features)
        <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120]">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 text-center block">Especificaciones del Plan Adquirido</span>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach(explode("\n", $subscription->service->features) as $feature)
                    @if(trim($feature))
                        <div class="flex items-center p-4 bg-[#0B1120]/30 rounded-xl border border-[#1e293b] hover:border-[#00f6ff]/30 transition-colors">
                            <svg class="w-4 h-4 text-[#00f6ff] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-slate-300 font-medium">{{ trim($feature) }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
