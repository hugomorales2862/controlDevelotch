<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DEVELOTECH GLOBAL - Innovation & Technology Solutions">
    <meta property="og:title" content="DEVELOTECH GLOBAL | Control System" />
    <meta property="og:description" content="Sistema de gestión integral para servicios tecnológicos y hosting." />
    <meta property="og:image" content="{{ asset('develotech-global.png') }}" />
    <meta property="og:type" content="website" />
    <title>DEVELOTECH GLOBAL | Control System</title>

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #00f2fe;
            --secondary: #4facfe;
            --accent: #f53003;
            --bg-dark: #050505;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: #ffffff;
            margin: 0;
            overflow-x: hidden;
        }

        h1, h2, h3, .font-outfit {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.8);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(0, 242, 254, 0.1) 0%, transparent 70%);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.4);
        }

        .tech-grid {
            mask-image: radial-gradient(circle at center, black, transparent 80%);
            background-image: 
                linear-gradient(rgba(0, 242, 254, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 242, 254, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col items-center justify-center relative">
    <!-- Tech Base Layer -->
    <div class="absolute inset-0 tech-grid pointer-events-none opacity-40"></div>
    <div class="absolute inset-0 hero-gradient pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full p-6 flex justify-between items-center z-50 lg:px-12">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-xl font-outfit font-bold tracking-tighter">DEVELOTECH <span class="text-cyan-400">GLOBAL</span></span>
        </div>

        @if (Route::has('login'))
            <div class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="glass px-6 py-2 rounded-full text-sm font-medium hover:bg-white/10 transition-all">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="glass px-6 py-2 rounded-full text-sm font-medium hover:bg-white/10 transition-all">Iniciar Sesión</a>
                @endauth
            </div>
        @endif
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 w-full max-w-6xl px-6 flex flex-col lg:flex-row items-center gap-12 lg:gap-24 py-24">
        <!-- Text Section -->
        <div class="flex-1 text-center lg:text-left">
            <div class="inline-block px-4 py-1 rounded-full glass text-xs font-bold text-cyan-400 mb-6 uppercase tracking-widest">
                ERP/CRM Enterprise Solution
            </div>
            <h1 class="text-5xl lg:text-7xl font-outfit font-extrabold leading-[1.1] mb-6">
                Innovación & <br>
                <span class="gradient-text">Tecnología</span> <br>
                <span class="text-white/90">Sin Límites.</span>
            </h1>
            <p class="text-lg text-white/60 mb-10 max-w-xl leading-relaxed">
                Potenciamos tu infraestructura tecnológica con soluciones inteligentes de gestión, monitoreo de servidores y automatización financiera.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                <a href="{{ route('login') }}" class="btn-primary px-10 py-4 rounded-xl font-bold text-black text-center w-full sm:w-auto">
                    ACCEDER AL SISTEMA
                </a>
                <a href="#" class="glass px-10 py-4 rounded-xl font-bold text-white text-center w-full sm:w-auto hover:bg-white/5">
                    SOPORTE TÉCNICO
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 flex flex-wrap gap-8 justify-center lg:justify-start opacity-70">
                <div>
                    <div class="text-2xl font-bold font-outfit">99.9%</div>
                    <div class="text-xs uppercase tracking-widest text-white/40">Uptime VPS</div>
                </div>
                <div class="h-10 w-px bg-white/10 hidden sm:block"></div>
                <div>
                    <div class="text-2xl font-bold font-outfit">+500</div>
                    <div class="text-xs uppercase tracking-widest text-white/40">Servicios Activos</div>
                </div>
                <div class="h-10 w-px bg-white/10 hidden sm:block"></div>
                <div>
                    <div class="text-2xl font-bold font-outfit">24/7</div>
                    <div class="text-xs uppercase tracking-widest text-white/40">Monitorización</div>
                </div>
            </div>
        </div>

        <!-- Graphic Section -->
        <div class="flex-1 relative w-full max-w-md lg:max-w-none">
            <div class="relative group">
                <!-- Outer Glow -->
                <div class="absolute -inset-4 bg-gradient-to-tr from-cyan-500/20 to-blue-600/20 rounded-3xl blur-2xl group-hover:opacity-100 transition-opacity duration-1000"></div>
                
                <!-- Main Card -->
                <div class="glass p-4 rounded-3xl relative overflow-hidden float-animation">
                    <img src="{{ asset('develotech-global.png') }}" alt="Technology Visual" class="rounded-2xl w-full h-auto object-cover grayscale opacity-80 brightness-110">
                    
                    <!-- Overlay Info -->
                    <div class="absolute bottom-8 left-8 right-8">
                        <div class="glass p-6 rounded-2xl border-white/20">
                            <h3 class="text-lg font-outfit font-bold mb-1">DEVELOTECH | GLOBAL</h3>
                            <p class="text-xs text-white/60">Innovation & Technology Solutions</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full border-2 border-bg-dark bg-cyan-900 flex items-center justify-center text-[10px]">DS</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-bg-dark bg-blue-900 flex items-center justify-center text-[10px]">AI</div>
                                    <div class="w-8 h-8 rounded-full border-2 border-bg-dark bg-red-900 flex items-center justify-center text-[10px]">DB</div>
                                </div>
                                <div class="px-3 py-1 rounded-full bg-cyan-400/20 text-cyan-400 text-[10px] font-bold">SYSTEM ACTIVE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto w-full p-8 text-center text-white/30 text-xs tracking-widest uppercase">
        &copy; {{ date('Y') }} DEVELOTECH GLOBAL. TODOS LOS DERECHOS RESERVADOS.
    </footer>
</body>
</html>
