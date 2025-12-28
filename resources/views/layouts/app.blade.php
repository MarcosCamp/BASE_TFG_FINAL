<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BASE') }} - @yield('title', 'Eventos y Conciertos')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .nav-container {
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-900">
    
    @include('layouts.navigation')

    @if (isset($header))
        <header class="bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main>
        {{-- ESTO ES LO QUE TE FALTABA: --}}
        {{-- 1. Si la vista usa $slot (Perfil/Dashboard), lo mostramos --}}
        {{ $slot ?? '' }}
        
        {{-- 2. Si la vista usa @section('content') (Eventos/Home), lo mostramos --}}
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-auto border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <img src="{{ asset('images/logofinal.png') }}" alt="BASE" class="h-12 w-auto mb-4" />
                    <p class="text-gray-400 text-sm">Tu plataforma de eventos y conciertos</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Eventos</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} BASE. Todos los derechos reservados.
            </div>
        </div>
    </footer>
</body>
</html>