<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Develotech Global') }} - SaaS Manager</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glow-cyan { text-shadow: 0 0 10px rgba(0,246,255,0.7); }
            .shadow-glow-cyan { box-shadow: 0 0 15px rgba(0,246,255,0.2); }
            .border-glow-cyan { border-color: rgba(0,246,255,0.5); box-shadow: 0 0 10px rgba(0,246,255,0.2); }
            
            /* Custom Scrollbar for dark theme */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background: #0B1120; }
            ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #00f6ff; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#0B1120] text-slate-300 relative overflow-x-hidden selection:bg-[#00f6ff] selection:text-[#0B1120]">
        
        <!-- Tech Background Pattern -->
        <div class="fixed inset-0 z-0 pointer-events-none opacity-5" style="background-image: radial-gradient(#00f6ff 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="min-h-screen flex relative z-10 w-full">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ml-0 md:ml-64 relative z-10">
                
                <!-- Fixed Top Nav (Mobile mostly + Profile) -->
                @include('layouts.topbar')

                @isset($header)
                    <header class="bg-[#0f172a]/80 backdrop-blur-md border-b border-[#1e293b] sticky top-0 z-20">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 bg-transparent p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>

                <footer class="text-center py-6 text-xs text-slate-600 border-t border-[#1e293b] mt-auto">
                    &copy; {{ date('Y') }} Develotech Global - Innovation & Technology Solutions
                </footer>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    Swal.fire({
                        title: '¡Éxito!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#00f6ff',
                        confirmButtonText: 'Entendido'
                    });
                @endif
                @if(session('error'))
                    Swal.fire({
                        title: 'Error',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#00f6ff',
                        confirmButtonText: 'Cerrar'
                    });
                @endif

                document.querySelectorAll('.delete-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "Esta acción no se puede deshacer.",
                            icon: 'warning',
                            showCancelButton: true,
                            background: '#0f172a',
                            color: '#fff',
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#334155',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                document.querySelectorAll('.confirm-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const title = this.dataset.title || '¿Estás seguro?';
                        const text = this.dataset.text || 'Confirma para continuar con esta acción.';
                        const icon = this.dataset.icon || 'question';
                        const confirmText = this.dataset.confirmText || 'Sí, continuar';
                        
                        Swal.fire({
                            title: title,
                            text: text,
                            icon: icon,
                            showCancelButton: true,
                            background: '#0f172a',
                            color: '#fff',
                            confirmButtonColor: '#00f6ff',
                            cancelButtonColor: '#334155',
                            confirmButtonText: confirmText,
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>
