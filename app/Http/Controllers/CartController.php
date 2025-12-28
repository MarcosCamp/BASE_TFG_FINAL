<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Aquí deberías cargar los items del carrito real más adelante
        return view('cart.index');
    }

    public function add(Request $request, $eventId)
    {
        // Lógica futura: $cart->items()->create(['event_id' => $eventId]);
        return redirect()->route('cart.index')->with('success', 'Entrada añadida al carrito');
    }

    public function remove($itemId)
    {
        return redirect()->route('cart.index')->with('success', 'Entrada eliminada');
    }

    public function checkout(Request $request)
    {
        return redirect()->route('home')->with('success', 'Compra realizada con éxito');
    }
}