@extends('layouts.app')

@section('title', 'Finalizar Pago')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Finalizar Compra</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- RESUMEN (Izquierda) --}}
            <div class="bg-white p-6 rounded-lg shadow-sm h-fit">
                <h2 class="text-lg font-medium mb-4">Resumen</h2>
                <ul class="space-y-3 mb-4">
                    @foreach($cart as $item)
                        <li class="flex justify-between text-sm">
                            <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                            <span class="font-medium">{{ number_format($item['price'] * $item['quantity'], 2) }}€</span>
                        </li>
                    @endforeach
                </ul>
                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total a pagar</span>
                    <span>{{ number_format($total, 2) }}€</span>
                </div>
            </div>

            {{-- FORMULARIO DE PAGO (Derecha) --}}
            <div class="bg-white p-6 rounded-lg shadow-lg border border-indigo-100">
                <form id="payment-form">
                    <div id="payment-element">
                        </div>

                    <button id="submit" class="w-full mt-6 bg-gray-900 text-white py-3 rounded-md font-bold hover:bg-gray-800 transition disabled:opacity-50">
                        <div class="spinner hidden" id="spinner">Procesando...</div>
                        <span id="button-text">Pagar ahora</span>
                    </button>
                    
                    <div id="payment-message" class="hidden mt-4 text-center text-red-500 text-sm"></div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT DE STRIPE --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Tu clave PÚBLICA (empieza por pk_test_...)
    // Laravel la inyecta desde la config
    const stripe = Stripe("{{ config('services.stripe.key') }}");

    const options = {
        clientSecret: "{{ $clientSecret }}",
        appearance: { theme: 'stripe' }, // Puedes poner 'night' si quieres oscuro
    };

    // Inicializamos el elemento
    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    // Manejar el envío
    const form = document.getElementById('payment-form');
    
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        setLoading(true);

        // Confirmar pago en Stripe
        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Donde redirigir si todo va bien
                return_url: "{{ route('payment.success') }}", 
            },
        });

        // Si llega aquí es que hubo error (si sale bien, Stripe redirige solo)
        if (error) {
            const messageContainer = document.querySelector('#payment-message');
            messageContainer.textContent = error.message;
            messageContainer.classList.remove('hidden');
        }
        
        setLoading(false);
    });

    function setLoading(isLoading) {
        if (isLoading) {
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }
</script>
@endsection