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
use Illuminate\Support\Str;

class AlertaController extends Controller
{
    /**
     * 📋 Listado general de alertas IoT
     */
    public function index(): View
    {
        $alertas = Alerta::orderBy('created_at', 'desc')->paginate(15);
        return view('guardaparques.alertas.index', compact('alertas'));
    }

    /**
     * 🆕 Formulario de creación manual
     */
    public function create(): View
    {
        return view('guardaparques.alertas.create');
    }

    /**
     * 💾 Guarda una nueva alerta creada desde el panel
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'id_alerta' => 'nullable|string|unique:alertas,id_alerta',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'severidad' => ['required', Rule::in(['Baja', 'Media', 'Alta'])],
            'sensor_id' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'estado' => ['required', Rule::in(['Nueva', 'En Proceso', 'Resuelta'])],
            'tipo' => ['nullable', Rule::in(['hostil', 'no hostil'])],
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
        ]);

        // Generar ID si no existe
        $validatedData['id_alerta'] = $validatedData['id_alerta'] ?? 'ALR-' . strtoupper(Str::random(6));

        // Guardar imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'IMG_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/alerts'), $filename);
            $validatedData['imagen'] = 'images/alerts/' . $filename;
        }

        $validatedData['enviado'] = false;

        Alerta::create($validatedData);

        return redirect()->route('alertas.index')->with('success', '✅ Alerta registrada correctamente.');
    }

    /**
     * 👁️ Ver alerta individual
     */
    public function show(Alerta $alerta): View
    {
        return view('guardaparques.alertas.show', compact('alerta'));
    }

    /**
     * ✏️ Editar alerta existente
     */
    public function edit(Alerta $alerta): View
    {
        return view('guardaparques.alertas.edit', compact('alerta'));
    }

    /**
     * 🔄 Actualizar datos de alerta
     */
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

        return redirect()->route('alertas.index')->with('success', '✅ Alerta actualizada correctamente.');
    }

    /**
     * 🗑️ Eliminar alerta y su imagen
     */
    public function destroy(Alerta $alerta): RedirectResponse
    {
        if ($alerta->imagen && file_exists(public_path($alerta->imagen))) {
            unlink(public_path($alerta->imagen));
        }

        $alerta->delete();

        return redirect()->route('alertas.index')->with('success', '🗑️ Alerta eliminada correctamente.');
    }

    /**
     * 📧 Enviar correo con alerta a guardaparques
     */
    public function send(Alerta $alerta): RedirectResponse
    {
        if (!$alerta->enviado) {
            $guardaparques = User::where('role', 'guardaparque')->get();
            foreach ($guardaparques as $g) {
                Mail::to($g->email)->send(new AlertaMail($alerta));
            }
            $alerta->update(['enviado' => true]);
        }

        return back()->with('success', '📩 Alerta enviada a los guardaparques.');
    }
}
