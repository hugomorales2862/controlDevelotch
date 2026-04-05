<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Detalle del Prospecto') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('prospects.index') }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                
                @if($prospect->status != 'won' && $prospect->status != 'converted')
                    <form action="{{ route('prospects.convert', $prospect) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-[#0B1120] bg-emerald-400 hover:bg-emerald-300 border border-transparent px-4 py-2 rounded-lg shadow-[0_0_15px_rgba(52,211,153,0.3)] transition-all flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Convertir a Cliente
                        </button>
                    </form>
                @endif

                <a href="{{ route('prospects.edit', $prospect) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar Prospecto</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Quick Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-[#1e293b]">
                <div class="flex items-center">
                    <div class="h-20 w-20 shrink-0 rounded-2xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold text-3xl border border-[#1e293b] shadow-glow-cyan">
                        {{ substr($prospect->company_name ?: $prospect->contact_name, 0, 1) }}
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-white glow-cyan">{{ $prospect->company_name ?: 'Sin Empresa' }}</h1>
                        <p class="text-sm text-[#00f6ff] tracking-widest uppercase font-semibold flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $prospect->contact_name }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0">
                    @php
                        $statusStyles = [
                            'new' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                            'contacted' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                            'qualified' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                            'proposal' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
                            'lost' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                            'won' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'converted' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                        ];
                        $statusLabels = [
                            'new' => 'Nuevo Prospecto',
                            'contacted' => 'Contactado',
                            'qualified' => 'Calificado',
                            'proposal' => 'En Propuesta',
                            'lost' => 'Perdido',
                            'won' => 'Ganado / Cliente',
                            'converted' => 'Convertido a Cliente',
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-xl border text-xs font-black uppercase tracking-widest {{ $statusStyles[$prospect->status] ?? $statusStyles['new'] }}">
                        {{ $statusLabels[$prospect->status] ?? $prospect->status }}
                    </span>
                </div>
            </div>
            <div class="bg-[#0B1120]/50 p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Correo Electrónico</p>
                    <p class="text-sm font-medium text-white"><a href="mailto:{{ $prospect->email }}" class="hover:text-[#00f6ff] transition-colors">{{ $prospect->email }}</a></p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Teléfono</p>
                    <p class="text-sm font-medium text-white">{{ $prospect->phone ?: 'No registrado' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Industria</p>
                    <p class="text-sm font-medium text-white">{{ $prospect->industry ?: 'No especificada' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Sitio Web</p>
                    <p class="text-sm font-medium text-white">
                        @if($prospect->website)
                            <a href="{{ $prospect->website }}" target="_blank" class="text-[#00f6ff] hover:underline">{{ $prospect->website }}</a>
                        @else
                            No registrado
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Details & Address -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ubicación y Notas
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Dirección Física</p>
                            <p class="text-sm text-slate-300 leading-relaxed">
                                {{ $prospect->address ?: 'Sin dirección' }}<br>
                                {{ $prospect->city }}, {{ $prospect->country }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Notas Internas</p>
                            <p class="text-sm text-slate-300 italic">
                                {{ $prospect->notes ?: 'Sin notas adicionales.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quotes History -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-[#1e293b] flex justify-between items-center bg-[#1e293b]/20">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Cotizaciones Enviadas
                        </h3>
                        <a href="{{ route('quotes.create', ['quoteable_type' => 'App\Models\Prospect', 'quoteable_id' => $prospect->id]) }}" class="text-xs font-black text-[#00f6ff] hover:text-white uppercase tracking-widest mt-1 group-hover:glow-cyan transition-all">+ Nueva Cotización</a>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#1e293b]">
                            <thead class="bg-[#0B1120]/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Referencia</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Título</th>
                                    <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-500 uppercase tracking-widest">Total</th>
                                    <th class="px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">Estado</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1e293b]">
                                @forelse($prospect->quotes as $quote)
                                    <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap text-xs font-black text-[#00f6ff]">{{ $quote->reference }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $quote->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-white">Q{{ number_format($quote->total, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $qStyles = [
                                                    'draft' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                                    'sent' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                    'approved' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                    'rejected' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                                ];
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase border {{ $qStyles[$quote->status] ?? 'bg-slate-500/10' }}">
                                                {{ $quote->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('quotes.show', $quote) }}" class="text-slate-400 hover:text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 text-xs italic">No hay cotizaciones registradas para este prospecto.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Meta Data Sidebar -->
            <div class="space-y-6">
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-6 shadow-xl">
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Información de Sistema</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Registrado el</p>
                            <p class="text-xs text-white">{{ $prospect->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Última actualización</p>
                            <p class="text-xs text-white">{{ $prospect->updated_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Registrado por</p>
                            <p class="text-xs text-white">{{ $prospect->creator->name ?? 'Sistema' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
