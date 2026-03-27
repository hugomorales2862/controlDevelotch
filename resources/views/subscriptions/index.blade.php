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
                                <a href="{{ route('subscriptions.edit', $sub) }}" class="text-[10px] uppercase font-bold tracking-widest text-[#00f6ff] hover:text-white bg-[#00f6ff]/10 border border-[#00f6ff]/20 px-3 py-2 rounded-lg transition-colors inline-block opacity-0 group-hover:opacity-100">
                                    Administrar
                                </a>
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
