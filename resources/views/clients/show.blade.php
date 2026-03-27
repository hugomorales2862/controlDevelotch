<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Perfil del Cliente') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('clients.index') }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                <a href="{{ route('reports.index', ['client_id' => $client->id]) }}" class="text-sm font-bold text-[#0B1120] bg-emerald-400 hover:bg-emerald-300 border border-transparent px-4 py-2 rounded-lg shadow-[0_0_15px_rgba(52,211,153,0.3)] transition-all flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Historial de Pagos
                </a>
                <a href="{{ route('clients.edit', $client) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar Perfil</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Quick Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-[#1e293b]">
                <div class="flex items-center">
                    <div class="h-20 w-20 shrink-0 rounded-2xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold text-3xl border border-[#1e293b] shadow-glow-cyan">
                        {{ substr($client->name, 0, 1) }}
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-white glow-cyan">{{ $client->name }}</h1>
                        @if($client->company)
                            <p class="text-sm text-[#00f6ff] tracking-widest uppercase font-semibold flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $client->company }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-[#0B1120]/50 p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Correo Electrónico</p>
                    <p class="text-sm font-medium text-white"><a href="mailto:{{ $client->email }}" class="hover:text-[#00f6ff] transition-colors">{{ $client->email }}</a></p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Teléfono</p>
                    <p class="text-sm font-medium text-white">{{ $client->phone ?: 'No registrado' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Contacto Principal</p>
                    <p class="text-sm font-medium text-white">{{ $client->contact_name ?: 'Mismo' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Subscriptions -->
            <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden flex flex-col shadow-[0_0_20px_rgba(0,246,255,0.02)]">
                <div class="p-6 border-b border-[#1e293b] bg-[#0f172a] flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Suscripciones Activas
                    </h3>
                </div>
                <div class="p-0 flex-1 bg-[#0B1120]/20">
                    @forelse($client->subscriptions as $sub)
                        <div class="p-4 border-b border-[#1e293b] hover:bg-[#1e293b]/50 transition-colors flex justify-between items-center last:border-0">
                            <div>
                                <p class="font-bold text-white text-sm">{{ $sub->service->name }}</p>
                                <p class="text-xs text-slate-400 mt-1">Vence: {{ \Carbon\Carbon::parse($sub->end_date)->format('d M, Y') }}</p>
                            </div>
                            <span class="px-2.5 py-1 text-[10px] font-bold tracking-widest uppercase rounded-md border
                                @if($sub->status == 'active') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                @elseif($sub->status == 'suspended') bg-amber-500/10 text-amber-400 border-amber-500/20
                                @else bg-rose-500/10 text-rose-400 border-rose-500/20 @endif">
                                {{ $sub->status }}
                            </span>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-sm">
                            No hay suscripciones activas.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden flex flex-col shadow-[0_0_20px_rgba(0,246,255,0.02)]">
                <div class="p-6 border-b border-[#1e293b] bg-[#0f172a] flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Historial de Ventas
                    </h3>
                </div>
                <div class="p-0 flex-1 bg-[#0B1120]/20">
                    @forelse($client->sales as $sale)
                        <div class="p-4 border-b border-[#1e293b] hover:bg-[#1e293b]/50 transition-colors flex justify-between items-center last:border-0">
                            <div>
                                <p class="font-bold text-white text-sm">Pago: {{ $sale->service ? $sale->service->name : 'General' }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }} &middot; <span class="text-slate-500 font-medium">{{ $sale->payment_method ?: 'Digital' }}</span></p>
                            </div>
                            <span class="font-black text-[#00f6ff]">
                                ${{ number_format($sale->amount, 2) }}
                            </span>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500 text-sm">
                            No hay historial de ventas.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
