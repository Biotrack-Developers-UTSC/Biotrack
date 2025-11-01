<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    // 👇 Laravel por defecto buscaría "animals", lo corregimos
    protected $table = 'animales';

    protected $fillable = [
        'nombre_comun',
        'nombre_cientifico',
        'habitat',
        'tipo',
        'latitud',
        'longitud',
        'descripcion',
        'imagen_path',
        'codigo_qr',
    ];
}
