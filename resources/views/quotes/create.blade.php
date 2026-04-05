<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Nueva Cotización Formal') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4" x-data="quoteForm('{{ addslashes($initialQuoteable) }}')">
        <form method="POST" action="{{ route('quotes.store') }}" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Data -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-[#0f172a] rounded-2xl border border-[#1e293b] p-8 shadow-xl relative overflow-hidden">
                        <!-- Decorative background element -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#00f6ff]/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Entidad Destino -->
                            <div class="md:col-span-2">
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block font-semibold text-xs text-slate-400 uppercase tracking-widest italic">Cliente o Prospecto Destinatario</label>
                                    <button type="button" @click="showModal = true" class="text-[10px] font-black text-[#00f6ff] hover:text-white uppercase tracking-tighter transition-colors">
                                        + Registrar Nuevo Prospecto
                                    </button>
                                </div>
                                <select x-model="selectedIdentifier" @change="updateQuoteable($event.target.value)" required
                                        class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 transition-all shadow-inner">
                                    <option value="">-- Seleccionar Destinatario --</option>
                                    <optgroup label="Prospectos (Posibles Clientes)" class="bg-[#1e293b]">
                                        @foreach($prospects as $prospect)
                                            <option value="App\Models\Prospect|{{ $prospect->id }}" 
                                                    data-name="{{ $prospect->company_name ?: $prospect->contact_name }}"
                                                    data-company="{{ $prospect->company_name }}"
                                                    data-email="{{ $prospect->email }}">
                                                {{ $prospect->company_name ?: $prospect->contact_name }} (Prospecto)
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Clientes Activos" class="bg-[#1e293b]">
                                        @foreach($clients as $client)
                                            <option value="App\Models\Client|{{ $client->cli_id }}"
                                                    data-name="{{ $client->name }}"
                                                    data-company="{{ $client->company }}"
                                                    data-email="{{ $client->email }}">
                                                {{ $client->name }} (Cliente)
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <input type="hidden" name="quoteable_type" x-model="quoteable_type">
                                <input type="hidden" name="quoteable_id" x-model="quoteable_id">
                                
                                <!-- Loaded Entity Info Panel -->
                                <template x-if="quoteable_id">
                                    <div class="mt-4 p-4 bg-[#0B1120]/80 border border-[#00f6ff]/20 rounded-xl flex items-center justify-between animate-fadeIn">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-[#00f6ff]/10 flex items-center justify-center text-[#00f6ff] mr-4 border border-[#00f6ff]/20">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v11m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-white uppercase tracking-widest" x-text="loadedEntity.name"></p>
                                                <p class="text-[10px] text-slate-500" x-text="loadedEntity.email"></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[9px] font-black p-1 bg-[#00f6ff]/10 text-[#00f6ff] rounded border border-[#00f6ff]/20 uppercase tracking-tighter" x-text="quoteable_type.split('\\').pop()"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Título de la Propuesta</label>
                                <input id="title" name="title" type="text" x-model="quote_title" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all"
                                       placeholder="Ej: Servicios Mensuales de Infraestructura Cloud">
                            </div>

                            <!-- Valid Until -->
                            <div class="md:col-span-2">
                                <label for="valid_until" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Fecha Límite de Validez</label>
                                <input id="valid_until" name="valid_until" type="date" value="{{ old('valid_until', date('Y-m-d', strtotime('+30 days'))) }}" required
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-rose-400 font-bold py-4 px-5 transition-all">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2 italic">Introducción / Alcance</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-slate-300 py-4 px-5 transition-all"
                                      placeholder="Describe brevemente el objetivo de esta propuesta comercial..."></textarea>
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
                                                    <span class="absolute left-2 top-2 text-slate-500 text-[10px] font-black">Q</span>
                                                    <input type="number" :name="`items[${index}][unit_price]`" x-model.number="item.unit_price" step="0.01"
                                                           class="block w-full bg-[#0B1120] border-[#1e293b] rounded-lg text-xs text-right text-[#00f6ff] pl-5 p-2 font-bold">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-xs font-black text-white" x-text="'Q' + (item.quantity * item.unit_price).toFixed(2)"></span>
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
                                <span class="text-white font-bold" x-text="'Q' + calculateTotal().toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium tracking-tight">Impuestos (Incl.)</span>
                                <span class="text-slate-400 font-medium italic">Q0.00</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                                <span class="text-[10px] font-black p-1 bg-amber-500/10 text-amber-500 rounded uppercase tracking-tighter">Total Cotizado</span>
                                <span class="text-2xl font-black text-[#00f6ff] glow-cyan" x-text="'Q' + calculateTotal().toFixed(2)"></span>
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

        <!-- Quick Prospect Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" x-cloak>
            <div @click.away="showModal = false" class="bg-[#0f172a] border border-[#1e293b] rounded-3xl w-full max-w-md shadow-2xl overflow-hidden scale-in">
                <div class="p-6 border-b border-[#1e293b] bg-gradient-to-r from-[#0f172a] to-[#1e293b] flex justify-between items-center">
                    <h3 class="text-white font-black uppercase text-xs tracking-widest">Registro Rápido de Prospecto</h3>
                    <button @click="showModal = false" class="text-slate-500 hover:text-white">&times;</button>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Empresa / Razón Social</label>
                        <input type="text" x-model="quickProspect.company_name" class="w-full bg-[#0B1120] border-[#1e293b] rounded-xl text-white text-sm py-3 px-4 focus:border-[#00f6ff] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Nombre del Contacto</label>
                        <input type="text" x-model="quickProspect.contact_name" class="w-full bg-[#0B1120] border-[#1e293b] rounded-xl text-white text-sm py-3 px-4 focus:border-[#00f6ff] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Email Principal</label>
                        <input type="email" x-model="quickProspect.email" class="w-full bg-[#0B1120] border-[#1e293b] rounded-xl text-white text-sm py-3 px-4 focus:border-[#00f6ff] transition-all">
                    </div>
                    <div x-show="errorMessage" class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-lg">
                        <p class="text-[10px] text-rose-500 text-center font-bold italic" x-text="errorMessage"></p>
                    </div>
                    <button type="button" @click="saveQuickProspect()" 
                            class="w-full py-4 bg-[#00f6ff] text-[#0B1120] font-black uppercase text-xs rounded-xl hover:bg-white transition-all">
                        Cargar y Guardar Prospecto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .scale-in { animation: scaleIn 0.3s ease-out; }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

    <script>
        function quoteForm(initialValue = '') {
            return {
                selectedIdentifier: initialValue,
                quoteable_type: initialValue ? initialValue.split('|')[0] : '',
                quoteable_id: initialValue ? initialValue.split('|')[1] : '',
                quote_title: '',
                items: [
                    { service_id: '', description: '', quantity: 1, unit_price: 0.00 }
                ],
                showModal: false,
                errorMessage: '',
                quickProspect: {
                    company_name: '',
                    contact_name: '',
                    email: '',
                    status: 'new'
                },
                loadedEntity: {
                    name: '',
                    email: '',
                    company: ''
                },
                init() {
                    if (this.selectedIdentifier) {
                        this.$nextTick(() => this.updateQuoteable(this.selectedIdentifier));
                    }
                },
                updateQuoteable(value) {
                    if (value) {
                        const parts = value.split('|');
                        this.quoteable_type = parts[0];
                        this.quoteable_id = parts[1];
                        
                        // Cargar datos del DOM (desde los atributos data)
                        const select = document.querySelector('select[x-model="selectedIdentifier"]');
                        const option = select.querySelector(`option[value="${CSS.escape(value)}"]`);
                        if (option) {
                            this.loadedEntity.name = option.dataset.name;
                            this.loadedEntity.email = option.dataset.email;
                            this.loadedEntity.company = option.dataset.company;
                            
                            // Autocompletar título si está vacío
                            if (this.quote_title === '' || this.quote_title.includes('Propuesta Comercial para')) {
                                this.quote_title = `Propuesta Comercial para ${this.loadedEntity.name}`;
                            }
                        }
                    } else {
                        this.quoteable_type = '';
                        this.quoteable_id = '';
                        this.loadedEntity = { name: '', email: '', company: '' };
                    }
                },
                saveQuickProspect() {
                    this.errorMessage = '';
                    fetch("{{ route('prospects.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.quickProspect)
                    })
                    .then(response => {
                        if (!response.ok && response.status !== 422) throw new Error();
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Añadir al select dinámicamente
                            const select = document.querySelector('select[x-model="selectedIdentifier"]');
                            const optgroup = select.querySelector('optgroup[label*="Prospectos"]');
                            const newText = `${data.prospect.company_name || data.prospect.contact_name} (Nuevo Prospecto)`;
                            const newOption = new Option(newText, data.identifier);
                            newOption.dataset.name = data.prospect.company_name || data.prospect.contact_name;
                            newOption.dataset.email = data.prospect.email;
                            newOption.dataset.company = data.prospect.company_name;
                            optgroup.appendChild(newOption);
                            
                            // Seleccionar y cerrar
                            this.selectedIdentifier = data.identifier;
                            this.updateQuoteable(data.identifier);
                            this.showModal = false;
                        } else {
                            if (data.errors) {
                                this.errorMessage = Object.values(data.errors).flat().join(' | ');
                            } else {
                                this.errorMessage = data.message || 'Error al guardar el prospecto.';
                            }
                        }
                    })
                    .catch(error => {
                        this.errorMessage = 'Hubo un error inesperado al procesar la solicitud.';
                    });
                },
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
