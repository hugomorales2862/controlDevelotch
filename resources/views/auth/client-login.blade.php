<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso de Ayuda | DEVELOTECH GLOBAL</title>
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
            <h1 class="text-3xl font-bold font-outfit uppercase tracking-tighter">Portal de <span class="gradient-text">Ayuda</span></h1>
            <p class="text-slate-500 text-sm mt-2">Ingresa tu correo registrado para recibir un código de acceso.</p>
        </div>

        <div class="glass p-8 rounded-3xl shadow-2xl">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 text-sm italic">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('client.auth.send-token') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 italic">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="block w-full bg-[#0B1120] border border-[#1e293b] focus:border-[#00f2fe] rounded-2xl text-white py-4 px-5 transition-all text-center">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
                </div>

                <button type="submit" 
                        style="background-color: #00f2fe; color: #0B1120;"
                        class="w-full py-4 bg-gradient-to-r from-[#00f2fe] to-[#4facfe] rounded-2xl font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all shadow-[0_0_30px_rgba(0,242,254,0.2)]">
                    Solicitar Código de Acceso
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <a href="/" class="text-[10px] text-slate-500 hover:text-white uppercase font-bold tracking-widest transition-colors italic">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
