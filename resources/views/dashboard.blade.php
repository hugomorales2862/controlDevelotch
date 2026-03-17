<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Velotech') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card Clientes -->
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-xl transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total Clientes</p>
                            <h3 class="text-white text-3xl font-bold mt-1">{{ $stats['total_clientes'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Servicios -->
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-xl transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider">Servicios Activos</p>
                            <h3 class="text-white text-3xl font-bold mt-1">{{ $stats['servicios_activos'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Pagos Pendientes -->
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 shadow-xl transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium uppercase tracking-wider">Pagos Pendientes</p>
                            <h3 class="text-white text-3xl font-bold mt-1">{{ $stats['pagos_pendientes'] }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Card Balance Mes -->
                <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl p-6 shadow-xl transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-rose-100 text-sm font-medium uppercase tracking-wider">Ingresos Mes</p>
                            <h3 class="text-white text-3xl font-bold mt-1">${{ number_format($stats['ingresos_mes'], 2) }}</h3>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sección Inferior: Resumen Rápido -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Resumen de Operaciones</h3>
                    <div class="flex space-x-2">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Caja Saludable</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center border-t border-gray-50 pt-8">
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase">Egresos Octubre</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1 text-red-500">-${{ number_format($stats['egresos_mes'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase">Pagos Vencidos</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1 {{ $stats['pagos_vencidos'] > 0 ? 'text-rose-600' : 'text-gray-900' }}">
                            {{ $stats['pagos_vencidos'] }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-semibold uppercase">Balance Neto</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1 text-emerald-600">
                            +${{ number_format($stats['ingresos_mes'] - $stats['egresos_mes'], 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
