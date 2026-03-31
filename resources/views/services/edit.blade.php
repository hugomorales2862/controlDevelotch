<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('services.index') }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                Editar Plan: <span class="text-[#00f6ff]">{{ $service->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('services.update', $service->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Aplicación --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Aplicación Base (App Padre)
                            </label>
                            <select name="application_id"
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold py-3 px-4"
                                required>
                                <option value="">-- Seleccionar Aplicación --</option>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}"
                                        {{ (old('application_id', $service->application_id) == $app->id) ? 'selected' : '' }}>
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('application_id')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Nombre del plan --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Nombre del Plan
                            </label>
                            <input id="name" type="text" name="name"
                                value="{{ old('name', $service->name) }}"
                                class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4"
                                required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Descripción --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Descripción
                            </label>
                            <textarea id="description" name="description" rows="2"
                                class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4">{{ old('description', $service->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label for="price" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Precio ($)
                            </label>
                            <input id="price" type="number" step="0.01" name="price"
                                value="{{ old('price', $service->price) }}"
                                class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] font-bold shadow-sm py-3 px-4"
                                required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Duración --}}
                        <div>
                            <label for="duration_days" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Duración (días)
                            </label>
                            <input id="duration_days" type="number" name="duration_days"
                                value="{{ old('duration_days', $service->duration_days) }}"
                                class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4"
                                required />
                            <x-input-error :messages="$errors->get('duration_days')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Tipo de servicio --}}
                        <div>
                            <label for="type" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Tipo de Servicio
                            </label>
                            <select id="type" name="type"
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4">
                                <option value="">-- Sin tipo --</option>
                                @foreach(['hosting', 'dominio', 'soporte', 'desarrollo', 'mantenimiento', 'otro'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('type', $service->type) == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Ciclo de facturación --}}
                        <div>
                            <label for="billing_cycle" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Ciclo de Facturación
                            </label>
                            <select id="billing_cycle" name="billing_cycle"
                                class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4">
                                <option value="">-- Sin ciclo --</option>
                                @foreach(['weekly' => 'Semanal', 'monthly' => 'Mensual', 'yearly' => 'Anual', 'triennial' => 'Trienal'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('billing_cycle', $service->billing_cycle) == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('billing_cycle')" class="mt-2 text-rose-400" />
                        </div>

                        {{-- Características --}}
                        <div class="md:col-span-2">
                            <label for="features" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">
                                Características (una por línea)
                            </label>
                            <textarea id="features" name="features" rows="5"
                                class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm py-3 px-4 font-mono text-sm">{{ old('features', $service->features) }}</textarea>
                            <x-input-error :messages="$errors->get('features')" class="mt-2 text-rose-400" />
                        </div>

                    </div>

                    <div class="flex items-center justify-between mt-8 border-t border-[#1e293b] pt-6">
                        {{-- Info de última edición --}}
                        <p class="text-xs text-slate-600">
                            ID: <span class="text-slate-500">#{{ $service->id }}</span> &nbsp;·&nbsp;
                            Actualizado: <span class="text-slate-500">{{ $service->updated_at->diffForHumans() }}</span>
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('services.index') }}" class="text-sm text-slate-500 hover:text-white font-medium transition-colors">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] shadow-[0_0_15px_rgba(0,246,255,0.2)] focus:outline-none transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
