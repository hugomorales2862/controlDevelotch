<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                Bienvenido, <span class="text-[#00f6ff]">{{ $client->contact_name ?? $client->name }}</span>
            </h2>
            <form method="POST" action="{{ route('client.auth.logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0B1120] border border-[#1e293b] text-slate-400 hover:border-rose-500/50 hover:text-rose-400 transition-all text-xs font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Salir
                </button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <!-- Iniciar nuevo chat -->
        <div class="bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 mb-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#00f6ff] to-indigo-600"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#00f6ff]/5 rounded-full blur-3xl"></div>
            <h3 class="text-lg font-black text-white mb-1 relative z-10">💬 ¿Necesitas ayuda?</h3>
            <p class="text-slate-500 text-sm mb-6 relative z-10 italic">Describe tu problema y nuestro equipo te responderá lo antes posible.</p>

            <form method="POST" action="{{ route('portal.tickets.create') }}" class="relative z-10">
                @csrf
                <div class="flex gap-4">
                    <textarea name="message" rows="2" required
                              class="flex-1 bg-[#0B1120] border border-[#1e293b] focus:border-[#00f6ff] rounded-2xl text-slate-100 text-sm py-4 px-6 transition-all resize-none placeholder:italic placeholder:text-slate-600"
                              placeholder="Ej: Tengo un problema con mi servicio de hosting..."></textarea>
                    <button type="submit"
                            style="background: linear-gradient(135deg, #00f2fe, #4facfe);"
                            class="px-8 rounded-2xl font-black text-xs text-[#0B1120] uppercase tracking-widest hover:shadow-[0_0_25px_rgba(0,246,255,0.4)] transition-all duration-300 whitespace-nowrap">
                        Iniciar Chat
                    </button>
                </div>
            </form>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Soporte Card -->
            <a href="{{ route('portal.tickets') }}" class="group relative bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 overflow-hidden hover:border-[#00f6ff]/50 transition-all duration-500 shadow-xl">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#00f6ff]/10 rounded-full blur-3xl group-hover:bg-[#00f6ff]/20 transition-all"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6 border border-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Mis Conversaciones</h3>
                    <p class="text-slate-400 text-sm mb-6 flex-grow">Consulta tus conversaciones abiertas con nuestro equipo de soporte.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#00f6ff]">{{ $activeTicketsCount }} Activos</span>
                        <div class="p-2 rounded-full bg-white/5 group-hover:bg-[#00f6ff] group-hover:text-[#0B1120] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Facturas Card -->
            <a href="{{ route('portal.invoices') }}" class="group relative bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 overflow-hidden hover:border-amber-500/50 transition-all duration-500 opacity-80 hover:opacity-100">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-500 mb-6 border border-amber-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Mis Facturas</h3>
                    <p class="text-slate-400 text-sm mb-6 flex-grow">Descarga y gestiona tus comprobantes fiscales y facturas electrónicas.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-widest text-amber-500">Próximamente</span>
                        <div class="p-2 rounded-full bg-white/5">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Pagos Card -->
            <a href="{{ route('portal.payments') }}" class="group relative bg-[#0f172a] rounded-3xl border border-[#1e293b] p-8 overflow-hidden hover:border-emerald-500/50 transition-all duration-500 opacity-80 hover:opacity-100">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 mb-6 border border-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Estado de Pagos</h3>
                    <p class="text-slate-400 text-sm mb-6 flex-grow">Verifica tus pagos realizados, pendientes y genera recibos de caja.</p>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Próximamente</span>
                        <div class="p-2 rounded-full bg-white/5">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
