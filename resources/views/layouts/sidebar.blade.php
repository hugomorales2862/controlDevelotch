<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0f172a] border-r border-[#1e293b] flex flex-col transition-transform transform -translate-x-full md:translate-x-0 hidden md:flex">
    <!-- Branding -->
    <div class="h-20 flex items-center justify-center border-b border-[#1e293b] px-6">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 rounded-xl bg-[#0B1120] border border-[#1e293b] group-hover:border-glow-cyan flex items-center justify-center shadow-glow-cyan transition-all">
                <svg class="w-6 h-6 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <span class="text-white font-bold text-lg tracking-tight glow-cyan">DEVELOTECH</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
            Panel de Control
        </x-sidebar-link>

        <x-sidebar-link :href="route('applications.index')" :active="request()->routeIs('applications.*')" icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
            Mis Aplicaciones SaaS
        </x-sidebar-link>

        <x-sidebar-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            Gestión de Clientes
        </x-sidebar-link>

        <x-sidebar-link :href="route('services.index')" :active="request()->routeIs('services.*')" icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
            Planes y Precios (Tiers)
        </x-sidebar-link>

        <x-sidebar-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')" icon="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
            Suscripciones Activas
        </x-sidebar-link>

        <div class="pt-6 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Módulo Financiero</p>
        </div>

        <x-sidebar-link :href="route('sales.index')" :active="request()->routeIs('sales.*')" icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" color="text-[#00f6ff]">
            Ventas e Ingresos
        </x-sidebar-link>

        <x-sidebar-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" icon="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" color="text-rose-400">
            Egresos Operativos
        </x-sidebar-link>

        <div class="pt-6 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Análisis y Cierre</p>
        </div>

        <x-sidebar-link :href="route('reports.index')" :active="request()->routeIs('reports.*')" icon="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            Generar Reportes
        </x-sidebar-link>
    </nav>

    <!-- User Profile Footer -->
    <div class="border-t border-[#1e293b] p-4 bg-[#0B1120]/50">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#3b82f6] to-[#00f6ff] flex items-center justify-center text-white font-bold shadow-glow-cyan text-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-3 flex-1 overflow-hidden">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-[#00f6ff] font-semibold uppercase tracking-wide truncate">{{ Auth::user()->getRoleNames()->first() ?? 'Usuario' }}</p>
            </div>
        </div>
    </div>
</aside>
