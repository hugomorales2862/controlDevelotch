<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Control Financiero') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('categorias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition duration-150">
                    Gestionar Categorías
                </a>
                <a href="{{ route('transacciones.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition duration-150">
                    Registrar Movimiento
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Historial de Movimientos</h3>
                        <p class="text-sm text-gray-500">Listado de todos los ingresos y egresos de Velotech.</p>
                    </div>
                </div>
                
                <div class="p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500 tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Fecha</th>
                                <th class="px-6 py-4 text-left">Descripción / Categoría</th>
                                <th class="px-6 py-4 text-left">Monto</th>
                                <th class="px-6 py-4 text-left">Tipo</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($transacciones as $transaccion)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $transaccion->fecha->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $transaccion->descripcion }}</div>
                                        <div class="text-xs text-indigo-600 font-semibold">{{ $transaccion->categoria->nombre ?? 'Sin categoría' }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold {{ $transaccion->tipo == 'ingreso' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $transaccion->tipo == 'ingreso' ? '+' : '-' }} ${{ number_format($transaccion->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaccion->tipo == 'ingreso' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ ucfirst($transaccion->tipo) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('transacciones.edit', $transaccion) }}" class="text-amber-600 hover:text-amber-900 transition" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('transacciones.destroy', $transaccion) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este movimiento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-900 transition" title="Eliminar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No se han registrado movimientos financieros aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $transacciones->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
