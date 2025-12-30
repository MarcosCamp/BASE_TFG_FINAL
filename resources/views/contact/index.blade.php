@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Contáctanos</h1>
            <p class="mt-4 text-lg text-gray-500">¿Tienes alguna duda o propuesta? Escríbenos.</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
            
            {{-- Mensaje de Éxito --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">¡Genial!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email (Con validación Regex) --}}
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required placeholder="ejemplo@correo.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Mensaje --}}
                <div>
                    <x-input-label for="message" :value="__('Tu Mensaje')" />
                    <textarea id="message" name="message" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="bg-gray-900 hover:bg-gray-800 py-3 px-6 text-lg">
                        {{ __('Enviar Mensaje') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        
        {{-- Info Adicional --}}
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                <p class="mt-2 text-base text-gray-500">marcoscampserrano@gmail.com</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Ubicación</h3>
                <p class="mt-2 text-base text-gray-500">Zaragoza, España</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Redes</h3>
                <p class="mt-2 text-base text-gray-500">@base_events</p>
            </div>
        </div>

    </div>
</div>
@endsection