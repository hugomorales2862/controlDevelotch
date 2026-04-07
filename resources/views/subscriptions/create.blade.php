<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Vincular Cliente a Servicio') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('subscriptions.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        
                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Cliente</label>
                            <select name="client_id" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="" class="bg-[#0B1120]">-- Seleccionar Cliente --</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->cli_id }}" class="bg-[#0B1120]" {{ old('client_id') == $c->cli_id ? 'selected' : '' }}>{{ $c->name }}{{ $c->company ? ' — ' . $c->company : '' }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Plan / Producto</label>
                            <select name="service_id" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold shadow-sm py-3 px-4" required>
                                <option value="" class="bg-[#0B1120]">-- Seleccionar Servicio --</option>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" class="bg-[#0B1120]" {{ old('service_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->duration_days }} días)</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('service_id')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Estado</label>
                            <select name="status" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" required>
                                <option value="active" class="bg-[#0B1120]" {{ old('status') == 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="suspended" class="bg-[#0B1120]" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspendida</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Fecha de Inicio</label>
                                <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required />
                            </div>
                            <div>
                                <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Fecha de Vencimiento</label>
                                <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-rose-400 font-bold shadow-sm py-3 px-4" type="date" name="end_date" value="{{ old('end_date') }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('subscriptions.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest shadow-glow-cyan focus:outline-none transition-all duration-300">
                            Activar Suscripción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
