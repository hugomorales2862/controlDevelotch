<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Registrar Ingreso de Caja') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('sales.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Cliente Vinculado</label>
                            <select name="client_id" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required autofocus>
                                <option value="" class="bg-[#0B1120]">-- Seleccionar Origen --</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" class="bg-[#0B1120]" {{ old('client_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Servicio (Opcional)</label>
                            <select name="service_id" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4">
                                <option value="" class="bg-[#0B1120]">-- Pago General --</option>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" class="bg-[#0B1120]" {{ old('service_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('service_id')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Monto ($)</label>
                            <input class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold shadow-sm py-3 px-4" type="number" step="0.01" name="amount" :value="old('amount')" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Método de Pago</label>
                            <select name="payment_method" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4">
                                <option value="Transferencia" class="bg-[#0B1120]" {{ old('payment_method') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="Tarjeta" class="bg-[#0B1120]" {{ old('payment_method') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta / Débito</option>
                                <option value="Efectivo" class="bg-[#0B1120]" {{ old('payment_method') == 'Efectivo' ? 'selected' : '' }}>Efectivo / Cash</option>
                                <option value="PayPal/Stripe" class="bg-[#0B1120]" {{ old('payment_method') == 'PayPal/Stripe' ? 'selected' : '' }}>Pasarela Web</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Fecha Contable</label>
                            <input class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" type="date" name="sale_date" :value="old('sale_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('sale_date')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('sales.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest shadow-glow-cyan focus:outline-none transition-all duration-300">
                            Validar Ingreso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
