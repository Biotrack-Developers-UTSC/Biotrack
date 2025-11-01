<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    /**
     * Muestra el catálogo público con filtrado de especies.
     */
    public function index(Request $request)
    {
        $query = Animal::query();

        // 🔍 Filtros dinámicos
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre_comun', 'like', "%{$request->nombre}%");
        }

        if ($request->filled('nombre_cientifico')) {
            $query->where('nombre_cientifico', 'like', "%{$request->nombre_cientifico}%");
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Ordenar y paginar resultados
        $animales = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());

        // Retornar vista con los resultados filtrados
        return view('consultas.index', compact('animales'));
    }
}
