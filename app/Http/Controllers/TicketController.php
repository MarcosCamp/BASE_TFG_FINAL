<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function show($orderId)
    {
        // Buscamos el pedido con sus items (entradas) y los datos del evento
        $order = Order::with('items.event')->findOrFail($orderId);

        // Seguridad: Verificar que el pedido pertenece al usuario logueado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver estas entradas.');
        }

        return view('tickets.show', compact('order'));
    }
}