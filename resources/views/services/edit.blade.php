<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Editar Plan:') }} <span class="text-[#00f6ff]">{{ $service->name }}</span>
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('services.update', $service) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Aplicación Base (App Padre)</label>
                            <select name="application_id" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold py-3 px-4 shadow-[0_0_15px_rgba(0,246,255,0.1)]" required>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}" class="bg-[#0B1120]" {{ old('application_id', $service->application_id) == $app->id ? 'selected' : '' }}>{{ $app->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('application_id')" class="mt-2 text-rose-400" />
                        </div>
                        <div class="md:col-span-2">
                            <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre del Plan</label>
                            <input id="name" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" type="text" name="name" :value="old('name', $service->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label for="price" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Precio Total ($)</label>
                            <input id="price" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold shadow-sm py-3 px-4" type="number" step="0.01" name="price" :value="old('price', $service->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label for="duration_days" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Duración (Días)</label>
                            <input id="duration_days" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4" type="number" name="duration_days" :value="old('duration_days', $service->duration_days)" required />
                            <x-input-error :messages="$errors->get('duration_days')" class="mt-2 text-rose-400" />
                        </div>

                        <div class="md:col-span-2">
                            <label for="features" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Características</label>
                            <textarea id="features" name="features" rows="5" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4">{{ old('features', $service->features) }}</textarea>
                            <x-input-error :messages="$errors->get('features')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('services.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] shadow-[0_0_15px_rgba(0,246,255,0.2)] focus:outline-none transition-all duration-300">
                            Actualizar Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
