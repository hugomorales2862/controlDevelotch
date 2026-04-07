<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Suscripciones Activas') }}
            </h2>
            <a href="{{ route('subscriptions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Asignar Suscripción
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-[10px] font-bold text-slate-500 tracking-widest">
                        <th class="px-6 py-4">Suscripción</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Vencimiento</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($subscriptions as $sub)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-white mb-0.5 glow-cyan">{{ $sub->client->name }}</div>
                                <div class="text-xs text-[#00f6ff]">{{ $sub->service->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-widest
                                    @if($sub->status == 'active') bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20
                                    @elseif($sub->status == 'suspended') bg-amber-500/10 text-amber-400 border border-amber-500/20
                                    @else bg-rose-500/10 text-rose-400 border border-rose-500/20 @endif">
                                    {{ $sub->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $endDate = \Carbon\Carbon::parse($sub->end_date);
                                    $isExpired = $endDate->isPast();
                                    $isSoon = $endDate->diffInDays(now()) <= 7 && !$isExpired;
                                    
                                    $colorClass = $isExpired ? 'text-rose-400' : ($isSoon ? 'text-amber-400' : 'text-slate-300');
                                @endphp
                                <div class="text-sm font-bold {{ $colorClass }}">
                                    {{ $endDate->format('d/m/Y') }}
                                </div>
                                <div class="text-[10px] mt-1 font-semibold uppercase tracking-widest {{ $isExpired ? 'text-rose-500' : ($isSoon ? 'text-amber-500' : 'text-slate-500') }}">
                                    {{ $endDate->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    @can('ver suscripciones')
                                    <a href="{{ route('subscriptions.show', $sub) }}" class="text-[#00f6ff] hover:text-white bg-[#00f6ff]/10 hover:bg-[#00f6ff]/20 px-2.5 py-1.5 rounded-lg border border-[#00f6ff]/20 transition-colors" title="Ver Detalles">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('editar suscripciones')
                                    <a href="{{ route('subscriptions.edit', $sub) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors" title="Editar">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('eliminar suscripciones')
                                    <form action="{{ route('subscriptions.destroy', $sub) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors" title="Eliminar">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500 text-xs uppercase tracking-widest font-bold">
                                No tienes suscripciones registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($subscriptions->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
