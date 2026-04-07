<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('portal.dashboard') }}" class="text-slate-400 hover:text-[#00f6ff] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="font-semibold text-2xl text-white tracking-tight">
                {{ $title }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-24 px-4 text-center">
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 rounded-full bg-[#0f172a] border border-[#1e293b] flex items-center justify-center text-[#1e293b]">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
        </div>
        <h3 class="text-3xl font-black text-white mb-4 uppercase tracking-tighter">Próximamente</h3>
        <p class="text-slate-500 text-lg max-w-md mx-auto leading-relaxed italic">
            Estamos trabajando para que puedas consultar tus <strong>{{ strtolower($title) }}</strong> directamente desde aquí. Esta funcionalidad estará disponible en la siguiente actualización.
        </p>
        <div class="mt-12">
            <a href="{{ route('portal.dashboard') }}" class="px-8 py-3 bg-[#0B1120] border border-[#1e293b] rounded-xl text-xs font-bold text-slate-400 uppercase tracking-widest hover:border-[#00f6ff] hover:text-[#00f6ff] transition-all">
                Volver al Menú
            </a>
        </div>
    </div>
</x-app-layout>
