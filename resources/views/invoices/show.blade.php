<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight">{{ __('Comprobante de Pago') }} #{{ $invoice->invoice_number }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 border border-slate-500 text-slate-300 rounded-lg hover:bg-slate-700">Volver</a>
                <a href="{{ route('invoices.edit', $invoice) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Editar</a>
                <a href="{{ route('invoices.pdf', $invoice) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">Descargar PDF</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl shadow-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-slate-400 uppercase text-xs tracking-widest">Cliente</p>
                        <h3 class="text-white font-bold">{{ $invoice->client->name ?? '-' }}</h3>
                        <p class="text-slate-400 text-sm">{{ $invoice->client->company ?? '-' }}</p>
                        <p class="text-slate-400 text-sm">{{ $invoice->client->email ?? '' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 uppercase text-xs tracking-widest">Comprobante</p>
                        <p class="text-white font-black text-lg">{{ $invoice->invoice_number }}</p>
                        <p class="text-slate-400 text-sm">Emitido: {{ $invoice->issue_date->format('d/m/Y') }}</p>
                        <p class="text-slate-400 text-sm">Vence: {{ $invoice->due_date->format('d/m/Y') }}</p>
                        <p class="text-slate-400 text-sm">Estado: <span class="font-bold text-white">{{ $invoice->status_label }}</span></p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-xs text-slate-400 uppercase">Descripción</th>
                                <th class="px-4 py-2 text-xs text-slate-400 uppercase">Cant.</th>
                                <th class="px-4 py-2 text-xs text-slate-400 uppercase">Precio Unit.</th>
                                <th class="px-4 py-2 text-xs text-slate-400 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-200">
                            @foreach($invoice->items as $item)
                                <tr class="border-t border-[#1e293b]">
                                    <td class="px-4 py-2">{{ $item['description'] ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $item['quantity'] ?? 0 }}</td>
                                    <td class="px-4 py-2">Q{{ number_format($item['unit_price'] ?? 0, 2) }}</td>
                                    <td class="px-4 py-2">Q{{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-[#111827] p-4 rounded-lg">
                        <h4 class="text-slate-400 uppercase text-xs tracking-wider">Notas</h4>
                        <p class="text-slate-200 text-sm">{{ $invoice->notes ?? 'Sin notas' }}</p>
                    </div>
                    <div class="p-4 rounded-lg border border-[#1e293b]">
                        <div class="space-y-2 text-right">
                            <div class="text-slate-400 text-sm">Sub-Total: <span class="text-white font-bold">Q{{ number_format($invoice->sub_total, 2) }}</span></div>
                            <div class="text-slate-400 text-sm">IVA ({{ number_format($invoice->tax_rate, 2) }}%): <span class="text-white font-bold">Q{{ number_format($invoice->tax, 2) }}</span></div>
                            <div class="text-slate-400 text-sm">Descuento: <span class="text-white font-bold">Q{{ number_format($invoice->discount, 2) }}</span></div>
                            <div class="text-white font-black text-xl">Total: Q{{ number_format($invoice->total, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
