@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="min-h-screen bg-gray-900 flex items-center justify-center">
        <div class="w-full max-w-6xl px-4 text-center">

            {{-- Contenedor Interactivo --}}
            <div
                id="logo-container"
                class="relative w-full max-w-5xl mx-auto flex justify-center items-center cursor-pointer select-none"
                onclick="toggleAnimation()"
            >
                {{-- 1. IMAGEN FINAL (logofinal.png) --}}
                {{-- opacity-0 en vez de hidden para la transición suave. z-20 para estar encima. --}}
                <img
                    id="final-img"
                    src="{{ asset('images/logofinal.png') }}"
                    alt="BASE Logo Completo"
                    class="absolute inset-0 z-20 w-full opacity-0 transition-opacity duration-300"
                    style="filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.15));"
                />

                {{-- 2. CAPA ALTAVOCES (Animación) --}}
                <img
                    id="speakers-img"
                    src="{{ asset('images/altavoces.png') }}"
                    alt="Altavoces"
                    class="absolute z-0 w-full transition-all duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] transform scale-50 opacity-0"
                    style="filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.15));"
                />

                {{-- 3. CAPA CABEZA (Base) --}}
                {{--
                   IMPORTANTE: Esta imagen es 'relative' y mantiene la altura del contenedor.
                   Nunca le pondremos 'hidden'. Solo bajaremos su opacidad a 0.
                --}}
                <img
                    id="head-img"
                    src="{{ asset('images/logo.png') }}"
                    alt="BASE Logo Head"
                    class="relative z-10 w-full transition-all duration-300 hover:scale-[1.02]"
                    style="filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.15));"
                />
            </div>

            {{-- Texto BASE --}}
            {{-- Mantenemos el margen negativo y el z-index alto --}}
            <h1 class="text-white text-8xl font-bold tracking-widest -mt-16 ml-4 relative z-30 pointer-events-none" style="text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);">
                BASE
            </h1>
        </div>
    </div>

    <script>
        let isExpanded = false;

        function toggleAnimation() {
            const speakers = document.getElementById('speakers-img');
            const head = document.getElementById('head-img');
            const finalImg = document.getElementById('final-img');

            if (!isExpanded) {
                // --- ABRIR ---

                // 1. Aseguramos que las partes móviles se ven (por si acaso)
                speakers.classList.remove('opacity-0', 'scale-50');
                speakers.classList.add('opacity-100', 'scale-100'); // Animación de salida

                // 2. Esperar a que termine la animación (700ms) para hacer el cambio visual
                setTimeout(() => {
                    if (speakers.classList.contains('scale-100')) {
                        // Hacemos el cambio usando OPACIDAD, no display:none
                        finalImg.classList.remove('opacity-0');
                        finalImg.classList.add('opacity-100');

                        // Ocultamos las partes separadas (pero head sigue ocupando espacio invisible)
                        head.classList.add('opacity-0');
                        speakers.classList.add('opacity-0');
                    }
                }, 700);

                isExpanded = true;

            } else {
                // --- CERRAR ---

                // 1. Restaurar visibilidad de las partes separadas inmediatamente
                finalImg.classList.remove('opacity-100');
                finalImg.classList.add('opacity-0');

                head.classList.remove('opacity-0');
                // speakers vuelve a opacity-100 momentáneamente para animarse hacia adentro
                speakers.classList.remove('opacity-0');

                // 2. Forzar un pequeño reflow para que el navegador pille el cambio antes de animar
                requestAnimationFrame(() => {
                    speakers.classList.remove('scale-100', 'opacity-100');
                    speakers.classList.add('scale-50', 'opacity-0'); // Animación hacia adentro
                });

                isExpanded = false;
            }
        }
    </script>
@endsection