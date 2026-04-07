<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Pagos') }}
            </h2>
            <a href="{{ route('payments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Pago
            </a>
        </div>
    </x-slot>

    <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left bg-[#0B1120] border-b border-[#1e293b] uppercase text-xs font-bold text-slate-500 tracking-wider">
                        <th class="px-6 py-4">Factura</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Monto</th>
                        <th class="px-6 py-4">Método</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-[#1e293b]/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">{{ $payment->invoice->number ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $payment->invoice->client->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">Q{{ number_format($payment->amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $payment->payment_method }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-300">{{ $payment->paid_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    @can('ver pagos')
                                    <a href="{{ route('payments.show', $payment) }}" class="text-[#00f6ff] hover:text-white bg-[#00f6ff]/10 hover:bg-[#00f6ff]/20 px-2.5 py-1.5 rounded-lg border border-[#00f6ff]/20 transition-colors">
                                        Ver
                                    </a>
                                    @endcan
                                    @can('editar pagos')
                                    <a href="{{ route('payments.edit', $payment) }}" class="text-amber-400 hover:text-white bg-amber-400/10 hover:bg-amber-400/20 px-2.5 py-1.5 rounded-lg border border-amber-400/20 transition-colors">
                                        Editar
                                    </a>
                                    @endcan
                                    @can('eliminar pagos')
                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-white bg-rose-400/10 hover:bg-rose-400/20 px-2.5 py-1.5 rounded-lg border border-rose-400/20 transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-500">
                                No hay pagos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>