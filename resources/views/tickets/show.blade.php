@extends('layouts.app')

@section('title', 'Mis Entradas')

@section('content')
<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-white tracking-tight">Tus Entradas</h1>
            <p class="text-gray-400 mt-2">Pedido #{{ $order->id }} • {{ $order->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="space-y-8">
            {{-- BUCLE 1: Recorre los tipos de entrada comprados --}}
            @foreach($order->items as $item)
                
                {{-- BUCLE 2: Genera una tarjeta por cada unidad comprada (Si compraste 3, da 3 vueltas) --}}
                @for($i = 1; $i <= $item->quantity; $i++)
                    
                    {{-- Tarjeta de Entrada --}}
                    <div class="bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative transform transition hover:scale-[1.01]">
                        
                        {{-- Decoración: Círculos laterales --}}
                        <div class="hidden md:block absolute top-1/2 left-0 -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-gray-900 rounded-full"></div>
                        <div class="hidden md:block absolute top-1/2 right-0 translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-gray-900 rounded-full"></div>

                        {{-- IMAGEN DEL EVENTO (Izquierda) --}}
                        <div class="md:w-1/3 h-48 md:h-auto relative">
                            @if($item->event && $item->event->image)
                                <img src="{{ asset('storage/' . $item->event->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500">Sin Imagen</div>
                            @endif
                            {{-- Overlay móvil --}}
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center md:hidden">
                                <span class="text-white font-bold text-xl">{{ $item->event_name }}</span>
                            </div>
                        </div>

                        {{-- INFORMACIÓN (Centro) --}}
                        <div class="md:w-1/3 p-6 flex flex-col justify-center border-b md:border-b-0 md:border-r border-dashed border-gray-300 relative">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Entrada General</span>
                                {{-- Contador de entradas --}}
                                <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-500">
                                    {{ $i }} / {{ $item->quantity }}
                                </span>
                            </div>
                            
                            <h2 class="text-2xl font-black text-gray-900 leading-tight mb-2">{{ $item->event_name }}</h2>
                            
                            <div class="space-y-1 text-sm text-gray-600 mt-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>{{ $item->event ? \Carbon\Carbon::parse($item->event->event_date)->format('d M, Y') : 'Fecha pendiente' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $item->event ? $item->event->location : 'Ubicación pendiente' }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-gray-500 text-xs">Asistente</span>
                                <span class="font-bold text-gray-900 truncate max-w-[120px]">{{ Auth::user()->name }}</span>
                            </div>
                        </div>

                        {{-- CÓDIGO QR (Derecha) --}}
                        <div class="md:w-1/3 p-6 bg-gray-50 flex flex-col items-center justify-center text-center">
                            <div class="bg-white p-2 rounded-lg shadow-sm mb-3">
                                {{-- 
                                    GENERAMOS QR ÚNICO:
                                    Añadimos el índice $i al final.
                                    Ejemplo: TICKET-50-2-1, TICKET-50-2-2, TICKET-50-2-3
                                --}}
                                {!! QrCode::size(120)->generate("TICKET-" . $order->id . "-" . $item->id . "-" . $i) !!}
                            </div>
                            <p class="text-[10px] text-gray-400 font-mono">
                                ID: {{ $order->id }}-{{ $item->id }}-<span class="text-indigo-600 font-bold">{{ $i }}</span>
                            </p>
                            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                Válida para 1 persona
                            </span>
                        </div>
                    </div>
                @endfor

            @endforeach
        </div>

        <div class="mt-10 text-center pb-10">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition underline">Volver al inicio</a>
        </div>
    </div>
</div>
@endsection