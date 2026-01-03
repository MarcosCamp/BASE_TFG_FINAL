@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        
        {{-- Icono de Éxito --}}
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">¡Pago realizado!</h2>
        <p class="text-gray-500 mb-8">Gracias por tu compra. Aquí tienes tu ticket.</p>

        {{-- Resumen del Ticket --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left border border-gray-200">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">ID Pedido: #{{ $order->id }}</p>
            
            <ul class="divide-y divide-gray-200 mb-4">
                @foreach($order->items as $item)
                    <li class="py-2 flex justify-between text-sm">
                        <span>{{ $item->event_name }} <span class="text-gray-400">x{{ $item->quantity }}</span></span>
                        <span class="font-medium">{{ number_format($item->price * $item->quantity, 2) }}€</span>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-between border-t border-gray-300 pt-3 font-bold text-gray-900">
                <span>Total Pagado</span>
                <span>{{ number_format($order->total, 2) }}€</span>
            </div>
        </div>

        <a href="{{ route('events.index') }}" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Seguir explorando eventos
        </a>
    </div>
</div>
@endsection