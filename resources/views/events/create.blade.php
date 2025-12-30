@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Crear Nuevo Evento</h2>

            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nombre del Evento')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="category" :value="__('Categoría del Evento')" />
                    <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled selected>-- Selecciona tipo --</option>
                        <option value="concierto" {{ old('category') == 'concierto' ? 'selected' : '' }}>Concierto</option>
                        <option value="festival" {{ old('category') == 'festival' ? 'selected' : '' }}>Festival</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="image" :value="__('Imagen del Evento')" />
                    <input id="image" type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1" required />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Descripción')" />
                    <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="location" :value="__('Ciudad')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required placeholder="Ej: Madrid" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="event_date" :value="__('Fecha y Hora')" />
                        <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date')" required />
                        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="capacity" :value="__('Aforo (Entradas disponibles)')" />
                        <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required min="1" />
                        <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="price" :value="__('Precio (€)')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" required min="0" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4 bg-gray-900 hover:bg-gray-800">
                        {{ __('Publicar Evento') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection