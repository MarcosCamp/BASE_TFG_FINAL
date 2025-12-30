@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-8 h-full">
                
                {{-- BLOQUE 1: IMAGEN (Izquierda) --}}
                {{-- Centrado vertical y horizontalmente en su cuadrante --}}
                <div class="bg-gray-100 flex items-center justify-center p-8 md:p-12 h-full min-h-[400px]">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" 
                             alt="{{ $event->name }}" 
                             class="rounded-lg shadow-2xl max-h-[500px] w-auto object-cover transform hover:scale-105 transition duration-500">
                    @else
                        <div class="w-64 h-64 bg-gray-300 rounded-lg flex items-center justify-center shadow-inner">
                            <span class="text-gray-500 font-medium">Sin imagen</span>
                        </div>
                    @endif
                </div>

                {{-- BLOQUE 2: INFORMACIÓN Y COMPRA (Derecha) --}}
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    
                    {{-- Categoría y Artista --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 uppercase tracking-wide">
                            {{ $event->category ?? 'Evento' }}
                        </span>
                        @if($event->artist)
                            <span class="text-sm font-bold text-gray-500">
                                Artista: <span class="text-gray-900">{{ $event->artist->name }}</span>
                            </span>
                        @endif
                    </div>

                    {{-- Título Grande --}}
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                        {{ $event->name }}
                    </h1>

                    {{-- Descripción --}}
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        {{ $event->description }}
                    </p>

                    {{-- Metadatos (Fecha, Lugar, Aforo) --}}
                    <div class="space-y-4 mb-8 border-t border-b border-gray-100 py-6">
                        <div class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-lg">{{ $event->event_date->format('d/m/Y') }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span class="text-gray-600">{{ $event->event_date->format('H:i') }} hrs</span>
                        </div>
                        
                        <div class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium text-lg">{{ $event->location }}</span>
                        </div>

                        <div class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>
                                Entradas disponibles: 
                                <strong class="{{ $event->capacity < 10 ? 'text-red-500' : 'text-gray-900' }}">
                                    {{ $event->capacity }}
                                </strong>
                            </span>
                        </div>
                    </div>

                    {{-- PRECIO Y FORMULARIO DE COMPRA --}}
                    <div class="mt-auto">
                        <div class="flex items-end justify-between mb-4">
                            <p class="text-sm text-gray-500">Precio por entrada</p>
                            <p class="text-4xl font-bold text-gray-900">{{ number_format($event->price, 2) }}€</p>
                        </div>

                        @if($event->capacity > 0)
                            <form action="{{ route('cart.add', $event->id) }}" method="POST">
                                @csrf
                                <div class="flex gap-4">
                                    {{-- Selector de Cantidad --}}
                                    <div class="w-1/3">
                                        <label for="quantity" class="sr-only">Cantidad</label>
                                        <input 
                                            type="number" 
                                            id="quantity" 
                                            name="quantity" 
                                            value="1" 
                                            min="1" 
                                            max="{{ $event->capacity }}"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-center text-lg font-medium py-3"
                                        >
                                    </div>

                                    {{-- Botón Comprar --}}
                                    <button type="submit" class="w-2/3 bg-gray-900 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Comprar Entradas
                                    </button>
                                </div>
                            </form>

                            {{-- FEEDBACK EN ROJO AL AÑADIR AL CARRITO --}}
                            @if(session('success'))
                                <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-md animate-pulse">
                                    <p class="text-red-600 text-center font-bold">
                                        {{ session('success') }}
                                    </p>
                                    <div class="mt-2 text-center">
                                        <a href="{{ route('cart.index') }}" class="text-sm text-red-700 underline hover:text-red-900">
                                            Ir al carrito &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endif

                        @else
                            {{-- Mensaje Sold Out --}}
                            <div class="bg-gray-100 text-gray-500 text-center py-4 rounded-md font-bold uppercase tracking-widest border-2 border-gray-200">
                                ¡Agotado!
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection