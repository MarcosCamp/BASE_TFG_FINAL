@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
<div class="min-h-screen bg-gray-50 relative">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Cabecera y Filtros --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Descubre Eventos</h1>
                <p class="text-gray-600">
                    Viendo: <strong>{{ $locationTitle ?? 'Todo' }}</strong>
                </p>
            </div>
            
            {{-- SECCIÓN MODIFICADA: Formulario funcional --}}
            <div class="flex flex-wrap gap-4">
                <form method="GET" action="{{ route('events.index') }}" class="flex flex-wrap gap-4">
                    
                    {{-- Mantenemos la ubicación si ya se estaba buscando una --}}
                    @if(request('location'))
                        <input type="hidden" name="location" value="{{ request('location') }}">
                    @endif

                    <select 
                        name="category" 
                        onchange="this.form.submit()" 
                        class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 bg-white cursor-pointer"
                    >
                        <option value="">Todas las categorías</option>
                        <option value="concierto" {{ request('category') == 'concierto' ? 'selected' : '' }}>Conciertos</option>
                        <option value="festival" {{ request('category') == 'festival' ? 'selected' : '' }}>Festivales</option>
                    </select>
                    
                    <input 
                        type="date" 
                        name="date"
                        value="{{ request('date') }}"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-900 bg-white cursor-pointer"
                    />
                </form>
            </div>
        </div>

        {{-- Grid de Eventos --}}
        @if(isset($events) && $events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-[400px]">
                        
                        {{-- 1. Imagen (2/3 de la altura) --}}
                        <div class="h-2/3 w-full relative group">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Sin imagen</span>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full font-bold text-gray-900 shadow-sm">
                                {{ number_format($event->price, 2) }}€
                            </div>
                        </div>
                        
                        {{-- 2. Contenido (1/3 de la altura) --}}
                        <div class="h-1/3 p-5 flex flex-col justify-between relative bg-white border-t border-gray-100">
                            <div>
                                <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wide mb-1">
                                    {{ $event->event_date->format('d M Y') }} • {{ $event->location }}
                                </p>
                                <a href="{{ route('events.show', $event->id) }}">
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight hover:text-indigo-600 transition line-clamp-2">
                                        {{ $event->name }}
                                    </h3>
                                </a>
                            </div>

                            <div class="flex items-center mt-2 pt-3 border-t border-gray-50">
                                <div class="text-sm text-gray-500">
                                    Por <span class="font-medium text-gray-900">{{ $event->artist ? $event->artist->name : 'Artista Invitado' }}</span>
                                </div>
                                <a href="{{ route('events.show', $event->id) }}" class="ml-auto text-gray-400 hover:text-indigo-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- BOTÓN MOVIDO AQUÍ: Visible al final de la lista --}}
            @if(Auth::check() && Auth::user()->role === 'artist')
                <div class="mt-12 flex justify-center">
                    <a href="{{ route('events.create') }}" 
                       class="group relative inline-flex items-center justify-center px-8 py-3 text-lg font-medium text-white bg-gray-900 rounded-full overflow-hidden shadow-lg transition-all hover:bg-gray-800 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        
                        {{-- Icono + --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        
                        <span>Crear Nuevo Evento</span>
                    </a>
                </div>
            @endif

        @else
            <div class="text-center py-20 bg-white rounded-lg border border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay eventos encontrados</h3>
                <p class="mt-1 text-sm text-gray-500">Intenta cambiar los filtros o la ubicación.</p>
                
                {{-- Botón también aquí por si no hay eventos, para que el artista pueda crear el primero --}}
                @if(Auth::check() && Auth::user()->role === 'artist')
                    <div class="mt-6">
                        <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Crear mi primer evento
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection