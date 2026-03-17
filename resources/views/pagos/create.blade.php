<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Registrar Pago de Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <form action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="cliente_id" :value="__('Seleccionar Cliente')" />
                            <select id="cliente_id" name="cliente_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
                        </div>

                        <div>
                            <x-input-label for="servicio_id" :value="__('Servicio a Pagar')" />
                            <select id="servicio_id" name="servicio_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Seleccione un servicio</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                        {{ $servicio->nombre }} (${{ $servicio->precio_mensual }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('servicio_id')" />
                        </div>

                        <div>
                            <x-input-label for="monto" :value="__('Monto a Pagar ($)')" />
                            <x-text-input id="monto" name="monto" type="number" step="0.01" class="mt-1 block w-full" :value="old('monto')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('monto')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_vencimiento" :value="__('Fecha de Vencimiento')" />
                            <x-text-input id="fecha_vencimiento" name="fecha_vencimiento" type="date" class="mt-1 block w-full" :value="old('fecha_vencimiento')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_vencimiento')" />
                        </div>

                        <div>
                            <x-input-label for="estado" :value="__('Estado del Pago')" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagado" {{ old('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                <option value="vencido" {{ old('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_pago" :value="__('Fecha de Pago (Si ya se realizó)')" />
                            <x-text-input id="fecha_pago" name="fecha_pago" type="date" class="mt-1 block w-full" :value="old('fecha_pago')" />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_pago')" />
                        </div>

                        <div>
                            <x-input-label for="metodo_pago" :value="__('Método de Pago')" />
                            <x-text-input id="metodo_pago" name="metodo_pago" type="text" class="mt-1 block w-full" :value="old('metodo_pago')" placeholder="Transferencia, Efectivo, etc." />
                            <x-input-error class="mt-2" :messages="$errors->get('metodo_pago')" />
                        </div>

                        <div>
                            <x-input-label for="comprobante" :value="__('Comprobante (Voucher)')" />
                            <input id="comprobante" name="comprobante" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('comprobante')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="observaciones" :value="__('Observaciones')" />
                            <textarea id="observaciones" name="observaciones" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('observaciones') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observaciones')" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                        <a href="{{ route('pagos.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold uppercase tracking-widest">
                            Cancelar
                        </a>
                        <x-primary-button class="px-8 py-3 bg-amber-600 hover:bg-amber-700 shadow-lg shadow-amber-100 rounded-xl">
                            {{ __('Registrar Pago') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
