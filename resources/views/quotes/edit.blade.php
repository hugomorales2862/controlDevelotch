<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Gestionar Cotización:') }} <span class="text-[#00f6ff]">{{ $quote->reference }}</span>
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4" x-data="quoteForm()">
        <form method="POST" action="{{ route('quotes.update', $quote) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Data -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Título de la Propuesta</label>
                                <input id="title" name="title" type="text" value="{{ old('title', $quote->title) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring rounded-xl text-white py-4 px-5 transition-all">
                                <x-input-error :messages="$errors->get('title')" class="mt-2 text-rose-400" />
                            </div>

                            <!-- Client -->
                            <div>
                                <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Cliente Destinatario</label>
                                <select id="client_id" name="client_id" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all">
                                    @foreach($clients as $client)
                                        <option value="{{ $client->cli_id }}" {{ old('client_id', $quote->client_id) == $client->cli_id ? 'selected' : '' }}>
                                            {{ $client->name }} ({{ $client->company }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estado Actual</label>
                                <select id="status" name="status" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-white py-4 px-5 transition-all">
                                    <option value="draft" {{ old('status', $quote->status) == 'draft' ? 'selected' : '' }}>Borrador / Edición</option>
                                    <option value="sent" {{ old('status', $quote->status) == 'sent' ? 'selected' : '' }}>Enviada al Cliente</option>
                                    <option value="approved" {{ old('status', $quote->status) == 'approved' ? 'selected' : '' }}>Aprobada / Ganada</option>
                                    <option value="rejected" {{ old('status', $quote->status) == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                    <option value="expired" {{ old('status', $quote->status) == 'expired' ? 'selected' : '' }}>Expirada</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Introducción / Alcance</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-xl text-slate-300 py-4 px-5 transition-all">{{ old('description', $quote->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden shadow-xl">
                        <div class="p-6 border-b border-[#1e293b] flex justify-between items-center bg-[#1e293b]/30">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest italic">Partidas de la Cotización</h3>
                            <button type="button" @click="addItem()" class="text-xs font-bold text-[#00f6ff] hover:text-white uppercase tracking-widest">
                                + Añadir Fila
                            </button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#1e293b]">
                                <thead class="bg-[#0B1120]/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Servicio</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Descripción</th>
                                        <th class="px-6 py-3 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">Cant.</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-500 uppercase tracking-widest">Unitario</th>
                                        <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-500 uppercase tracking-widest">Subtotal</th>
                                        <th class="px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#1e293b]">
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="hover:bg-[#1e293b]/10 transition-colors">
                                            <td class="px-4 py-4 w-1/4">
                                                <select :name="`items[${index}][service_id]`" x-model="item.service_id"
                                                        class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-white p-2">
                                                    <option value="">Servicio Custom</option>
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-4">
                                                <input :name="`items[${index}][description]`" x-model="item.description" required
                                                       class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-slate-400 p-2">
                                            </td>
                                            <td class="px-4 py-4 w-20">
                                                <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" min="1"
                                                       class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-center text-white p-2">
                                            </td>
                                            <td class="px-4 py-4 w-28">
                                                <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" step="0.01"
                                                       class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-right text-[#00f6ff] p-2 font-bold">
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-xs font-black text-white" x-text="'$' + (item.quantity * item.unit_price).toFixed(2)"></span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-rose-500 hover:text-rose-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer Summary Card -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gradient-to-br from-[#0f172a] to-[#1e293b] rounded-2xl border border-[#1e293b] p-8 shadow-2xl sticky top-8">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-white/5 pb-4">Resumen Financiero</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium italic italic italic">Total Vigente</span>
                                <span class="text-2xl font-black text-[#00f6ff] glow-cyan" x-text="'$' + calculateTotal().toFixed(2)"></span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="valid_until" class="block font-semibold text-xs text-slate-500 uppercase tracking-widest mb-2 italic">Fecha de Validez</label>
                            <input id="valid_until" name="valid_until" type="date" value="{{ old('valid_until', $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '') }}"
                                   class="block w-full bg-[#0B1120] border-[#1e293b] rounded-xl text-rose-400 text-xs p-3 font-bold">
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-4 bg-[#0B1120] border border-[#00f6ff] rounded-2xl font-black text-xs text-[#00f6ff] uppercase tracking-tighter transition-all duration-500 hover:bg-[#00f6ff] hover:text-[#0B1120]">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function quoteForm() {
            return {
                items: @json($quote->items->map(fn($i) => ['service_id' => $i->service_id, 'description' => $i->description, 'quantity' => $i->quantity, 'unit_price' => $i->unit_price])),
                addItem() {
                    this.items.push({ service_id: '', description: '', quantity: 1, unit_price: 0.00 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                calculateTotal() {
                    return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price), 0);
                }
            }
        }
    </script>
</x-app-layout>
