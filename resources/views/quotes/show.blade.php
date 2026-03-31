<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('quotes.index') }}" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="font-semibold text-2xl text-white tracking-tight">
                    {{ __('Cotización:') }} <span class="text-[#00f6ff]">{{ $quote->reference }}</span>
                </h2>
            </div>
            <div class="flex gap-3">
                @if($quote->status == 'draft')
                    <form action="{{ route('quotes.send', $quote) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                            Enviar Cliente
                        </button>
                    </form>
                @endif
                <a href="{{ route('quotes.edit', $quote) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B1120] border border-[#1e293b] rounded-xl font-bold text-xs text-slate-300 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all">
                    Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-5xl mx-auto">
        <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] shadow-2xl overflow-hidden drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <!-- Header of the Quote -->
            <div class="p-12 border-b border-[#1e293b] bg-gradient-to-r from-[#0f172a] to-[#1e293b]">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-4xl font-black text-white mb-2 tracking-tighter">DEVELOTECH <span class="text-[#00f6ff]">CORE</span></h1>
                        <p class="text-slate-500 text-sm font-medium italic">Soluciones Tecnológicas de Alto Impacto</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'draft' => 'bg-slate-500/10 text-slate-400',
                                'sent' => 'bg-indigo-500/10 text-indigo-400',
                                'approved' => 'bg-emerald-500/10 text-emerald-400',
                                'rejected' => 'bg-rose-500/10 text-rose-400',
                            ];
                        @endphp
                        <span class="px-4 py-1 text-[10px] uppercase font-black tracking-widest rounded-full border border-current {{ $statusColors[$quote->status] ?? 'text-white' }}">
                            {{ $quote->status }}
                        </span>
                        <p class="text-slate-400 text-xs mt-4 font-mono">{{ $quote->created_at->format('d M, Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-12 pt-8 border-t border-white/5">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest mb-4 italic">Preparado para:</p>
                        <h3 class="text-xl font-black text-white leading-tight mb-1">{{ $quote->client->name ?? 'Nombre del Cliente' }}</h3>
                        <p class="text-slate-400 font-medium italic">{{ $quote->client->company ?? 'Empresa' }}</p>
                        <p class="text-slate-500 text-sm mt-2">{{ $quote->client->email ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest mb-4 italic">Detalles de la Propuesta:</p>
                        <p class="text-white font-bold text-lg">{{ $quote->title }}</p>
                        <p class="text-rose-500 font-black text-sm mt-4">Válido hasta: {{ $quote->valid_until ? $quote->valid_until->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-12">
                @if($quote->description)
                    <div class="mb-12">
                        <h4 class="text-xs font-black text-[#00f6ff] uppercase tracking-widest mb-4 border-l-4 border-[#00f6ff] pl-4">Objetivo / Contexto</h4>
                        <p class="text-slate-300 leading-relaxed italic">{{ $quote->description }}</p>
                    </div>
                @endif

                <table class="min-w-full mb-12">
                    <thead>
                        <tr class="border-b border-[#1e293b]">
                            <th class="py-6 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Descripción del Servicio</th>
                            <th class="py-6 text-center text-[10px] font-black text-slate-500 uppercase tracking-widest">Cant.</th>
                            <th class="py-6 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Precio Unit.</th>
                            <th class="py-6 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($quote->items as $item)
                            <tr>
                                <td class="py-6 pr-8">
                                    <p class="text-white font-bold mb-1">{{ $item->service->name ?? 'Servicio Personalizado' }}</p>
                                    <p class="text-xs text-slate-500 leading-tight">{{ $item->description }}</p>
                                </td>
                                <td class="py-6 text-center text-slate-300 font-medium">{{ $item->quantity }}</td>
                                <td class="py-6 text-right text-slate-300 font-medium">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-6 text-right text-white font-black">${{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end pt-8 border-t-2 border-white/10">
                    <div class="w-full max-w-xs space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-sm font-medium">Subtotal</span>
                            <span class="text-white font-bold">${{ number_format($quote->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-slate-400 font-black uppercase tracking-tight">Total Final</span>
                            <span class="text-3xl font-black text-[#00f6ff] glow-cyan">${{ number_format($quote->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($quote->notes)
                    <div class="mt-20 pt-12 border-t border-[#1e293b]">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-6 italic">Términos y Condiciones / Notas Importantes</h4>
                        <div class="text-xs text-slate-500 leading-loose whitespace-pre-line bg-[#0B1120] p-8 rounded-2xl border border-white/5 font-mono italic">
                            {{ $quote->notes }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer for Branding -->
            <div class="p-12 bg-[#0B1120] flex justify-between items-center">
                <div class="text-[10px] uppercase font-bold text-slate-600 tracking-tighter">
                    DEVELOTECH CORE © {{ date('Y') }} - TODOS LOS DERECHOS RESERVADOS
                </div>
                <div class="flex gap-6">
                    <span class="text-[10px] font-black text-indigo-500 tracking-widest uppercase">Propuesta Confidencial</span>
                </div>
            </div>
        </div>

        @if($quote->status == 'sent')
            <div class="mt-8 flex justify-center gap-4">
                <form action="{{ route('quotes.approve', $quote) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-10 py-4 bg-emerald-500 hover:bg-emerald-600 text-[#0B1120] font-black rounded-2xl uppercase text-xs transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:scale-105 active:scale-95">
                        Aprobar Cotización
                    </button>
                </form>
                <form action="{{ route('quotes.reject', $quote) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-10 py-4 bg-rose-500/10 border border-rose-500/30 hover:bg-rose-500 text-rose-500 hover:text-white font-black rounded-2xl uppercase text-xs transition-all">
                        Rechazar
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
