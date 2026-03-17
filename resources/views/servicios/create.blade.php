<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Registrar Servicio Tecnológico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <form action="{{ route('servicios.store') }}" method="POST" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Relación -->
                        <div class="col-span-2">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 border-b pb-2">Información Contractual</h3>
                        </div>

                        <div>
                            <x-input-label for="cliente_id" :value="__('Cliente Asociado')" />
                            <select id="cliente_id" name="cliente_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }} ({{ $cliente->empresa }})</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
                        </div>

                        <div>
                            <x-input-label for="nombre" :value="__('Nombre del Servicio (Ej: Hosting Premium)')" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>

                        <div>
                            <x-input-label for="tipo" :value="__('Categoría del Servicio')" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Hosting" {{ old('tipo') == 'Hosting' ? 'selected' : '' }}>Hosting</option>
                                <option value="Desarrollo Web" {{ old('tipo') == 'Desarrollo Web' ? 'selected' : '' }}>Desarrollo Web</option>
                                <option value="Soporte Técnico" {{ old('tipo') == 'Soporte Técnico' ? 'selected' : '' }}>Soporte Técnico</option>
                                <option value="Mantenimiento" {{ old('tipo') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="VPS / Servidor" {{ old('tipo') == 'VPS / Servidor' ? 'selected' : '' }}>VPS / Servidor</option>
                                <option value="Dominio" {{ old('tipo') == 'Dominio' ? 'selected' : '' }}>Dominio</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                        </div>

                        <div>
                            <x-input-label for="precio_mensual" :value="__('Precio Mensual ($)')" />
                            <x-text-input id="precio_mensual" name="precio_mensual" type="number" step="0.01" class="mt-1 block w-full" :value="old('precio_mensual')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('precio_mensual')" />
                        </div>

                        <div>
                            <x-input-label for="dia_pago" :value="__('Día de Pago (1-31)')" />
                            <x-text-input id="dia_pago" name="dia_pago" type="number" min="1" max="31" class="mt-1 block w-full" :value="old('dia_pago', 5)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('dia_pago')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio de Servicio')" />
                            <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
                        </div>

                        <!-- Infraestructura -->
                        <div class="col-span-2 mt-6">
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 border-b pb-2">Detalles Técnicos / Infraestructura</h3>
                        </div>

                        <div>
                            <x-input-label for="dominio" :value="__('Dominio Principal')" />
                            <x-text-input id="dominio" name="dominio" type="text" class="mt-1 block w-full" :value="old('dominio')" placeholder="ejemplo.com" />
                            <x-input-error class="mt-2" :messages="$errors->get('dominio')" />
                        </div>

                        <div>
                            <x-input-label for="proveedor" :value="__('Proveedor de Infraestructura')" />
                            <x-text-input id="proveedor" name="proveedor" type="text" class="mt-1 block w-full" :value="old('proveedor')" placeholder="AWS, Google Cloud, etc." />
                            <x-input-error class="mt-2" :messages="$errors->get('proveedor')" />
                        </div>

                        <div>
                            <x-input-label for="ip_servidor" :value="__('IP del Servidor')" />
                            <x-text-input id="ip_servidor" name="ip_servidor" type="text" class="mt-1 block w-full" :value="old('ip_servidor')" />
                            <x-input-error class="mt-2" :messages="$errors->get('ip_servidor')" />
                        </div>

                        <div>
                            <x-input-label for="so" :value="__('Sistema Operativo')" />
                            <x-text-input id="so" name="so" type="text" class="mt-1 block w-full" :value="old('so')" placeholder="Ubuntu 22.04" />
                            <x-input-error class="mt-2" :messages="$errors->get('so')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="descripcion" :value="__('Descripción del Servicio')" />
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('descripcion') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('servicios.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-100 rounded-xl border-none">
                            {{ __('Guardar Servicio') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
