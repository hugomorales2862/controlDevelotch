<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Develotech Global') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">

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
        </style>
    </head>
    <body class="font-sans text-slate-300 antialiased bg-[#0B1120] selection:bg-[#00f6ff] selection:text-[#0B1120]">
        {{ $slot }}

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
                @if(session('status'))
                    Swal.fire({
                        title: 'Listo',
                        text: "{{ session('status') }}",
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
                @if($errors->any())
                    Swal.fire({
                        title: 'Error de inicio de sesión',
                        text: "{{ $errors->first() }}",
                        icon: 'error',
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#00f6ff',
                        confirmButtonText: 'Cerrar'
                    });
                @endif
            });
        </script>
    </body>
</html>
