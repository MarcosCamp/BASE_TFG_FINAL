<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // 1. Iniciamos la consulta base
        $query = Event::with('artist'); // Cargamos los datos del artista para la vista

        // 2. Variable para saber qué ciudad estamos mostrando (para el título)
        $location = 'Todas las ciudades';

        // 3. Lógica de Filtrado (Prioridad: Buscador > Perfil > Todo)
        if ($request->filled('location')) {
            // A: Si el usuario escribió en el buscador
            $search = $request->input('location');
            $query->where('location', 'like', "%{$search}%");
            $location = ucfirst($search); // Capitalizamos la primera letra
        } elseif (Auth::check() && Auth::user()->location) {
            // B: Si no buscó nada, pero tiene perfil con ciudad
            $query->where('location', Auth::user()->location);
            $location = Auth::user()->location;
        }

        // 4. Ejecutamos la consulta (ordenados por fecha)
        $events = $query->orderBy('event_date', 'asc')->get();

        // 5. Pasamos eventos y la variable $location a la vista
        return view('events.index', compact('events', 'location'));
    }

    public function show($id)
    {
        $event = Event::with('artist')->findOrFail($id);
        return view('events.show', compact('event'));
    }
}