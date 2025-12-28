@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Contacto</h1>
            <div class="bg-white rounded-lg shadow-md p-8">
                <form>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-900">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                        <textarea rows="5" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-900"></textarea>
                    </div>
                    <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-md font-medium hover:bg-gray-800 transition">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection