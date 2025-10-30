<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_comun',
        'nombre_cientifico',
        'habitat',
        'tipo', // Ejemplo: Pacifico, Hostil
        'latitud',     // Opcional: Última ubicación lat
        'longitud',    // Opcional: Última ubicación lng
        'descripcion',
        'imagen_path', // Ruta de almacenamiento de la imagen
        'codigo_qr',   // Ruta del código QR generado
    ];
}
