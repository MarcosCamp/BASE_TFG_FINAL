<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // Importante para tus roles
        'location',  // Importante para tu filtro de ciudades
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- MÉTODOS PERSONALIZADOS (Los que te faltaban) ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isArtist(): bool
    {
        return $this->role === 'artist';
    }

    public function isUser(): bool
    {
        // En tu registro usas 'user' o 'client' según la base de datos.
        // Si en el registro pusiste 'user', déjalo así.
        return $this->role === 'user' || $this->role === 'client';
    }

    // Relación con Eventos
    public function events()
    {
        // CORRECCIÓN: En la migración usamos 'user_id', no 'artist_id'
        return $this->hasMany(Event::class, 'user_id');
    }
}