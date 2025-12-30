<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Necesario para subir imágenes

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('artist'); 
        $locationTitle = 'Todos los eventos';

        // Solo filtramos si el usuario explícitamente selecciona una ciudad en el buscador
        if ($request->filled('location')) {
            $search = $request->input('location');
            $query->where('location', 'like', "%{$search}%");
            $locationTitle = ucfirst($search);
        }
        // En EventController.php -> index()
if ($request->filled('category')) {
    $query->where('category', $request->input('category'));
}
// (Asegúrate de que en tu vista index.blade.php el <select> del filtro tenga name="category")
        // HE ELIMINADO EL 'ELSEIF' que filtraba por la ciudad del usuario automáticamente.
        // Ahora mostrará todos los eventos si no se busca nada.

        $events = $query->orderBy('event_date', 'asc')->get();

        // Pasamos variable locationTitle para la vista (cambié el nombre para no confundir con el campo location)
        return view('events.index', compact('events', 'locationTitle'));
    }

    public function show($id)
    {
        $event = Event::with('artist')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    // Muestra el formulario
    public function create()
    {
        // Verificar que sea artista
        if (Auth::user()->role !== 'artist') {
            abort(403, 'Acceso no autorizado. Solo artistas pueden crear eventos.');
        }
        return view('events.create');
    }

    // Guarda el evento
    public function store(Request $request)
{
    if (Auth::user()->role !== 'artist') {
        abort(403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|in:concierto,festival', // <--- AÑADE ESTA LÍNEA
        'description' => 'required|string',
        'event_date' => 'required|date|after:today',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // ... resto del código (subida de imagen, etc) ...
        // Subida de imagen
        if ($request->hasFile('image')) {
            // Guarda en storage/app/public/events
            $path = $request->file('image')->store('events', 'public');
            $validated['image'] = $path;
        }

        // Asignar el usuario actual (el artista)
        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')->with('success', '¡Evento publicado correctamente!');
    }
}