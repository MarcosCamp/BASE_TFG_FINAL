<?php

namespace App\Http\Controllers;

use App\Models\Event; // Importante: Importar el modelo
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Muestra el carrito completo
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calcular total
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // Añade item y abre el mini-carrito
    public function add(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $quantity = $request->input('quantity', 1);
        
        $cart = session()->get('cart', []);

        // Si el evento ya está en el carrito, sumamos cantidad
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Si no, lo creamos con todos los datos necesarios para la vista
            $cart[$id] = [
                'name' => $event->name,
                'quantity' => $quantity,
                'price' => $event->price,
                'image' => $event->image,
                'artist' => $event->artist ? $event->artist->name : 'Varios'
            ];
        }

        session()->put('cart', $cart);

        // 'cart_updated' sirve para decirle a la vista que abra el desplegable automáticamente
        return redirect()->back()->with('cart_updated', true);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Producto eliminado');
    }

    public function checkout()
    {
        // Aquí iría la lógica de pasarela de pago real
        session()->forget('cart');
        return redirect()->route('home')->with('success', '¡Compra realizada con éxito!');
    }
}