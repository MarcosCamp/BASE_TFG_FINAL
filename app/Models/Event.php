<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // Cambiado
        'description',
        'event_date',    // Cambiado
        'location',
        'price',
        'capacity',
        'image',
        'user_id',
    ];

    // IMPORTANTE: Tu vista llama a $event->event_date->format(), 
    // así que debemos decirle a Laravel que esto es una fecha.
    protected $casts = [
        'event_date' => 'datetime',
    ];

    // Tu vista usa $event->artist->name, así que creamos la relación 'artist'
    // aunque en realidad apunte a la tabla 'users'
    public function artist()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}