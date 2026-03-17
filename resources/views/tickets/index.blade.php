<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Tickets de Soporte') }}
            </h2>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-rose-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-700 transition duration-150 shadow-lg shadow-rose-200">
                Nuevo Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-left">Asunto / Cliente</th>
                            <th class="px-6 py-4 text-left">Estado</th>
                            <th class="px-6 py-4 text-left">Prioridad</th>
                            <th class="px-6 py-4 text-left">Fecha</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $ticket->asunto }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->cliente->nombre }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = [
                                            'abierto' => 'bg-blue-100 text-blue-700',
                                            'en_proceso' => 'bg-amber-100 text-amber-700',
                                            'cerrado' => 'bg-gray-100 text-gray-700',
                                        ][$ticket->estado] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $priorityColor = [
                                            'baja' => 'text-gray-600',
                                            'media' => 'text-amber-600 font-bold',
                                            'alta' => 'text-rose-600 font-bold',
                                        ][$ticket->prioridad] ?? 'text-gray-600';
                                    @endphp
                                    <span class="text-xs uppercase tracking-wider {{ $priorityColor }}">
                                        {{ ucfirst($ticket->prioridad) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $ticket->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-xs tracking-widest">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No hay tickets de soporte abiertos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
