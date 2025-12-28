<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // ¡Importante para las consultas!

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Esta es la línea mágica que te faltaba
        // Recupera las ciudades de la tabla 'locations'
        $cities = DB::table('locations')->orderBy('name')->pluck('name')->toArray();
        
        // Pasa la variable $cities a la vista
        return view('auth.register', compact('cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:user,artist'], // Validación de roles
            'location' => ['required', 'string'],      // Validación de ubicación
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'location' => $request->location,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home');
    }
}