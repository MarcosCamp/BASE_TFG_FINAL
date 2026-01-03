<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Event; // <--- IMPORTANTE: Necesario para poder restar el stock

class PaymentController extends Controller
{
    // 1. MOSTRAR EL FORMULARIO INTEGRADO
    public function showPaymentForm()
    {
        // Configurar API Key
        Stripe::setApiKey(config('services.stripe.secret'));

        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('cart.index');
        }

        // Calcular total en Céntimos (Stripe no usa decimales, 10.00€ = 1000)
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $amountInCents = round($total * 100);

        // Crear la intención de pago en Stripe
        $intent = PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        // Pasamos el "secreto" a la vista para que el JS pueda procesar el pago
        return view('payment.checkout', [
            'clientSecret' => $intent->client_secret,
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // 2. ÉXITO (Stripe nos devuelve aquí tras pagar)
    public function success(Request $request)
    {
        // Verificar que hay un payment_intent en la URL (Stripe lo pone automático)
        if (!$request->has('payment_intent')) {
            return redirect()->route('cart.index');
        }

        $cart = session()->get('cart');

        // Si el carrito ya está vacío (porque recargó la página), redirigir
        if(!$cart) {
            return redirect()->route('events.index');
        }
        
        // Guardar Pedido en BD
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $this->calculateCartTotal($cart),
            'status' => 'paid',
            'payment_id' => $request->get('payment_intent'),
        ]);

        foreach ($cart as $id => $details) {
            // 1. Crear el detalle del pedido
            OrderItem::create([
                'order_id' => $order->id,
                'event_id' => $id,
                'event_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);

            // 2. RESTAR STOCK (CAPACIDAD) AL EVENTO
            $event = Event::find($id);
            if ($event) {
                // decrement resta la cantidad automáticamente de la columna 'capacity'
                $event->decrement('capacity', $details['quantity']);
            }
        }

        // Vaciar carrito
        session()->forget('cart');

        return view('payment.success', compact('order'));
    }

    // Helper privado para calcular total
    private function calculateCartTotal($cart) {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}