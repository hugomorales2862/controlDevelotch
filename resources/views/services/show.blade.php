<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('services.index') }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    Plan: <span class="text-[#00f6ff] glow-cyan">{{ $service->name }}</span>
                </h2>
            </div>
            <div class="flex items-center gap-3">
                @can('editar servicios')
                <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#00f6ff]/40 rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all duration-300">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar Plan
                </a>
                @endcan
                @can('eliminar servicios')
                <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline-block delete-form">
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

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Info card + stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Plan details --}}
            <div class="md:col-span-2 bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-[0_0_20px_rgba(0,246,255,0.05)] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120] flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Información del Plan</span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">#{{ $service->id }}</span>
                </div>
                <div class="p-6 space-y-4">
                    {{-- App --}}
                    <div class="flex items-start justify-between py-3 border-b border-[#1e293b]/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Aplicación Base</span>
                        <span class="text-sm font-bold text-white">{{ $service->application->name ?? '—' }}</span>
                    </div>
                    {{-- Type --}}
                    <div class="flex items-start justify-between py-3 border-b border-[#1e293b]/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Tipo de Servicio</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20">
                            {{ ucfirst($service->type ?? 'otro') }}
                        </span>
                    </div>
                    {{-- Billing cycle --}}
                    <div class="flex items-start justify-between py-3 border-b border-[#1e293b]/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ciclo de Facturación</span>
                        @php
                            $cycles = ['weekly'=>'Semanal','monthly'=>'Mensual','yearly'=>'Anual','triennial'=>'Trienal'];
                        @endphp
                        <span class="text-sm font-bold text-slate-300">{{ $cycles[$service->billing_cycle] ?? 'No definido' }}</span>
                    </div>
                    {{-- Duration --}}
                    <div class="flex items-start justify-between py-3 border-b border-[#1e293b]/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Duración</span>
                        <span class="text-sm font-bold text-slate-300">{{ $service->duration_days }} días</span>
                    </div>
                    {{-- Description --}}
                    @if($service->description)
                    <div class="py-3 border-b border-[#1e293b]/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest block mb-2">Descripción</span>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $service->description }}</p>
                    </div>
                    @endif
                    {{-- Timestamps --}}
                    <div class="flex items-center justify-between pt-2 text-[10px] text-slate-600">
                        <span>Creado: {{ $service->created_at->format('d/m/Y') }}</span>
                        <span>Actualizado: {{ $service->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Price + stats --}}
            <div class="space-y-4">
                {{-- Price --}}
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] shadow-[0_0_20px_rgba(0,246,255,0.08)] p-6 text-center">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Precio del Plan</p>
                    <p class="text-4xl font-black text-[#00f6ff] glow-cyan">Q{{ number_format($service->price, 2) }}</p>
                    <p class="text-[10px] text-slate-500 mt-1">/ {{ $service->duration_days }} días</p>
                </div>
                {{-- Active subs count --}}
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 text-center">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2">Suscriptores Activos</p>
                    <p class="text-3xl font-black text-emerald-400">
                        {{ $service->subscriptions->where('status', 'active')->count() }}
                    </p>
                    <p class="text-[10px] text-slate-600 mt-1">de {{ $service->subscriptions->count() }} total</p>
                </div>
            </div>
        </div>

        {{-- Features --}}
        @if($service->features)
        <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120]">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Características del Plan</span>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach(explode("\n", $service->features) as $feature)
                    @if(trim($feature))
                    <div class="flex items-center gap-3">
                        <div class="shrink-0 w-5 h-5 rounded-full bg-[#00f6ff]/10 border border-[#00f6ff]/20 flex items-center justify-center">
                            <svg class="w-3 h-3 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm text-slate-300">{{ trim($feature) }}</span>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Subscriptions list --}}
        @if($service->subscriptions->count() > 0)
        <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#1e293b] bg-[#0B1120]">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Clientes Suscritos a este Plan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-[#1e293b] text-[10px] font-bold uppercase tracking-widest text-slate-600">
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Inicio</th>
                            <th class="px-6 py-3">Vencimiento</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1e293b]">
                        @foreach($service->subscriptions as $sub)
                        <tr class="hover:bg-[#1e293b]/30 transition-colors">
                            <td class="px-6 py-3">
                                <div class="text-sm font-bold text-white">{{ $sub->client->name ?? '—' }}</div>
                                <div class="text-xs text-slate-500">{{ $sub->client->company ?? '' }}</div>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $sc = ['active'=>'bg-emerald-500/10 text-emerald-400 border-emerald-500/20','suspended'=>'bg-amber-500/10 text-amber-400 border-amber-500/20','canceled'=>'bg-rose-500/10 text-rose-400 border-rose-500/20'];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border {{ $sc[$sub->status] ?? $sc['canceled'] }}">
                                    {{ $sub->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-xs text-slate-400">{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                @php $end = \Carbon\Carbon::parse($sub->end_date); $expired = $end->isPast(); @endphp
                                <span class="text-xs font-bold {{ $expired ? 'text-rose-400' : 'text-slate-300' }}">
                                    {{ $end->format('d/m/Y') }}
                                </span>
                                <span class="text-[10px] text-slate-600 block">{{ $end->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
