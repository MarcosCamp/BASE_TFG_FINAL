<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    // Muestra el formulario
    public function index()
    {
        return view('contact.index');
    }

    // Procesa el envío
    public function send(Request $request)
    {
        // 1. Validación con Expresión Regular (Regex)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                // Regex estándar compleja para emails válidos
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
            ],
            'message' => 'required|string|min:10',
        ], [
            // Mensajes de error personalizados
            'email.regex' => 'El formato del correo electrónico no es válido.',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres.'
        ]);

        // 2. Recopilar datos
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        // 3. Enviar correo a TU dirección predeterminada
        // El 'From' será el configurado en el .env, pero el 'Reply-To' será el del usuario
        Mail::to('marcoscampserrano@gmail.com')->send(new ContactFormMail($data));

        // 4. Redirigir con éxito
        return redirect()->route('contact')->with('success', '¡Mensaje enviado correctamente! Nos pondremos en contacto pronto.');
    }
}