<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Control de Pagos') }}
            </h2>
            <a href="{{ route('pagos.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg shadow-amber-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Registrar Pago
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Resumen de Pagos Pendientes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-white">
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 shadow-sm">
                    <p class="text-amber-50 text-xs font-bold uppercase tracking-wider">Pendientes de cobro</p>
                    <h3 class="text-3xl font-bold mt-1">
                        ${{ number_format($pagos->where('estado', 'pendiente')->sum('monto'), 2) }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl p-6 shadow-sm">
                    <p class="text-emerald-50 text-xs font-bold uppercase tracking-wider">Recaudado este mes</p>
                    <h3 class="text-3xl font-bold mt-1">
                        ${{ number_format($pagos->where('estado', 'pagado')->where('fecha_pago', '>=', now()->startOfMonth())->sum('monto'), 2) }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-rose-400 to-red-500 rounded-2xl p-6 shadow-sm">
                    <p class="text-rose-50 text-xs font-bold uppercase tracking-wider">Pagos Vencidos</p>
                    <h3 class="text-3xl font-bold mt-1">
                        {{ $pagos->where('estado', 'vencido')->count() }}
                    </h3>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Cliente / Servicio</th>
                                <th class="px-6 py-4 text-left">Monto</th>
                                <th class="px-6 py-4 text-left">Vencimiento</th>
                                <th class="px-6 py-4 text-left">Estado</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($pagos as $pago)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $pago->cliente->nombre }}</div>
                                        <div class="text-xs text-gray-500 font-medium">{{ $pago->servicio->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        ${{ number_format($pago->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm {{ $pago->estado == 'vencido' ? 'text-rose-600 font-bold' : 'text-gray-600' }}">
                                        {{ $pago->fecha_vencimiento->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $color = [
                                                'pagado' => 'bg-emerald-100 text-emerald-700',
                                                'pendiente' => 'bg-amber-100 text-amber-700',
                                                'vencido' => 'bg-rose-100 text-rose-700',
                                            ][$pago->estado] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                            {{ ucfirst($pago->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if($pago->comprobante)
                                                <a href="{{ Storage::url($pago->comprobante) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900" title="Ver Comprobante">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('pagos.edit', $pago) }}" class="text-amber-600 hover:text-amber-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No hay pagos registrados para este periodo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
