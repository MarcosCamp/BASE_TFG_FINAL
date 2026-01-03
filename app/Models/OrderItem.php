<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'event_id',
        'event_name',
        'quantity',
        'price',
    ];

    // Relación: Pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación: Pertenece a un evento
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}