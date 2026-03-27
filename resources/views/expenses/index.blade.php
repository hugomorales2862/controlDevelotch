<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan flex items-center">
                <svg class="w-6 h-6 mr-2 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                {{ __('Egresos y Gastos Operativos') }}
            </h2>
            <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest bg-gradient-to-r from-rose-500 to-rose-700 hover:from-rose-400 hover:to-rose-600 shadow-[0_0_15px_rgba(244,63,94,0.3)] focus:outline-none transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Registrar Gasto
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(244,63,94,0.05)] border border-[#1e293b] overflow-hidden">
        


        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-[10px] font-bold text-slate-500 tracking-widest">
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Descripción del Gasto</th>
                        <th class="px-6 py-4">Monto</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4 text-sm font-medium text-slate-300">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-white">{{ $expense->description }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-rose-400">-${{ number_format($expense->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block delete-form">
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
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                                No hay gastos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($expenses->hasPages())
            <div class="px-6 py-4 border-t border-[#1e293b] bg-[#0B1120]">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
