@extends('layouts.app')

@section('title', 'Carrito')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Mi Carrito</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <p class="text-gray-500 text-center py-12">
                            Tu carrito está vacío
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Resumen</h2>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span><span>0,00 €</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Gastos</span><span>0,00 €</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between font-bold text-gray-900">
                                <span>Total</span><span>0,00 €</span>
                            </div>
                        </div>
                        <button class="w-full bg-gray-900 text-white py-3 rounded-md font-medium hover:bg-gray-800 transition" disabled>
                            Proceder al Pago
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection