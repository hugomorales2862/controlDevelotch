<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan flex items-center">
                <svg class="w-6 h-6 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('Ingresos Financieros') }}
            </h2>
            <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] shadow-glow-cyan focus:outline-none transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Registrar Ingreso
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        


        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-[10px] font-bold text-slate-500 tracking-widest">
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Cliente Referencia</th>
                        <th class="px-6 py-4">Concepto / Servicio</th>
                        <th class="px-6 py-4">Monto</th>
                        <th class="px-6 py-4">Vía de Pago</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4 text-sm font-medium text-slate-300">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-white">{{ $sale->client->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-300">
                                    @if($sale->service)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-widest bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20">
                                            {{ $sale->service->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-widest bg-slate-800 text-slate-300 border border-slate-700">
                                            Ingreso General
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-[#00f6ff] glow-cyan">${{ number_format($sale->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                {{ $sale->payment_method ?: 'Digital' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors text-[10px] uppercase tracking-widest font-bold">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                No hay ingresos registrados en el sistema
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sales->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
