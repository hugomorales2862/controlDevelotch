<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Editar Comprobante de Pago:') }} <span class="text-[#00f6ff]">{{ $invoice->invoice_number }}</span>
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4" x-data="invoiceForm({{ Js::from($invoice) }})">
        <form method="POST" action="{{ route('invoices.update', $invoice) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Data -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Client -->
                            <div class="md:col-span-2">
                                <label for="client_id" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Cliente</label>
                                <select id="client_id" name="client_id" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 transition-all">
                                    @foreach($clients as $client)
                                        <option value="{{ $client->cli_id }}" {{ old('client_id', $invoice->client_id) == $client->cli_id ? 'selected' : '' }}>
                                            {{ $client->name }} ({{ $client->company }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Invoice Number -->
                            <div>
                                <label for="invoice_number" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Número de Comprobante</label>
                                <input id="invoice_number" name="invoice_number" type="text" value="{{ old('invoice_number', $invoice->invoice_number) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-[#00f6ff] font-black py-4 px-5 transition-all">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Estado Operacional</label>
                                <select id="status" name="status" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5 transition-all">
                                    <option value="draft" {{ old('status', $invoice->status) == 'draft' ? 'selected' : '' }}>Borrador</option>
                                    <option value="sent" {{ old('status', $invoice->status) == 'sent' ? 'selected' : '' }}>Enviada</option>
                                    <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Pagada</option>
                                    <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>Vencida</option>
                                    <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Anulada</option>
                                </select>
                            </div>

                            <!-- Issue Date -->
                            <div>
                                <label for="issue_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Fecha de Emisión</label>
                                <input id="issue_date" name="issue_date" type="date" value="{{ old('issue_date', $invoice->issue_date->format('Y-m-d')) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-white py-4 px-5">
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Fecha de Vencimiento</label>
                                <input id="due_date" name="due_date" type="date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] rounded-xl text-rose-400 font-bold py-4 px-5 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest">Detalle de Servicios / Productos</h3>
                            <button type="button" @click="addItem" 
                                    class="text-[10px] bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20 px-4 py-2 rounded-lg hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all font-black uppercase">
                                + Añadir Ítem
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-[#0B1120] p-4 rounded-xl border border-white/5 group">
                                    <div class="md:col-span-6">
                                        <label class="block text-[9px] text-slate-500 font-black uppercase mb-1">Descripción</label>
                                        <input :name="'items['+index+'][description]'" x-model="item.description" type="text" required
                                               class="w-full bg-[#0f172a] border-[#1e293b] rounded-lg text-white py-2 text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[9px] text-slate-500 font-black uppercase mb-1">Cant.</label>
                                        <input :name="'items['+index+'][quantity]'" x-model.number="item.quantity" type="number" step="0.01" required
                                               class="w-full bg-[#0f172a] border-[#1e293b] rounded-lg text-white py-2 text-sm text-center">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[9px] text-slate-500 font-black uppercase mb-1">Precio Un.</label>
                                        <input :name="'items['+index+'][unit_price]'" x-model.number="item.unit_price" type="number" step="0.01" required
                                               class="w-full bg-[#0f172a] border-[#1e293b] rounded-lg text-[#00f6ff] py-2 text-sm text-right">
                                    </div>
                                    <div class="md:col-span-1">
                                        <div class="text-right text-xs font-black text-slate-400 mb-2">
                                            $<span x-text="(item.quantity * item.unit_price).toFixed(2)"></span>
                                        </div>
                                    </div>
                                    <div class="md:col-span-1 flex justify-center pb-2">
                                        <button type="button" @click="removeItem(index)" class="text-rose-500 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Totals Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] p-8 sticky top-6">
                        <h3 class="text-sm font-black text-white uppercase tracking-widest mb-6">Actualización de Montos</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-slate-400">
                                <span class="text-xs uppercase font-bold tracking-tighter">Sub-Total</span>
                                <span class="text-white font-black">$<span x-text="subtotal.toFixed(2)"></span></span>
                            </div>

                            <div>
                                <label class="flex justify-between items-center text-slate-400 mb-2">
                                    <span class="text-xs uppercase font-bold tracking-tighter">I.V.A (%)</span>
                                    <input type="number" step="0.01" name="tax_rate" x-model.number="taxRate" 
                                           class="w-16 bg-[#0B1120] border-white/10 rounded-lg text-white text-[10px] text-right py-1 px-2">
                                </label>
                            </div>

                            <div>
                                <label class="flex justify-between items-center text-slate-400 mb-2">
                                    <span class="text-xs uppercase font-bold tracking-tighter">Descuento ($)</span>
                                    <input type="number" step="0.01" name="discount" x-model.number="discount" 
                                           class="w-20 bg-[#0B1120] border-white/10 rounded-lg text-white text-[10px] text-right py-1 px-2">
                                </label>
                            </div>

                            <div class="pt-6 border-t border-white/5">
                                <div class="flex justify-between items-end">
                                    <span class="text-xs uppercase font-black text-slate-500 mb-2">Nuevo Total</span>
                                    <div class="text-center">
                                        <div class="text-4xl font-black text-[#00f6ff] tracking-tighter italic glow-cyan">
                                            $<span x-text="total.toFixed(2)"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="total" :value="total">
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <button type="submit" 
                                    class="w-full bg-[#0B1120] border border-[#00f6ff] text-[#00f6ff] font-black uppercase text-xs tracking-widest py-4 rounded-xl hover:bg-[#00f6ff] hover:text-[#0B1120] transition-all">
                                Actualizar Comprobante
                            </button>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="bg-[#1e293b]/20 p-6 rounded-2xl border border-white/5">
                        <label for="notes" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Notas / Condiciones</label>
                        <textarea id="notes" name="notes" rows="3" 
                                  class="w-full bg-[#0f172a]/50 border-white/5 rounded-xl text-slate-400 text-[11px]">{{ old('notes', $invoice->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function invoiceForm(invoice) {
            return {
                items: invoice.items || [],
                taxRate: invoice.tax_rate || 0,
                discount: invoice.discount || 0,
                addItem() {
                    this.items.push({ description: '', quantity: 1, unit_price: 0 });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                get subtotal() {
                    return this.items.reduce((sum, item) => sum + (parseFloat(item.quantity) * parseFloat(item.unit_price)), 0);
                },
                get taxAmount() {
                    return (this.subtotal * (parseFloat(this.taxRate) / 100));
                },
                get total() {
                    return (this.subtotal + this.taxAmount) - parseFloat(this.discount);
                }
            }
        }
    </script>
</x-app-layout>
