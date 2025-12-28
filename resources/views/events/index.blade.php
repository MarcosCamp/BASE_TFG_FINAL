@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Eventos en tu ciudad</h1>
            
            {{-- Muestra la ciudad buscada o la del perfil --}}
            <p class="text-gray-600 mb-4">
                Mostrando eventos en: <strong>{{ $location }}</strong>
            </p>
            
            {{-- Filtros adicionales (Visuales por ahora) --}}
            <div class="flex flex-wrap gap-4">
                <select class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900">
                    <option>Todas las categorías</option>
                    <option>Conciertos</option>
                    <option>Festivales</option>
                    <option>Teatro</option>
                    <option>Deportes</option>
                </select>
                
                <input 
                    type="date" 
                    class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900"
                />
            </div>
        </div>

        @if(isset($events) && $events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover">
                        @else
                            {{-- Placeholder si no hay imagen --}}
                            <div class="w-full h-48 bg-gradient-to-r from-purple-500 to-indigo-600"></div>
                        @endif
                        
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">📍 {{ $event->location }}</p>
                            
                            {{-- Requiere que 'event_date' sea 'datetime' en el modelo Event --}}
                            <p class="text-gray-600 text-sm mb-2">📅 {{ $event->event_date->format('d/m/Y H:i') }}</p>
                            
                            <p class="text-gray-600 text-sm mb-4">🎤 {{ $event->artist ? $event->artist->name : 'Artista desconocido' }}</p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900">{{ number_format($event->price, 2) }}€</span>
                                <a href="{{ route('events.show', $event->id) }}" class="bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay eventos disponibles</h3>
                
                {{-- Mensaje dinámico según la búsqueda --}}
                <p class="mt-1 text-sm text-gray-500">
                    No hay eventos en <strong>{{ $location }}</strong> en este momento.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection