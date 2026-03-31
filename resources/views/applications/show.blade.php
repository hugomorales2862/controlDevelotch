<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white tracking-tight flex items-center">
                {{ __('Detalles de la Aplicación') }}
            </h2>
            <div class="space-x-2 flex items-center">
                <a href="{{ route('applications.index') }}" class="text-sm font-medium text-slate-400 hover:text-white bg-[#0f172a] border border-[#1e293b] px-4 py-2 rounded-lg transition-colors">Volver</a>
                <a href="{{ route('applications.edit', $application) }}" class="text-sm font-medium text-[#0B1120] bg-[#00f6ff] hover:bg-white border border-transparent px-4 py-2 rounded-lg shadow-glow-cyan transition-all">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Application Info Card -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">{{ $application->name }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $application->status === 'active' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                        {{ $application->status === 'active' ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Descripción</p>
                        <p class="text-sm font-medium text-white">{{ $application->description ?: 'Sin descripción' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">URL</p>
                        <p class="text-sm font-medium text-white">
                            @if($application->url)
                                <a href="{{ $application->url }}" target="_blank" class="hover:text-[#00f6ff] transition-colors">{{ $application->url }}</a>
                            @else
                                No especificada
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="bg-[#0f172a] rounded-2xl shadow-[0_0_20px_rgba(0,246,255,0.05)] border border-[#1e293b] overflow-hidden">
            <div class="p-6 sm:p-8">
                <h3 class="text-lg font-bold text-white mb-4">Servicios Asociados</h3>
                @if($application->services->count() > 0)
                    <div class="space-y-3">
                        @foreach($application->services as $service)
                            <div class="flex items-center justify-between p-4 bg-[#0B1120]/50 rounded-lg border border-[#1e293b]">
                                <div>
                                    <h4 class="font-medium text-white">{{ $service->name }}</h4>
                                    <p class="text-sm text-slate-400">{{ $service->description }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $service->status === 'active' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $service->status === 'active' ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400">No hay servicios asociados a esta aplicación.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>