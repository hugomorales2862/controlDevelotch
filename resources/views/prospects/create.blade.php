<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Registrar Nuevo Prospecto') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-[#0f172a] rounded-2xl shadow-xl border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('prospects.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Empresa / Razón Social</label>
                            <input id="company_name" name="company_name" type="text" value="{{ old('company_name') }}" required autofocus
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all shadow-[0_0_15px_rgba(0,246,255,0.05)]">
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Contact Name -->
                        <div>
                            <label for="contact_name" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Persona de Contacto</label>
                            <input id="contact_name" name="contact_name" type="text" value="{{ old('contact_name') }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('contact_name')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Correo Electrónico</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Teléfono / WhatsApp</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Industry -->
                        <div>
                            <label for="industry" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Industria / Sector</label>
                            <input id="industry" name="industry" type="text" value="{{ old('industry') }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all"
                                   placeholder="Ej: Tecnología, Salud, Finanzas">
                            <x-input-error :messages="$errors->get('industry')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Estado del Lead</label>
                            <select id="status" name="status" required
                                    class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-4 px-5 shadow-sm transition-all">
                                <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>Nuevo Lead</option>
                                <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contactado</option>
                                <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Calificado</option>
                                <option value="proposal" {{ old('status') == 'proposal' ? 'selected' : '' }}>En Propuesta</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Website -->
                        <div class="md:col-span-2">
                            <label for="website" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Sitio Web (URL)</label>
                            <input id="website" name="website" type="url" value="{{ old('website') }}"
                                   class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] py-4 px-5 shadow-sm transition-all"
                                   placeholder="https://">
                            <x-input-error :messages="$errors->get('website')" class="mt-2 text-rose-400" />
                        </div>

                        <!-- Address fields in one row -->
                        <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="md:col-span-1 col-span-2">
                                <label for="address" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Dirección</label>
                                <input id="address" name="address" type="text" value="{{ old('address') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 rounded-xl text-white py-3 px-4 shadow-sm transition-all">
                            </div>
                            <div>
                                <label for="city" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Ciudad</label>
                                <input id="city" name="city" type="text" value="{{ old('city') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 rounded-xl text-white py-3 px-4 shadow-sm transition-all">
                            </div>
                            <div>
                                <label for="country" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">País</label>
                                <input id="country" name="country" type="text" value="{{ old('country') }}"
                                       class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 rounded-xl text-white py-3 px-4 shadow-sm transition-all">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label for="notes" class="block font-semibold text-xs text-slate-400 uppercase tracking-widest mb-2">Notas / Requerimientos Iniciales</label>
                            <textarea id="notes" name="notes" rows="4" 
                                      class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 rounded-xl text-slate-300 py-4 px-5 shadow-sm transition-all">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 pt-8 border-t border-[#1e293b]">
                        <a href="{{ route('prospects.index') }}" class="text-sm text-slate-500 hover:text-white mr-8 font-medium transition-colors uppercase tracking-widest italic">Cancelar</a>
                        <button type="submit" 
                                class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-tighter transition-all duration-500 shadow-[0_0_25px_rgba(0,246,255,0.3)] hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Registrar Prospecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
