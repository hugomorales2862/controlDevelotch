<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Registrar Aplicación SaaS') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('applications.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre de la Aplicación</label>
                            <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4 shadow-border flex-1" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">URL (Opcional)</label>
                            <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-medium py-3 px-4" type="url" name="url" value="{{ old('url') }}" />
                            <x-input-error :messages="$errors->get('url')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Estado</label>
                            <select name="status" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactiva / En Desarrollo</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Descripción</label>
                            <textarea name="description" rows="4" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('applications.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest shadow-glow-cyan focus:outline-none transition-all duration-300">
                            Registrar App
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
