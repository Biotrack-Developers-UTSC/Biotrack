<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\View\View;

class ConsultaController extends Controller
{
    /**
     * Muestra la vista principal de consultas de animales para todos los roles.
     * Esta es la página de destino para el rol 'user'.
     */
    public function index(): View
    {
        // Muestra todos los animales por defecto
        $animales = Animal::all();

        // La vista 'consultas.index' debe tener el formulario de filtro.
        return view('consultas.index', compact('animales'));
    }

    /**
     * Lógica de filtrado de animales (similar a la función filterByType que tenías).
     */
    public function filterByType(string $tipo): View
    {
        if (!in_array($tipo, ['Pacifico', 'Hostil'])) {
            $animales = Animal::all();
            $tipo = 'Todos';
        } else {
            $animales = Animal::where('tipo', $tipo)->get();
        }

        return view('consultas.index', compact('animales', 'tipo'));
    }
}
