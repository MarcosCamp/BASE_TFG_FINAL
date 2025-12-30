<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('artist'); 
        $locationTitle = 'Todos los eventos';

        // 1. Filtro por Ubicación (Buscador)
        if ($request->filled('location')) {
            $search = $request->input('location');
            $query->where('location', 'like', "%{$search}%");
            $locationTitle = ucfirst($search);
        }

        // 2. Filtro por Categoría
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // 3. Filtro por Fecha (NUEVO - Esto es lo que faltaba)
        if ($request->filled('date')) {
            $query->whereDate('event_date', $request->input('date'));
        }

        // Ordenamos por fecha ascendente para ver los más próximos primero
        $events = $query->orderBy('event_date', 'asc')->get();

        return view('events.index', compact('events', 'locationTitle'));
    }

    public function show($id)
    {
        $event = Event::with('artist')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    // Muestra el formulario de creación
    public function create()
    {
        // Verificar que sea artista
        if (Auth::user()->role !== 'artist') {
            abort(403, 'Acceso no autorizado. Solo artistas pueden crear eventos.');
        }
        return view('events.create');
    }

    // Guarda el evento en la base de datos
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'artist') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:concierto,festival',
            'description' => 'required|string',
            'event_date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subida de imagen
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }

        // Asignar el usuario actual (el artista)
        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')->with('success', '¡Evento publicado correctamente!');
    }
}