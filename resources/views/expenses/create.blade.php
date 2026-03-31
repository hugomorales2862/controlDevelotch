<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
            <svg class="w-6 h-6 mr-2 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            {{ __('Registrar Nuevo Gasto') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(244,63,94,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Descripción del Gasto</label>
                            <input class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-400 focus:ring focus:ring-rose-400/20 rounded-xl text-white shadow-sm py-3 px-4" type="text" name="description" value="{{ old('description') }}" required autofocus placeholder="Ej: Pago de Servidores AWS" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Monto del Egreso ($)</label>
                            <input class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-400 focus:ring focus:ring-rose-400/20 rounded-xl text-rose-400 font-bold shadow-sm py-3 px-4" type="number" step="0.01" name="amount" value="{{ old('amount') }}" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Fecha Contable</label>
                            <input class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-rose-400 focus:ring focus:ring-rose-400/20 rounded-xl text-white shadow-sm py-3 px-4" type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required />
                            <x-input-error :messages="$errors->get('expense_date')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('expenses.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-rose-700 hover:from-rose-400 hover:to-rose-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest shadow-[0_0_15px_rgba(244,63,94,0.3)] focus:outline-none transition-all duration-300">
                            Procesar Gasto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
