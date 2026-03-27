<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
            {{ __('Panel Analítico') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- Total Clients -->
            <div class="bg-[#0f172a] rounded-2xl p-6 border border-[#1e293b] shadow-glow-cyan relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-sm font-medium text-slate-400 tracking-wider uppercase mb-1">Clientes Totales</h3>
                <p class="text-3xl font-black text-white glow-cyan">{{ number_format($totalClients) }}</p>
            </div>
            
            <!-- Active Subscriptions -->
            <div class="bg-[#0f172a] rounded-2xl p-6 border border-[#1e293b] shadow-glow-cyan relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <h3 class="text-sm font-medium text-slate-400 tracking-wider uppercase mb-1">Servicios Activos</h3>
                <p class="text-3xl font-black text-[#00f6ff] glow-cyan">{{ number_format($activeSubscriptions) }}</p>
            </div>

            <!-- Net Income -->
            <div class="bg-[#0f172a] rounded-2xl p-6 border border-[#1e293b] shadow-glow-cyan relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-sm font-medium text-slate-400 tracking-wider uppercase mb-1">Margen del Mes</h3>
                <p class="text-3xl font-black {{ $netIncome >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    ${{ number_format($netIncome, 2) }}
                </p>
            </div>
            
            <!-- Gross Revenue -->
            <div class="bg-[#0f172a] rounded-2xl p-6 border border-[#1e293b] shadow-glow-cyan relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <h3 class="text-sm font-medium text-slate-400 tracking-wider uppercase mb-1">Ingresos del Mes</h3>
                <p class="text-3xl font-black text-white glow-cyan">${{ number_format($currentMonthSales, 2) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Line Chart -->
            <div class="lg:col-span-2 bg-[#0f172a] border border-[#1e293b] rounded-2xl p-6 shadow-glow-cyan flex flex-col">
                <h3 class="text-lg font-semibold text-white mb-4 glow-cyan flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    Histórico de Ingresos (6 Meses)
                </h3>
                <div class="relative flex-1 w-full min-h-[250px]">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>

            <!-- Alerts / Expiring Section -->
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-6 shadow-[0_0_15px_rgba(239,68,68,0.1)] flex flex-col">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Alertas Críticas
                </h3>
                
                <div class="flex-1 overflow-y-auto pr-2 space-y-3">
                    @forelse($expiringSubscriptions as $sub)
                        <div class="bg-[#0B1120] border border-rose-500/30 p-4 rounded-xl hover:border-rose-500/60 transition-colors">
                            <div class="flex justify-between items-start mb-1">
                                <p class="font-bold text-slate-200 text-sm">{{ $sub->client->name }}</p>
                                <span class="bg-rose-500/20 text-rose-400 text-[10px] px-2 py-0.5 rounded font-bold border border-rose-500/30">
                                    {{ \Carbon\Carbon::parse($sub->end_date)->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400">{{ $sub->service->name }}</p>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-center p-6">
                            <svg class="w-12 h-12 text-[#1e293b] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm font-medium text-slate-400">Sin vencimientos cercanos</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-6">
            <!-- Sales by Service Bar Chart -->
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-6 shadow-glow-cyan flex flex-col">
                <h3 class="text-lg font-semibold text-white mb-4 glow-cyan flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Distribución de Ventas por Servicio
                </h3>
                <div class="relative flex-1 w-full min-h-[250px]">
                    <canvas id="servicesChart"></canvas>
                </div>
            </div>

            <!-- Client Distribution Pie Chart -->
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-6 shadow-glow-cyan flex flex-col">
                <h3 class="text-lg font-semibold text-white mb-4 glow-cyan flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Retención de Clientes
                </h3>
                <div class="relative flex-1 w-full min-h-[250px] flex justify-center">
                    <canvas id="clientsChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart.js CDN and Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.font.family = "'Outfit', sans-serif";

            // 1. Income Line Chart
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            
            // Create Gradient for Line Chart
            let gradient = incomeCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(0, 246, 255, 0.5)');   
            gradient.addColorStop(1, 'rgba(0, 246, 255, 0.0)');

            new Chart(incomeCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_reverse($months)) !!},
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: {!! json_encode(array_reverse($salesData)) !!},
                        borderColor: '#00f6ff',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#0B1120',
                        pointBorderColor: '#00f6ff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: '#1e293b', drawBorder: false },
                            ticks: { callback: function(value) { return '$' + value; } }
                        },
                        x: { grid: { display: false, drawBorder: false } }
                    }
                }
            });

            // 2. Sales by Service Bar Chart
            const servicesCtx = document.getElementById('servicesChart').getContext('2d');
            new Chart(servicesCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($serviceLabels) !!},
                    datasets: [{
                        label: 'Total Vendido ($)',
                        data: {!! json_encode($serviceTotals) !!},
                        backgroundColor: '#3b82f6',
                        hoverBackgroundColor: '#00f6ff',
                        borderRadius: 6,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#1e293b' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 3. Client Distribution Pie Chart
            const clientsCtx = document.getElementById('clientsChart').getContext('2d');
            new Chart(clientsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Activos ('+{{ $activeClientsCount }}+')', 'Inactivos ('+{{ $inactiveClientsCount }}+')'],
                    datasets: [{
                        data: [{{ $activeClientsCount }}, {{ $inactiveClientsCount }}],
                        backgroundColor: ['#00f6ff', '#1e293b'],
                        hoverBackgroundColor: ['#3b82f6', '#334155'],
                        borderWidth: 2,
                        borderColor: '#0f172a'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 20 } }
                    }
                }
            });

        });
    </script>
</x-app-layout>
