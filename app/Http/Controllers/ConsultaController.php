<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    /**
     * Muestra la vista de consulta (index) con todos los animales.
     * Esta es la página de destino principal para el Rol 'user'.
     * (GET /consultas/animales)
     */
    public function index(): View
    {
        // Recuperar todos los animales para la tabla de consultas.
        $animales = Animal::all();

        // Retorna la vista que contiene la interfaz de búsqueda.
        return view('consultas.index', compact('animales'));
    }
}