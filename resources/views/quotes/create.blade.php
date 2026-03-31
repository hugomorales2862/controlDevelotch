<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Nueva Cotización Formal') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4" x-data="quoteForm()">
        <form method="POST" action="{{ route('quotes.store') }}" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Data -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Título de la Propuesta</label>
                                <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all"
                                       placeholder="Ej: Servicios Mensuales de Infraestructura Cloud">
                                <x-input-error :messages="$errors->get('title')" class="mt-2 text-rose-400" />
                            </div>

                            <!-- Client -->
                            <div>
                                <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Cliente Destinatario</label>
                                <select id="client_id" name="client_id" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 transition-all">
                                    <option value="">-- Seleccionar Cliente --</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->cli_id }}" {{ old('client_id') == $client->cli_id ? 'selected' : '' }}>
                                            {{ $client->name }} ({{ $client->company }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                            </div>

                            <!-- Valid Until -->
                            <div>
                                <label for="valid_until" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Válida Hasta</label>
                                <input id="valid_until" name="valid_until" type="date" value="{{ old('valid_until', date('Y-m-d', strtotime('+30 days'))) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-rose-400 font-bold py-4 px-5 transition-all">
                                <x-input-error :messages="$errors->get('valid_until')" class="mt-2 text-rose-400" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Introducción / Alcance de la Cotización</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-slate-300 py-4 px-5 transition-all">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] overflow-hidden shadow-xl">
                        <div class="p-6 border-b border-[#1e293b] flex justify-between items-center bg-[#1e293b]/30">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest italic">Desglose de Servicios / Productos</h3>
                            <button type="button" @click="addItem()" class="text-xs font-bold text-[#00f6ff] hover:text-white transition-colors uppercase tracking-widest">
                                + Añadir Fila
                            </button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#1e293b]">
                                <thead class="bg-[#0B1120]/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Servicio</th>
                                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase tracking-widest">Descripción / Detalle</th>
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
                                                <select :name="`items[${index}][service_id]`" x-model="item.service_id" @change="updateFromService(index)"
                                                        class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-white p-2">
                                                    <option value="">Servicio Custom</option>
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-name="{{ $service->name }}">
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-4">
                                                <input :name="`items[${index}][description]`" x-model="item.description" required
                                                       class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-slate-400 p-2" placeholder="Detalle adicional...">
                                            </td>
                                            <td class="px-4 py-4 w-20">
                                                <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" min="1"
                                                       class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-center text-white p-2">
                                            </td>
                                            <td class="px-4 py-4 w-28">
                                                <div class="relative">
                                                    <span class="absolute left-2 top-2 text-slate-500 text-[10px] font-black">$</span>
                                                    <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" step="0.01"
                                                           class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-right text-[#00f6ff] pl-5 p-2 font-bold">
                                                </div>
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
                                <span class="text-slate-500 font-medium tracking-tight">Subtotal General</span>
                                <span class="text-white font-bold" x-text="'$' + calculateTotal().toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium tracking-tight">Impuestos (Incl.)</span>
                                <span class="text-slate-400 font-medium italic">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                                <span class="text-[10px] font-black p-1 bg-amber-500/10 text-amber-500 rounded uppercase tracking-tighter">Total Cotizado</span>
                                <span class="text-2xl font-black text-[#00f6ff] glow-cyan" x-text="'$' + calculateTotal().toFixed(2)"></span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="notes" class="block font-semibold text-xs text-slate-500 uppercase tracking-widest mb-4 italic">Observaciones para el cliente</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="block w-full bg-[#0B1120]/50 border border-[#1e293b] focus:border-amber-500 rounded-xl text-xs text-slate-300 p-4 transition-all"
                                      placeholder="Ej: Tiempo de entrega estimado 15 días hábiles.">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.2)] hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Emitir Cotización
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function quoteForm() {
            return {
                items: [
                    { service_id: '', description: '', quantity: 1, unit_price: 0.00 }
                ],
                addItem() {
                    this.items.push({ service_id: '', description: '', quantity: 1, unit_price: 0.00 });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                updateFromService(index) {
                    const select = document.querySelectorAll('select[name^="items"]')[index];
                    const option = select.options[select.selectedIndex];
                    if (option && option.dataset.price) {
                        this.items[index].unit_price = parseFloat(option.dataset.price);
                        this.items[index].description = option.dataset.name;
                    }
                },
                calculateTotal() {
                    return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_price), 0);
                }
            }
        }
    </script>
</x-app-layout>
