@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="min-h-screen bg-gray-900 flex items-center justify-center overflow-hidden relative">
        
        {{-- Fondo decorativo (FOCO): Centrado, detrás de la cabeza, un poco más grande --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none flex items-center justify-center">
            {{-- 
               - w-[35rem] h-[35rem]: Un poco más grande que antes.
               - bg-indigo-900/20: Color morado sutil.
               - blur-[100px]: Muy desenfocado para efecto "luz".
            --}}
            <div class="w-[35rem] h-[35rem] bg-indigo-900/20 rounded-full blur-[100px]"></div>
        </div>

        <div class="w-full max-w-6xl px-4 text-center relative z-10">

            {{-- Contenedor Interactivo --}}
            <div
                id="logo-container"
                class="relative w-full max-w-5xl mx-auto flex justify-center items-center cursor-pointer select-none group"
                onclick="toggleAnimation()"
                title="Haz click para descubrir BASE"
            >
                {{-- 1. IMAGEN FINAL (logofinal.png) --}}
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
                <img
                    id="head-img"
                    src="{{ asset('images/logo.png') }}"
                    alt="BASE Logo Head"
                    class="relative z-10 w-full transition-all duration-300 group-hover:scale-[1.02]"
                    style="filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.15));"
                />
            </div>

            {{-- Texto BASE --}}
            <h1 class="text-white text-8xl font-bold tracking-widest -mt-16 ml-4 relative z-30 pointer-events-none transition-transform duration-500" id="main-title" style="text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);">
                BASE
            </h1>

            {{-- DESCRIPCIÓN (Oculta inicialmente) --}}
            <div id="description-container" class="max-w-3xl mx-auto mt-8 opacity-0 transform translate-y-4 transition-all duration-1000 ease-out">
                <p class="text-gray-300 text-lg leading-relaxed font-light border-t border-gray-700 pt-6">
                    Es una página web dedicada a la compra/venta de entradas, diseñada para facilitar a los artistas u organizadores de eventos la creación y publicación de estos, y mejorar tanto la accesibilidad como facilitar a los usuarios la compra de entradas.
                </p>
                
                {{-- Botón CTA --}}
                <div class="mt-8">
                    <a href="{{ route('events.index') }}" class="inline-block px-8 py-3 border border-white/20 rounded-full text-white hover:bg-white hover:text-gray-900 transition-colors duration-300 font-medium">
                        Ver Eventos
                    </a>
                </div>
            </div>

            {{-- Eliminado el texto de "haz click" --}}
        </div>
    </div>

    <script>
        let isExpanded = false;

        function toggleAnimation() {
            const speakers = document.getElementById('speakers-img');
            const head = document.getElementById('head-img');
            const finalImg = document.getElementById('final-img');
            const description = document.getElementById('description-container');

            if (!isExpanded) {
                // --- ABRIR (Animación de entrada) ---

                // 1. Mostrar altavoces y animarlos hacia afuera
                speakers.classList.remove('opacity-0', 'scale-50');
                speakers.classList.add('opacity-100', 'scale-100'); 
                
                // 2. Esperar a que terminen de salir los altavoces
                setTimeout(() => {
                    if (speakers.classList.contains('scale-100')) {
                        // Intercambio a imagen final
                        finalImg.classList.remove('opacity-0');
                        finalImg.classList.add('opacity-100');

                        head.classList.add('opacity-0');
                        speakers.classList.add('opacity-0');
                        
                        // 3. MOSTRAR LA DESCRIPCIÓN
                        description.classList.remove('opacity-0', 'translate-y-4');
                        description.classList.add('opacity-100', 'translate-y-0');
                    }
                }, 600);

                isExpanded = true;

            } else {
                // --- CERRAR (Resetear) ---

                // 1. Restaurar visibilidad de las partes separadas
                finalImg.classList.remove('opacity-100');
                finalImg.classList.add('opacity-0');

                head.classList.remove('opacity-0');
                speakers.classList.remove('opacity-0');

                // Ocultar descripción
                description.classList.remove('opacity-100', 'translate-y-0');
                description.classList.add('opacity-0', 'translate-y-4');
                
                // 2. Animar altavoces hacia adentro
                requestAnimationFrame(() => {
                    speakers.classList.remove('scale-100', 'opacity-100');
                    speakers.classList.add('scale-50', 'opacity-0');
                });

                isExpanded = false;
            }
        }
    </script>
@endsection