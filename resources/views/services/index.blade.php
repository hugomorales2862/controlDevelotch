<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight glow-cyan">
                {{ __('Planes SaaS') }}
            </h2>
            <a href="{{ route('services.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl font-bold text-xs text-[#0B1120] uppercase tracking-widest bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 shadow-glow-cyan">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Nuevo Plan
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $service)
            <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] hover:border-glow-cyan transition-all duration-300 flex flex-col group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00f6ff] to-[#3b82f6]"></div>
                <div class="p-6 flex-1 flex flex-col z-10">
                    <h3 class="text-xl font-bold text-white mb-2">{{ $service->name }}</h3>
                    <div class="flex items-baseline mb-6 border-b border-[#1e293b] pb-4">
                        <span class="text-3xl font-black text-[#00f6ff] glow-cyan">${{ number_format($service->price, 2) }}</span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-2">/ {{ $service->duration_days }} días</span>
                    </div>
                    
                    @if($service->features)
                        <div class="text-sm text-slate-400 flex-1 mb-6">
                            <p class="font-bold text-slate-300 uppercase tracking-widest text-[10px] mb-3">Características Incluidas</p>
                            <ul class="space-y-3">
                                @foreach(explode("\n", $service->features) as $feature)
                                    @if(trim($feature))
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 text-[#00f6ff] mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            {{ trim($feature) }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-auto pt-4 flex items-center justify-between">
                        <a href="{{ route('services.edit', $service) }}" class="text-[10px] bg-[#00f6ff]/10 px-3 py-1.5 rounded border border-[#00f6ff]/20 font-bold text-[#00f6ff] hover:bg-[#00f6ff] hover:text-[#0B1120] uppercase tracking-widest transition-colors">Configurar Plan</a>
                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] bg-rose-500/10 px-3 py-1.5 rounded border border-rose-500/20 font-bold text-rose-500 hover:bg-rose-500 hover:text-white uppercase tracking-widest transition-colors">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-[#0f172a] rounded-2xl border border-[#1e293b] p-12 text-center shadow-glow-cyan">
                <svg class="mx-auto h-12 w-12 text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <h3 class="text-lg font-medium text-white">No hay planes creados</h3>
                <p class="mt-1 text-slate-400 text-sm">Crea tu primer servicio SaaS para vender.</p>
                <a href="{{ route('services.create') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-[#00f6ff] text-[#0B1120] rounded-xl text-sm font-bold uppercase tracking-widest shadow-glow-cyan hover:bg-white transition-colors">Crear Plan</a>
            </div>
        @endforelse
    </div>
    
    @if($services->hasPages())
        <div class="mt-8">
            {{ $services->links() }}
        </div>
    @endif
</x-app-layout>
