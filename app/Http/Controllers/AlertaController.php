<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Alerta;
use Illuminate\Validation\Rule;

class AlertaController extends Controller
{
    /** Muestra la tabla CRUD de alertas. (GET /alertas) */
    public function index(): View
    {
        $alertas = Alerta::orderBy('created_at', 'desc')->paginate(15);
        return view('guardaparques.alertas.index', compact('alertas'));
    }

    /** Muestra el formulario de creación. (GET /alertas/create) */
    public function create(): View
    {
        return view('guardaparques.alertas.create');
    }

    /** Almacena una nueva alerta. (POST /alertas) */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'id_alerta' => 'required|string|unique:alertas,id_alerta',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'severidad' => ['required', Rule::in(['Baja', 'Media', 'Alta'])],
            'sensor_id' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'estado' => ['required', Rule::in(['Nueva', 'En Proceso', 'Resuelta'])],
        ]);

        Alerta::create($validatedData);

        return redirect()->route('alertas.index')->with('success', 'Alerta registrada con éxito.');
    }

    /** Muestra una alerta específica. (GET /alertas/{alerta}) */
    public function show(Alerta $alerta): View
    {
        return view('guardaparques.alertas.show', compact('alerta'));
    }

    /** Muestra el formulario de edición. (GET /alertas/{alerta}/edit) */
    public function edit(Alerta $alerta): View
    {
        return view('guardaparques.alertas.edit', compact('alerta'));
    }

    /** Actualiza el recurso. (PUT/PATCH /alertas/{alerta}) */
    public function update(Request $request, Alerta $alerta): RedirectResponse
    {
        $validatedData = $request->validate([
            'id_alerta' => ['required', 'string', Rule::unique('alertas', 'id_alerta')->ignore($alerta->id)],
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'severidad' => ['required', Rule::in(['Baja', 'Media', 'Alta'])],
            'sensor_id' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'estado' => ['required', Rule::in(['Nueva', 'En Proceso', 'Resuelta'])],
        ]);

        $alerta->update($validatedData);

        return redirect()->route('alertas.index')->with('success', 'Alerta actualizada.');
    }

    /** Elimina el recurso. (DELETE /alertas/{alerta}) */
    public function destroy(Alerta $alerta): RedirectResponse
    {
        $alerta->delete();
        return redirect()->route('alertas.index')->with('success', 'Alerta eliminada.');
    }
}
