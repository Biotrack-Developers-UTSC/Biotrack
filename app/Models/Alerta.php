<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_alerta',
        'titulo',
        'mensaje',
        'severidad',
        'sensor_id',
        'ubicacion',
        'estado',
        'tipo',
        'imagen',
        'enviado',
    ];
}
