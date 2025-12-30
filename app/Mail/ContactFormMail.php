<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Aquí guardamos los datos del formulario (nombre, email, mensaje)

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            // Asunto del correo
            subject: 'Nuevo Mensaje de Contacto - BASE',
            
            // "replyTo" hace que si respondes al correo, le llegue al usuario y no a ti mismo
            replyTo: [
                new Address($this->data['email'], $this->data['name']),
            ],
        );
    }

    public function content(): Content
    {
        // Usaremos una vista simple para el cuerpo del correo
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}