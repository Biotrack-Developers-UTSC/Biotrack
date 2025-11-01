<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Animal;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    /** 🐾 Listado principal de animales (GET /animales) */
    public function index(Request $request)
    {
        $query = Animal::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('nombre')) {
            $query->where('nombre_comun', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('nombre_cientifico')) {
            $query->where('nombre_cientifico', 'like', '%' . $request->nombre_cientifico . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $animales = $query->paginate(10);
        return view('guardaparques.animales.index', compact('animales'));
    }

    /** Formulario de creación */
    public function create(): View
    {
        return view('guardaparques.animales.create');
    }

    /** Guarda un nuevo animal y genera su QR */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => 'required|max:255|unique:animales,nombre_cientifico',
            'habitat' => 'required|max:255',
            'tipo' => ['required', Rule::in(['Pacífico', 'Hostil'])],
            'descripcion' => 'nullable|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);

        $imagePath = $request->file('imagen')
            ? $request->file('imagen')->store('imagenes/animales', 'public')
            : null;

        $animal = Animal::create(array_merge($validatedData, [
            'imagen_path' => $imagePath,
        ]));

        $qrCodeContent = "ANIMAL-" . $animal->id;
        $qrPath = 'QR_images/' . $animal->id . '.svg';

        if (!Storage::disk('public')->exists('QR_images')) {
            Storage::disk('public')->makeDirectory('QR_images');
        }

        $svg_qr = QrCode::size(200)->generate($qrCodeContent);
        Storage::disk('public')->put($qrPath, $svg_qr);

        $animal->update(['codigo_qr' => 'storage/' . $qrPath]);

        return redirect()
            ->route('animales.index')
            ->with('success', "Especie registrada con éxito. Código QR generado: $qrCodeContent");
    }

    /** Vista detallada */
    public function show(Animal $animal): View
    {
        return view('guardaparques.animales.show', compact('animal'));
    }

    /** Vista pública */
    public function ficha_publica(Animal $animal): View
    {
        return view('guardaparques.animales.ficha_publica', compact('animal'));
    }

    /** Formulario de edición */
    public function edit(Animal $animal): View
    {
        return view('guardaparques.animales.edit', compact('animal'));
    }

    /** Actualiza un animal */
    public function update(Request $request, Animal $animal): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => [
                'required',
                'max:255',
                Rule::unique('animales', 'nombre_cientifico')->ignore($animal->id),
            ],
            'habitat' => 'required|max:255',
            'tipo' => ['required', Rule::in(['Pacífico', 'Hostil'])],
            'descripcion' => 'nullable|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);

        if ($request->hasFile('imagen')) {
            if ($animal->imagen_path) {
                Storage::disk('public')->delete($animal->imagen_path);
            }
            $imagePath = $request->file('imagen')->store('imagenes/animales', 'public');
        } else {
            $imagePath = $animal->imagen_path;
        }

        $animal->update(array_merge($validatedData, [
            'imagen_path' => $imagePath,
        ]));

        return redirect()
            ->route('animales.index')
            ->with('success', 'Especie actualizada correctamente.');
    }

    /** Elimina un animal */
    public function destroy(Animal $animal): RedirectResponse
    {
        if ($animal->imagen_path) {
            Storage::disk('public')->delete($animal->imagen_path);
        }

        if ($animal->codigo_qr) {
            Storage::disk('public')->delete(str_replace('storage/', '', $animal->codigo_qr));
        }

        $animal->delete();

        return redirect()
            ->route('animales.index')
            ->with('success', 'Especie eliminada correctamente.');
    }
}
