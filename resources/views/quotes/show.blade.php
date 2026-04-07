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
                    <form action="{{ route('quotes.send', $quote) }}" method="POST" class="confirm-form"
                          data-title="Enviar Cotización"
                          data-text="Se adjuntará el PDF al correo del destinatario."
                          data-confirm-text="Sí, enviar ahora"
                          data-icon="info">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Enviar Correo
                        </button>
                    </form>
                @endif

                <a href="{{ route('quotes.pdf', $quote) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#00f6ff]/10 border border-[#00f6ff]/30 text-[#00f6ff] hover:bg-[#00f6ff] hover:text-[#0B1120] rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Descargar PDF
                </a>

                <button onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700/50 border border-slate-600 text-slate-300 hover:border-white hover:text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Imprimir
                </button>

                <a href="{{ route('quotes.edit', $quote) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#0B1120] border border-[#1e293b] rounded-xl font-bold text-xs text-slate-300 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
                <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-rose-500/10 border border-rose-500/30 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-5xl mx-auto">
        <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] shadow-2xl overflow-hidden drop-shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <!-- Header of the Quote -->
            <div class="p-12 border-b border-[#1e293b] bg-gradient-to-r from-[#0f172a] to-[#1e293b]">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <img src="{{ asset('develotech-global.png') }}" class="h-12 w-auto mb-2" alt="Develotech Global">
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
                            {{ $quote->status_label }}
                        </span>
                        <p class="text-slate-400 text-xs mt-4 font-mono">{{ $quote->created_at->format('d M, Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-12 pt-8 border-t border-white/5">
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest mb-4 italic">Preparado para:</p>
                        @php
                            $isClient = $quote->quoteable_type === 'App\Models\Client';
                            $entityName = $isClient ? ($quote->quoteable->name ?? 'Nombre del Cliente') : ($quote->quoteable->company_name ?: $quote->quoteable->contact_name ?? 'Nombre del Prospecto');
                            $entityCompany = $isClient ? ($quote->quoteable->company ?? 'Empresa') : 'Prospecto Comercial';
                            $entityEmail = $quote->quoteable->email ?? '';
                        @endphp
                        <h3 class="text-xl font-black text-white leading-tight mb-1">{{ $entityName }}</h3>
                        <p class="text-slate-400 font-medium italic">{{ $entityCompany }}</p>
                        <p class="text-slate-500 text-sm mt-2">{{ $entityEmail }}</p>
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
                                <td class="py-6 text-right text-slate-300 font-medium">Q{{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-6 text-right text-white font-black">Q{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end pt-8 border-t-2 border-white/10">
                    <div class="w-full max-w-xs space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 text-sm font-medium">Subtotal</span>
                            <span class="text-white font-bold">Q{{ number_format($quote->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-lg">
                            <span class="text-slate-400 font-black uppercase tracking-tight">Total Final</span>
                            <span class="text-3xl font-black text-[#00f6ff] glow-cyan">Q{{ number_format($quote->total, 2) }}</span>
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
                    DEVELOTECH GLOBAL © {{ date('Y') }} - TODOS LOS DERECHOS RESERVADOS
                </div>
                <div class="flex gap-6">
                    <span class="text-[10px] font-black text-indigo-500 tracking-widest uppercase">Propuesta Confidencial</span>
                </div>
            </div>
        </div>

        @if(in_array($quote->status, ['draft', 'sent']))
            <div class="mt-8 flex justify-center gap-4 animate-fadeIn">
                <form action="{{ route('quotes.approve', $quote) }}" method="POST" class="confirm-form" 
                      data-title="Aprobar Cotización" 
                      data-text="Al aprobar, el registro se marcará como ganado. Si es un prospecto, se convertirá automáticamente a Cliente." 
                      data-confirm-text="Sí, aprobar" 
                      data-icon="success">
                    @csrf
                    <button type="submit" class="px-10 py-4 bg-emerald-500 hover:bg-emerald-600 text-[#0B1120] font-black rounded-2xl uppercase text-[10px] tracking-widest transition-all shadow-[0_0_25px_rgba(16,185,129,0.4)] hover:scale-105 active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Aprobar Cotización
                    </button>
                </form>
                <form action="{{ route('quotes.reject', $quote) }}" method="POST" class="confirm-form" 
                      data-title="Rechazar Cotización" 
                      data-text="Indica si el cliente ha rechazado esta propuesta comercial." 
                      data-confirm-text="Sí, rechazar" 
                      data-icon="error">
                    @csrf
                    <button type="submit" class="px-10 py-4 bg-rose-500/10 border border-rose-500/30 hover:bg-rose-500 text-rose-500 hover:text-white font-black rounded-2xl uppercase text-[10px] tracking-widest transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        Rechazar
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
