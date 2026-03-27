<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan flex items-center">
                <svg class="w-6 h-6 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                {{ __('Mis Aplicaciones SaaS') }}
            </h2>
            <a href="{{ route('applications.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] shadow-glow-cyan transition-all duration-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva App
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($applications as $app)
            <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] flex flex-col group relative overflow-hidden transition-all duration-300 hover:border-[#00f6ff]/50">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6]"></div>
                <div class="p-6 flex-1 flex flex-col z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="h-12 w-12 rounded-xl bg-[#0B1120] flex items-center justify-center text-[#00f6ff] font-bold text-xl border border-[#1e293b] shadow-glow-cyan">
                            {{ substr($app->name, 0, 1) }}
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-widest
                            @if($app->status == 'active') bg-[#00f6ff]/10 text-[#00f6ff] border border-[#00f6ff]/20
                            @else bg-rose-500/10 text-rose-400 border border-rose-500/20 @endif">
                            {{ $app->status }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-white mb-1 group-hover:glow-cyan transition-all">{{ $app->name }}</h3>
                    @if($app->url)
                        <a href="{{ $app->url }}" target="_blank" class="text-xs text-[#3b82f6] hover:text-[#00f6ff] mb-4 flex items-center">
                            {{ $app->url }}
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    @endif
                    
                    <p class="text-sm text-slate-400 mb-6 flex-1">{{ Str::limit($app->description, 100) ?: 'Sin descripción' }}</p>

                    <div class="flex items-center justify-between pt-4 border-t border-[#1e293b]">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $app->services_count ?? 0 }} Planes Configurados</span>
                        <div class="flex space-x-2">
                            <a href="{{ route('applications.edit', $app) }}" class="text-[10px] text-[#00f6ff] bg-[#00f6ff]/10 border border-[#00f6ff]/20 px-3 py-1.5 rounded uppercase font-bold tracking-widest hover:bg-[#00f6ff] hover:text-[#0B1120] transition-colors">Configurar</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-[#0f172a] rounded-2xl border border-[#1e293b] p-12 text-center shadow-glow-cyan">
                <svg class="mx-auto h-12 w-12 text-[#3b82f6] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-lg font-medium text-white">No tienes aplicaciones registradas</h3>
                <p class="mt-1 text-slate-400 text-sm">Organiza tus planes SaaS creando primero tus aplicaciones (productos o marcas principales).</p>
                <a href="{{ route('applications.create') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-[#00f6ff] text-[#0B1120] rounded-xl text-sm font-bold uppercase tracking-widest shadow-glow-cyan hover:bg-white transition-colors">Crear Primera App</a>
            </div>
        @endforelse
    </div>
    
    @if($applications->hasPages())
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    @endif
</x-app-layout>
