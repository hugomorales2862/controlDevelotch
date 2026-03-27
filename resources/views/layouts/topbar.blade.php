<div class="h-16 bg-[#0B1120] border-b border-[#1e293b] flex items-center justify-between px-4 sm:px-6 lg:px-8 xl:hidden sticky top-0 z-30">
    <div class="flex items-center">
        <!-- Logo for Mobile -->
        <a href="{{ route('dashboard') }}" class="flex flex-shrink-0 items-center">
            <svg class="h-8 w-auto text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </a>
    </div>
    
    <div class="flex items-center space-x-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">
                Salir
            </button>
        </form>
    </div>
</div>

<!-- Desktop Topbar right menu -->
<div class="hidden md:flex h-16 bg-[#0f172a]/50 backdrop-blur-sm border-b border-[#1e293b] items-center justify-end px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center text-sm font-medium text-slate-300 hover:text-white transition-colors bg-[#1e293b] px-4 py-2 rounded-xl hover:border-glow-cyan border border-transparent">
            <svg class="h-4 w-4 mr-2 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Cerrar Sistema
        </button>
    </form>
</div>
