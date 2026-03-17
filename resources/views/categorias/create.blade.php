<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Nueva Categoría Financiera') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre de la Categoría')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required placeholder="Ej: Pago de Servidores, Publicidad, etc." />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="tipo" :value="__('Tipo de Movimiento')" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                                <option value="egreso" {{ old('tipo') == 'egreso' ? 'selected' : '' }}>Egreso</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('categorias.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 rounded-xl">
                            {{ __('Guardar Categoría') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
