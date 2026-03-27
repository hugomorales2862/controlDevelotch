<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan flex items-center print:hidden">
            <svg class="w-6 h-6 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            {{ __('Reportería Financiera y Operativa') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        
        <!-- Filter Form -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] p-6 print:hidden">
            <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 w-full">
                    <label class="block font-medium text-[10px] text-slate-400 uppercase tracking-widest mb-1">Filtrar por Cliente (Opcional)</label>
                    <select name="client_id" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold shadow-sm py-2 px-3 text-sm">
                        <option value="" class="bg-[#0B1120]">-- Todos los Clientes (Reporte Global) --</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" class="bg-[#0B1120]" {{ $clientId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 w-full relative">
                    <label class="block font-medium text-[10px] text-slate-400 uppercase tracking-widest mb-1">Fecha Desde (Opcional)</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-2 px-3 text-sm">
                </div>
                <div class="flex-1 w-full">
                    <label class="block font-medium text-[10px] text-slate-400 uppercase tracking-widest mb-1">Fecha Hasta (Opcional)</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-2 px-3 text-sm">
                </div>
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-[#00f6ff] text-[#0B1120] rounded-xl text-sm font-bold uppercase tracking-widest shadow-glow-cyan hover:bg-white transition-colors">
                    Filtrar Datos
                </button>
                <button type="button" onclick="window.print()" class="w-full md:w-auto px-6 py-2.5 bg-[#1e293b] text-white rounded-xl text-sm font-bold uppercase tracking-widest hover:border-glow-cyan border border-transparent transition-all">
                    Exportar / Imprimir
                </button>
            </form>
        </div>

        <div id="printable-report" class="space-y-6">
            <div class="bg-[#0B1120] p-6 rounded-2xl border border-[#1e293b] hidden print:block mb-4">
                @if($selectedClient)
                    <h1 class="text-2xl font-black text-white mb-1 tracking-widest">HISTORIAL DE PAGOS: {{ mb_strtoupper($selectedClient->name) }}</h1>
                @else
                    <h1 class="text-2xl font-black text-white mb-1 tracking-widest">REPORTE DEVELOTECH GLOBAL</h1>
                @endif
                @if($startDate && $endDate)
                    <p class="text-slate-400 text-sm font-bold">Estado de Cuenta: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                @elseif($startDate)
                    <p class="text-slate-400 text-sm font-bold">Estado de Cuenta: Desde {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} hasta la fecha actual</p>
                @elseif($endDate)
                    <p class="text-slate-400 text-sm font-bold">Estado de Cuenta: Histórico hasta el {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                @else
                    <p class="text-slate-400 text-sm font-bold text-[#00f6ff]">Estado de Cuenta: Histórico de Total de Pagos (Toda la Vida)</p>
                @endif
                <p class="text-slate-500 text-xs mt-1">Impreso el {{ now()->format('d/m/Y H:i') }} por {{ Auth::user()->name }}</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#0f172a] print:border-[#000] rounded-xl p-5 border border-[#1e293b] {{ $selectedClient ? 'col-span-4 md:col-span-4' : '' }}">
                    <h3 class="text-[10px] font-bold text-slate-500 tracking-widest uppercase mb-1">{{ $selectedClient ? 'Total Abonado por el Cliente' : 'Ventas Brutas' }}</h3>
                    <p class="text-2xl font-black text-emerald-400 print:text-black">${{ number_format($totalSales, 2) }}</p>
                </div>
                @if(!$selectedClient)
                    <div class="bg-[#0f172a] rounded-xl p-5 border border-[#1e293b] print:border-[#000]">
                        <h3 class="text-[10px] font-bold text-slate-500 tracking-widest uppercase mb-1">Gastos Módulo</h3>
                        <p class="text-2xl font-black text-rose-400 print:text-black">-${{ number_format($totalExpenses, 2) }}</p>
                    </div>
                    <div class="bg-[#0f172a] rounded-xl p-5 border border-[#00f6ff]/30 shadow-[0_0_15px_rgba(0,246,255,0.1)] print:border-[#000]">
                        <h3 class="text-[10px] font-bold text-[#00f6ff] print:text-black tracking-widest uppercase mb-1">Beneficio Neto</h3>
                        <p class="text-2xl font-black print:text-black {{ $netIncome >= 0 ? 'text-white' : 'text-rose-400' }}">${{ number_format($netIncome, 2) }}</p>
                    </div>
                    <div class="bg-[#0f172a] rounded-xl p-5 border border-[#1e293b] print:border-[#000]">
                        <h3 class="text-[10px] font-bold text-slate-500 tracking-widest uppercase mb-1">Captación (Nuevos Clientes)</h3>
                        <p class="text-2xl font-black text-white print:text-black">{{ $newClients }}</p>
                    </div>
                @endif
            </div>

            <!-- Tables Side by Side -->
            <div class="grid grid-cols-1 {{ $selectedClient ? '' : 'lg:grid-cols-2' }} gap-6 print:block">
                
                <!-- Ingresos -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] print:border-transparent print:border-b-0 overflow-hidden print:mb-8">
                    <div class="p-5 border-b border-[#1e293b] print:border-[#000] print:border-b-2">
                        <h3 class="text-sm font-bold text-emerald-400 print:text-black uppercase tracking-widest">Detalle de Pagos / Ventas Registradas</h3>
                    </div>
                    <div class="overflow-x-auto max-h-[500px] print:max-h-none print:overflow-visible">
                        <table class="w-full whitespace-nowrap text-left">
                            <thead class="bg-[#0B1120] print:bg-slate-100 text-[10px] uppercase tracking-widest text-slate-500 print:text-black sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Fecha de Pago</th>
                                    @if(!$selectedClient)<th class="px-4 py-3">Cliente</th>@endif
                                    <th class="px-4 py-3">Plan / Concepto</th>
                                    <th class="px-4 py-3 text-right">Monto Depositado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1e293b] print:divide-slate-300">
                                @forelse($sales as $sale)
                                    <tr class="hover:bg-[#1e293b]/30 print:hover:bg-transparent">
                                        <td class="px-4 py-3 text-xs text-slate-300 print:text-black">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                                        @if(!$selectedClient)
                                            <td class="px-4 py-3">
                                                <p class="text-sm font-bold text-white print:text-black">{{ $sale->client->name }}</p>
                                            </td>
                                        @endif
                                        <td class="px-4 py-3">
                                            <p class="text-[10px] font-bold text-slate-400 print:text-black uppercase tracking-widest">{{ $sale->service ? $sale->service->name : 'Pago General (Sin Producto)' }}</p>
                                            <p class="text-[9px] text-slate-500 print:text-black font-semibold">{{ $sale->payment_method }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-bold text-emerald-400 print:text-black">
                                            ${{ number_format($sale->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $selectedClient ? '3' : '4' }}" class="px-4 py-8 text-center text-xs text-slate-500 print:text-black">No se encontraron pagos registrados en este periodo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(!$selectedClient)
                <!-- Egresos -->
                <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] print:border-transparent print:border-b-0 overflow-hidden">
                    <div class="p-5 border-b border-[#1e293b] print:border-[#000] print:border-b-2">
                        <h3 class="text-sm font-bold text-rose-400 print:text-black uppercase tracking-widest">Detalle de Egresos / Gastos</h3>
                    </div>
                    <div class="overflow-x-auto max-h-[500px] print:max-h-none print:overflow-visible">
                        <table class="w-full whitespace-nowrap text-left">
                            <thead class="bg-[#0B1120] print:bg-slate-100 text-[10px] uppercase tracking-widest text-slate-500 print:text-black sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Fecha de Corte</th>
                                    <th class="px-4 py-3">Motivo del Egreso</th>
                                    <th class="px-4 py-3 text-right">Efectivo Descontado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1e293b] print:divide-slate-300">
                                @forelse($expenses as $expense)
                                    <tr class="hover:bg-[#1e293b]/30 print:hover:bg-transparent">
                                        <td class="px-4 py-3 text-xs text-slate-300 print:text-black">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            <p class="text-sm font-bold text-white print:text-black">{{ $expense->description }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-bold text-rose-400 print:text-black">
                                            -${{ number_format($expense->amount, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-xs text-slate-500 print:text-black">No se encontraron gastos en el margen de tiempo provisto.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>
    
    <style>
        @media print {
            body { background-color: white !important; color: black !important; }
            .bg-\\[\\#0B1120\\] { background: transparent !important; }
            .bg-\\[\\#0f172a\\] { background: transparent !important; }
            .text-white { color: black !important; }
            .border-\\[\\#1e293b\\] { border-color: transparent !important; }
            aside { display: none !important; }
            header { display: none !important; }
            .md\\:ml-64 { margin-left: 0 !important; }
            * { text-shadow: none !important; box-shadow: none !important; }
            .print\\:hidden { display: none !important; }
            .print\\:block { display: block !important; }
            .print\\:border-\\[\\#000\\] { border-color: #000 !important; }
            .print\\:border-transparent { border-color: transparent !important; }
            .print\\:text-black { color: #000 !important; }
            .print\\:bg-slate-100 { background-color: #f1f5f9 !important; }
            .print\\:overflow-visible { overflow: visible !important; }
        }
    </style>
</x-app-layout>
