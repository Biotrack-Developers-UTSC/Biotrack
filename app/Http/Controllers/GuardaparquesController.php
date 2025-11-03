<?php

namespace App\Http\Controllers;

use App\Models\Alerta;

class GuardaparquesController extends Controller
{
    public function alertas()
    {
        $query = Alerta::query();

        // Filtrar por tipo
        if (request('tipo')) {
            $query->where('tipo', 'like', '%' . request('tipo') . '%');
        }

        // Filtrar por severidad (no "nivel")
        if (request('severidad')) {
            $query->where('severidad', request('severidad'));
        }

        $alertas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('guardaparques.alertas.index', compact('alertas'));
    }


}