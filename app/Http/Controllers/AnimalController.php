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
    /** Muestra la tabla CRUD de animales. (GET /animales) */
    public function index(): View
    {
        $animales = Animal::paginate(10);
        return view('guardaparques.animales.index', compact('animales'));
    }

    /** Muestra el formulario de creación. (GET /animales/create) */
    public function create(): View
    {
        return view('guardaparques.animales.create');
    }

    /** Almacena un nuevo animal. (POST /animales) */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => 'required|max:255|unique:animals,nombre_cientifico',
            'habitat' => 'required|max:255',
            'tipo' => ['required', Rule::in(['Pacifico', 'Hostil'])],
            'descripcion' => 'nullable|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'nullable|numeric', // Campo añadido
            'longitud' => 'nullable|numeric', // Campo añadido
        ]);

        // 1. Subida de Imagen
        $imagePath = $request->file('imagen') ?
            $request->file('imagen')->store('imagenes/animales', 'public') :
            null;

        // 2. Crear el registro del animal
        $animal = Animal::create(array_merge($validatedData, [
            'imagen_path' => $imagePath,
            // Aseguramos que lat/lng se guarden si existen en el request (aunque el formulario no los muestre aún)
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
        ]));

        // 3. Generación del Código QR Único
        $qrCodeContent = route('animales.ficha', ['animal' => $animal->id]);
        $qrPath = 'qrcodes/animales/' . $animal->id . '.svg';

        // Asegúrate de tener la librería SimpleSoftwareIO/laravel-qrcode instalada y configurada
        QrCode::size(200)->generate($qrCodeContent, public_path('storage/' . $qrPath));

        // 4. Actualizar el modelo con la ruta del QR generado
        $animal->update(['codigo_qr' => 'storage/' . $qrPath]);

        return redirect()->route('animales.index')->with('success', 'Especie registrada con éxito. QR generado.');
    }

    /** Muestra la ficha de un animal (GET /animales/ficha/{animal}) */
    public function show(Animal $animal): View
    {
        return view('guardaparques.animales.ficha_publica', compact('animal'));
    }


    /** Muestra el formulario de edición. (GET /animales/{animal}/edit) */
    public function edit(Animal $animal): View
    {
        return view('guardaparques.animales.edit', compact('animal'));
    }

    /** Actualiza el recurso. (PUT/PATCH /animales/{animal}) */
    public function update(Request $request, Animal $animal): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => ['required', 'max:255', Rule::unique('animals', 'nombre_cientifico')->ignore($animal->id)],
            'habitat' => 'required|max:255',
            'tipo' => ['required', Rule::in(['Pacifico', 'Hostil'])],
            'descripcion' => 'nullable|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'nullable|numeric', // Campo añadido
            'longitud' => 'nullable|numeric', // Campo añadido
        ]);

        // Manejo de la imagen: si se sube una nueva, elimina la antigua
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
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
        ]));

        return redirect()->route('guardaparques.animales.index')->with('success', 'Especie actualizada.');
    }

    /** Elimina el recurso. (DELETE /animales/{animal}) */
    public function destroy(Animal $animal): RedirectResponse
    {
        // Eliminar archivos asociados (imagen y QR)
        if ($animal->imagen_path) {
            Storage::disk('public')->delete($animal->imagen_path);
        }
        if ($animal->codigo_qr) {
            Storage::disk('public')->delete(str_replace('storage/', '', $animal->codigo_qr));
        }

        $animal->delete();
        return redirect()->route('guardaparques.animales.index')->with('success', 'Especie eliminada.');
    }
}