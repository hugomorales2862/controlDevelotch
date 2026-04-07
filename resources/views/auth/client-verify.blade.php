<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificar Acceso | DEVELOTECH GLOBAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #050505; color: white; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .gradient-text { background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold font-outfit uppercase tracking-tighter">Verificar <span class="gradient-text">Código</span></h1>
            <p class="text-slate-500 text-sm mt-2">Hemos enviado un código a <strong>{{ $email }}</strong></p>
        </div>

        <div class="glass p-8 rounded-3xl shadow-2xl relative overflow-hidden">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-xs italic">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('client.auth.verify.post') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div>
                    <label for="token" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 italic">Código de 6 dígitos</label>
                    <input id="token" type="text" name="token" required maxlength="6" autofocus
                           class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f2fe] rounded-2xl text-[#00f2fe] py-4 px-5 transition-all text-center text-2xl font-black tracking-[1em] placeholder:tracking-normal"
                           placeholder="000000">
                    <x-input-error :messages="$errors->get('token')" class="mt-2 text-rose-400" />
                </div>

                <button type="submit" 
                        style="background-color: #0B1120; color: #00f2fe; border: 1px solid #00f2fe;"
                        class="w-full py-4 bg-[#0B1120] border border-[#00f2fe] rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#00f2fe] hover:text-[#0B1120] transition-all shadow-[0_0_20px_rgba(0,242,254,0.1)]">
                    Validar e Iniciar
                </button>
            </form>

            @if(session('support_token_debug'))
                <div class="mt-6 p-3 bg-indigo-500/5 border border-indigo-500/10 rounded-xl text-[10px] text-indigo-400/50 text-center font-mono italic">
                    DEBUG: {{ session('support_token_debug') }}
                </div>
            @endif

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <a href="{{ route('client.auth.login') }}" class="text-[10px] text-slate-500 hover:text-white uppercase font-bold tracking-widest transition-colors italic">Reintentar con otro correo</a>
            </div>
        </div>
    </div>
</body>
</html>
