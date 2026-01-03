@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Tu Carrito de Compras</h1>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- LISTA DE PRODUCTOS --}}
                <div class="lg:w-2/3">
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach($cart as $id => $details)
                                <li class="p-6 flex items-center">
                                    {{-- Imagen Pequeña a la Izquierda --}}
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        @if(isset($details['image']))
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="h-full w-full bg-gray-200 flex items-center justify-center">Sin img</div>
                                        @endif
                                    </div>

                                    <div class="ml-6 flex-1 flex flex-col sm:flex-row sm:items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ $details['name'] }}</h3>
                                            <p class="text-sm text-gray-500">{{ $details['artist'] ?? 'Artista desconocido' }}</p>
                                            <p class="mt-1 text-sm text-indigo-600 font-medium">Precio unidad: {{ number_format($details['price'], 2) }}€</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 flex items-center gap-6">
                                            
                                            {{-- SECCIÓN MODIFICADA: CONTROLES DE CANTIDAD --}}
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs text-gray-500 mb-1">Cantidad</span>
                                                
                                                <div class="flex items-center border border-gray-300 rounded-md shadow-sm">
                                                    {{-- Botón MENOS --}}
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="action" value="decrease">
                                                        <button type="submit" class="px-3 py-1 text-gray-600 hover:bg-gray-100 hover:text-red-600 focus:outline-none border-r border-gray-300 transition-colors">
                                                            −
                                                        </button>
                                                    </form>

                                                    {{-- Número --}}
                                                    <span class="px-3 py-1 text-gray-900 font-semibold bg-white min-w-[2.5rem] text-center select-none">
                                                        {{ $details['quantity'] }}
                                                    </span>

                                                    {{-- Botón MÁS --}}
                                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="action" value="increase">
                                                        <button type="submit" class="px-3 py-1 text-gray-600 hover:bg-gray-100 hover:text-green-600 focus:outline-none border-l border-gray-300 transition-colors">
                                                            +
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            {{-- Precio Total del Item --}}
                                            <div class="text-right w-24">
                                                <span class="block text-lg font-bold text-gray-900">
                                                    {{ number_format($details['price'] * $details['quantity'], 2) }}€
                                                </span>
                                            </div>

                                            {{-- Botón de Eliminar (Papelera) --}}
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 p-2 transition-colors" title="Eliminar evento">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- RESUMEN DEL PEDIDO --}}
                <div class="lg:w-1/3">
                    <div class="bg-white shadow-sm rounded-lg p-6 sticky top-24">
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Resumen del Pedido</h2>
                        
                        <div class="flow-root">
                            <dl class="-my-4 divide-y divide-gray-200">
                                <div class="flex items-center justify-between py-4">
                                    <dt class="text-gray-600">Subtotal</dt>
                                    <dd class="font-medium text-gray-900">{{ number_format($total, 2) }}€</dd>
                                </div>
                                <div class="flex items-center justify-between py-4 border-t border-gray-200">
                                    <dt class="text-base font-bold text-gray-900">Total</dt>
                                    <dd class="text-xl font-bold text-gray-900">{{ number_format($total, 2) }}€</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('payment.checkout') }}" class="block w-full text-center bg-gray-900 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors">
    Finalizar Compra
</a>
                        </div>
                    </div>
                </div>

            </div>
        @else
            {{-- Carrito Vacío --}}
            <div class="text-center py-20 bg-white shadow-sm rounded-lg">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tu carrito está vacío</h3>
                <p class="mt-2 text-gray-500">¿A qué esperas? ¡Encuentra los mejores eventos!</p>
                <div class="mt-6">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Ver Eventos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection