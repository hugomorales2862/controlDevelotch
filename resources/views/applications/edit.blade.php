<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Editar App:') }} <span class="text-[#00f6ff]">{{ $application->name }}</span>
            </h2>
            <form action="{{ route('applications.destroy', $application) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs font-bold text-rose-500 hover:text-white bg-rose-500/10 border border-rose-500/20 px-4 py-2 rounded-xl uppercase tracking-widest transition-colors">Eliminar App</button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('applications.update', $application) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Nombre de la Aplicación</label>
                            <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4" type="text" name="name" :value="old('name', $application->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">URL</label>
                            <input class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-[#00f6ff] py-3 px-4" type="url" name="url" :value="old('url', $application->url)" />
                            <x-input-error :messages="$errors->get('url')" class="mt-2 text-rose-400" />
                        </div>

                        <div>
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Estado</label>
                            <select name="status" class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4" required>
                                <option value="active" {{ old('status', $application->status) == 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="inactive" {{ old('status', $application->status) == 'inactive' ? 'selected' : '' }}>Inactiva / En Desarrollo</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-rose-400" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Descripción</label>
                            <textarea name="description" rows="4" class="block mt-1 w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white py-3 px-4">{{ old('description', $application->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-rose-400" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-[#1e293b] pt-6">
                        <a href="{{ route('applications.index') }}" class="text-sm text-slate-500 hover:text-white mr-6 font-medium transition-colors">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#0B1120] border border-[#00f6ff] rounded-xl font-bold text-xs text-[#00f6ff] uppercase tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] shadow-[0_0_15px_rgba(0,246,255,0.2)] focus:outline-none transition-all duration-300">
                            Actualizar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
