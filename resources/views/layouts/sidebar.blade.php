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
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
            Panel de Control
        </x-sidebar-link>

        <!-- ADMINISTRACIÓN -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Administración</p>
        </div>
        <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')" icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
            Usuarios Internos
        </x-sidebar-link>
        <x-sidebar-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            Roles y Permisos
        </x-sidebar-link>
        <x-sidebar-link :href="route('audit-logs.index')" :active="request()->routeIs('audit-logs.*')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
            Auditoría de Acciones
        </x-sidebar-link>

        <!-- COMERCIAL -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Comercial</p>
        </div>
        <x-sidebar-link :href="route('prospects.index')" :active="request()->routeIs('prospects.*')" icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
            Prospectos
        </x-sidebar-link>
        <x-sidebar-link :href="route('clients.index')" :active="request()->routeIs('clients.*')" icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            Clientes
        </x-sidebar-link>
        <x-sidebar-link :href="route('quotes.index')" :active="request()->routeIs('quotes.*')" icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            Cotizaciones
        </x-sidebar-link>
        <x-sidebar-link :href="route('services.index')" :active="request()->routeIs('services.*')" icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
            Productos y Servicios
        </x-sidebar-link>

        <!-- OPERACIONES -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Operaciones</p>
        </div>
        <x-sidebar-link :href="route('projects.index')" :active="request()->routeIs('projects.*')" icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
            Proyectos
        </x-sidebar-link>
        <x-sidebar-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
            Tareas
        </x-sidebar-link>
        <x-sidebar-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')" icon="M5 13l4 4L19 7">
            Servicios Activos
        </x-sidebar-link>
        <x-sidebar-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')" icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            Soporte y Tickets
        </x-sidebar-link>

        <!-- FINANCIERO -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Financiero</p>
        </div>
        <x-sidebar-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')" icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            Facturación
        </x-sidebar-link>
        <x-sidebar-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
            Pagos
        </x-sidebar-link>
        <x-sidebar-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
            Cobros Recurrentes
        </x-sidebar-link>
        <x-sidebar-link :href="route('petty-cash.index')" :active="request()->routeIs('petty-cash.*')" icon="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
            Caja Chica y Cuentas
        </x-sidebar-link>

        <!-- INFRAESTRUCTURA -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Infraestructura</p>
        </div>
        <x-sidebar-link :href="route('servers.index')" :active="request()->routeIs('servers.*')" icon="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01">
            Servidores VPS
        </x-sidebar-link>
        <x-sidebar-link :href="route('credentials.index')" :active="request()->routeIs('credentials.*')" icon="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
            Credenciales Técnicas
        </x-sidebar-link>
        <x-sidebar-link :href="route('domains.index')" :active="request()->routeIs('domains.*')" icon="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9h18">
            Dominios
        </x-sidebar-link>
        
        <!-- COMUNICACIONES -->
        <div class="pt-4 pb-2">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Comunicaciones</p>
        </div>
        <x-sidebar-link :href="route('dashboard')" :active="false" icon="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z">
            Envío de Correos
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
                <p class="text-xs text-[#00f6ff] font-semibold uppercase tracking-wide truncate">Admin</p>
            </div>
        </div>
    </div>
</aside>
