<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'id_venta',
        'fecha',
        'producto',
        'categoria',
        'cantidad',
        'precio_unitario',
        'total',
        'region',
        'estado_limpieza',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
    ];
}