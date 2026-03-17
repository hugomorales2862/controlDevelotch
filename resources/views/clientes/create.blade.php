<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <form action="{{ route('clientes.store') }}" method="POST" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Básica -->
                        <div class="col-span-2">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 border-b pb-2">Información Básica</h3>
                        </div>

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre Completo')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="empresa" :value="__('Nombre de la Empresa')" />
                            <x-text-input id="empresa" name="empresa" type="text" class="mt-1 block w-full" :value="old('empresa')" />
                            <x-input-error class="mt-2" :messages="$errors->get('empresa')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono / Móvil')" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" />
                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                        </div>

                        <div>
                            <x-input-label for="whatsapp" :value="__('WhatsApp')" />
                            <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full" :value="old('whatsapp')" />
                            <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
                        </div>

                        <div>
                            <x-input-label for="estado" :value="__('Estado Inicial')" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="suspendido" {{ old('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_registro" :value="__('Fecha de Registro')" />
                            <x-text-input id="fecha_registro" name="fecha_registro" type="date" class="mt-1 block w-full" :value="old('fecha_registro', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_registro')" />
                        </div>

                        <!-- Ubicación -->
                        <div class="col-span-2 mt-6">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 border-b pb-2">Ubicación y Dirección</h3>
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="direccion" :value="__('Dirección Física')" />
                            <textarea id="direccion" name="direccion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2">{{ old('direccion') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
                        </div>

                        <div>
                            <x-input-label for="ciudad" :value="__('Ciudad')" />
                            <x-text-input id="ciudad" name="ciudad" type="text" class="mt-1 block w-full" :value="old('ciudad')" />
                            <x-input-error class="mt-2" :messages="$errors->get('ciudad')" />
                        </div>

                        <div>
                            <x-input-label for="pais" :value="__('País')" />
                            <x-text-input id="pais" name="pais" type="text" class="mt-1 block w-full" :value="old('pais')" />
                            <x-input-error class="mt-2" :messages="$errors->get('pais')" />
                        </div>

                        <!-- Contactos Adicionales -->
                        <div class="col-span-2 mt-6">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 border-b pb-2">Información Técnica y Notas</h3>
                        </div>

                        <div>
                            <x-input-label for="contacto_tecnico" :value="__('Contacto Técnico (Nombre/Email)')" />
                            <textarea id="contacto_tecnico" name="contacto_tecnico" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('contacto_tecnico') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('contacto_tecnico')" />
                        </div>

                        <div>
                            <x-input-label for="contacto_administrativo" :value="__('Contacto Administrativo (Nombre/Email)')" />
                            <textarea id="contacto_administrativo" name="contacto_administrativo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('contacto_administrativo') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('contacto_administrativo')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="notas" :value="__('Notas Internas')" />
                            <textarea id="notas" name="notas" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notas') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notas')" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('clientes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 rounded-xl">
                            {{ __('Guardar Cliente') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
