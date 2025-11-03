<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Alerta;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlertaMail;
use Illuminate\Validation\Rule;

class AlertaController extends Controller
{
    public function index(): View
    {
        $alertas = Alerta::orderBy('created_at', 'desc')->paginate(15);
        return view('guardaparques.alertas.index', compact('alertas'));
    }

    public function create(): View
    {
        return view('guardaparques.alertas.create');
    }

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
            'tipo' => ['nullable', Rule::in(['hostil', 'no hostil'])],
        ]);

        $validatedData['enviado'] = false; // predeterminado
        Alerta::create($validatedData);

        return redirect()->route('alertas.index')->with('success', 'Alerta registrada con éxito.');
    }

    public function show(Alerta $alerta): View
    {
        return view('guardaparques.alertas.show', compact('alerta'));
    }

    public function edit(Alerta $alerta): View
    {
        return view('guardaparques.alertas.edit', compact('alerta'));
    }

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
            'tipo' => ['nullable', Rule::in(['hostil', 'no hostil'])],
        ]);

        $alerta->update($validatedData);

        return redirect()->route('alertas.index')->with('success', 'Alerta actualizada.');
    }

    public function destroy(Alerta $alerta): RedirectResponse
    {
        $alerta->delete();
        return redirect()->route('alertas.index')->with('success', 'Alerta eliminada.');
    }

    /** Método para enviar correo manual de alerta */
    public function send(Alerta $alerta): RedirectResponse
    {
        if (!$alerta->enviado) {
            // Enviar correo a todos los guardaparques
            $guardaparques = User::where('role', 'guardaparque')->get();
            foreach ($guardaparques as $g) {
                Mail::to($g->email)->send(new AlertaMail($alerta));
            }
            $alerta->enviado = true;
            $alerta->save();
        }

        return back()->with('success', 'Correo enviado a guardaparques');
    }
}
