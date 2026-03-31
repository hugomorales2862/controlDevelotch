<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Nuevo Cliente Principal') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('clients.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre Principal</label>
                            <input id="name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Empresa (Opcional)</label>
                            <input id="company" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="company" value="{{ old('company') }}" />
                            <x-input-error :messages="$errors->get('company')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Correo Electrónico</label>
                            <input id="email" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="email" name="email" value="{{ old('email') }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Teléfono (Opcional)</label>
                            <input id="phone" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="phone" value="{{ old('phone') }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-rose-400" />
                        </div>
                        
                        <!-- Contact Name -->
                        <div class="md:col-span-2">
                            <label for="contact_name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre de Persona de Contacto (Opcional)</label>
                            <input id="contact_name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-600 py-3 px-4" type="text" name="contact_name" value="{{ old('contact_name') }}" />
                            <x-input-error :messages="$errors->get('contact_name')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('clients.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest focus:outline-none transition-all duration-300 shadow-glow-cyan">
                            Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
