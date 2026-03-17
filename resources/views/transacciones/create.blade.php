<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Registrar Movimiento Financiero') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <form action="{{ route('transacciones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="tipo" :value="__('Tipo de Transacción')" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso (+)</option>
                                <option value="egreso" {{ old('tipo') == 'egreso' ? 'selected' : '' }}>Egreso (-)</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                        </div>

                        <div>
                            <x-input-label for="categoria_id" :value="__('Categoría')" />
                            <select id="categoria_id" name="categoria_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        [{{ strtoupper($categoria->tipo) }}] {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('categoria_id')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="descripcion" :value="__('Descripción o Concepto')" />
                            <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" :value="old('descripcion')" required placeholder="Ej: Pago de servidor AWS Octubre" />
                            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                        </div>

                        <div>
                            <x-input-label for="monto" :value="__('Monto ($)')" />
                            <x-text-input id="monto" name="monto" type="number" step="0.01" class="mt-1 block w-full" :value="old('monto')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('monto')" />
                        </div>

                        <div>
                            <x-input-label for="fecha" :value="__('Fecha del Movimiento')" />
                            <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full" :value="old('fecha', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                        </div>

                        <div>
                            <x-input-label for="metodo_pago" :value="__('Método de Pago')" />
                            <x-text-input id="metodo_pago" name="metodo_pago" type="text" class="mt-1 block w-full" :value="old('metodo_pago')" placeholder="Efectivo, Transferencia, Tarjeta..." />
                            <x-input-error class="mt-2" :messages="$errors->get('metodo_pago')" />
                        </div>

                        <div>
                            <x-input-label for="comprobante" :value="__('Sube el Comprobante (Opcional)')" />
                            <input id="comprobante" name="comprobante" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('comprobante')" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('transacciones.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 rounded-xl">
                            {{ __('Guardar Movimiento') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
