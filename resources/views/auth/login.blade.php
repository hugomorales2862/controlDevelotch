<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0B1120] relative overflow-hidden">
        <!-- Background Tech Patterns -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-5" style="background-image: radial-gradient(#00f6ff 1px, transparent 1px); background-size: 32px 32px;"></div>
        
        <!-- Glowing Orb -->
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-[#00f6ff] opacity-[0.15] rounded-full blur-[100px] pointer-events-none z-0"></div>

        <div class="relative z-10 sm:max-w-md w-full px-8 py-10 bg-[#0f172a]/90 backdrop-blur-xl shadow-[0_0_40px_rgba(0,246,255,0.1)] border border-[#1e293b] sm:rounded-3xl">
            
            <div class="flex flex-col items-center justify-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-[#0B1120] border border-glow-cyan flex items-center justify-center shadow-glow-cyan mb-4">
                    <svg class="w-10 h-10 text-[#00f6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-white tracking-tight text-center">DEVELOTECH<span class="text-[#00f6ff] block text-xs font-semibold tracking-[0.3em] mt-1">GLOBAL</span></h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block font-medium text-xs text-slate-400 uppercase tracking-widest mb-1">Usuario / Email</label>
                    <input id="email" class="block mt-1 w-full bg-[#0B1120]/50 border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-700 transition-colors py-3 px-4" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@admin.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block font-medium text-xs text-slate-400 uppercase tracking-widest">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-[#00f6ff] hover:text-white transition-colors" href="{{ route('password.request') }}">
                                {{ __('Olvidaste tu clave?') }}
                            </a>
                        @endif
                    </div>

                    <input id="password" class="block mt-1 w-full bg-[#0B1120]/50 border border-[#1e293b] focus:border-[#00f6ff] focus:ring focus:ring-[#00f6ff]/20 rounded-xl text-white shadow-sm placeholder-slate-700 transition-colors py-3 px-4"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="••••••••" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-2">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-[#1e293b] bg-[#0B1120] text-[#00f6ff] focus:ring-[#00f6ff]/30" name="remember">
                        <span class="ms-2 text-sm text-slate-400">Mantener sesión iniciada</span>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-glow-cyan text-sm font-bold text-[#0B1120] bg-gradient-to-r from-[#00f6ff] to-[#3b82f6] hover:from-[#3b82f6] hover:to-[#00f6ff] focus:outline-none transition-all duration-300 uppercase tracking-widest">
                        Acceder al Panel
                    </button>
                </div>
                
                <div class="text-center pt-6">
                    <p class="text-xs text-slate-600 font-medium">Restricted Access. Authorized Personnel Only.</p>
                </div>
            </form>
        </div>
        
        <!-- Bottom left decoration -->
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#3b82f6] opacity-[0.05] rounded-tr-full blur-[80px] pointer-events-none z-0"></div>
    </div>
</x-guest-layout>
