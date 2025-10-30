<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    // Indica que no usamos timestamps automáticos si las alertas IoT proveen su propio timestamp
    // public $timestamps = false; 

    protected $fillable = [
        'id_alerta',
        'titulo',
        'mensaje',
        'severidad', // Baja, Media, Alta
        'sensor_id', // ID del dispositivo IoT o sensor que la generó
        'ubicacion',
        'estado',    // Nueva, En Proceso, Resuelta
    ];
}
