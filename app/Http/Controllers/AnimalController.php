<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Usamos la librería instalada

class AnimalController extends Controller
{
    // Muestra la lista de animales para CRUD (GET /animales)
    // Es accesible solo para Guardaparques y Admin (por el middleware de la ruta)
    public function index(): View
    {
        $animales = Animal::all();
        // 🚩 CORRECCIÓN: Muestra la tabla CRUD en su propia vista index, no en el dashboard.
        return view('guardaparque.animales.index', compact('animales'));
    }

    // Muestra la vista del formulario de creación (GET /animales/create)
    public function create(): View
    {
        return view('guardaparque.animales.create');
    }

    // Guarda un nuevo animal (POST /animales)
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => 'required|max:255',
            'tipo' => 'required|in:Pacifico,Hostil',
            'descripcion' => 'nullable|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Subida de Imagen
        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('imagenes/animales', 'public');
        }

        // 2. Crear el registro del animal (temporalmente sin QR)
        $animal = Animal::create([
            'nombre_comun' => $validatedData['nombre_comun'],
            'nombre_cientifico' => $validatedData['nombre_cientifico'],
            'tipo' => $validatedData['tipo'],
            'descripcion' => $validatedData['descripcion'],
            'imagen_path' => $imagePath,
        ]);

        // 3. Generación del Código QR Único
        // El contenido del QR será la URL de la ruta pública de escaneo: /scan/{id}
        // Nota: Asegúrate de tener la ruta 'animales.scan' definida en web.php
        $qrCodeContent = route('animales.scan', ['qrCode' => $animal->id]);

        // Guardar el archivo QR en storage/app/public/qrcodes/animales/
        $qrPath = 'qrcodes/animales/' . $animal->id . '.svg';

        // La librería de QR necesita la ruta física
        QrCode::size(200)->generate($qrCodeContent, public_path('storage/' . $qrPath));

        // 4. Actualizar el modelo con la ruta del QR generado
        $animal->update(['codigo_qr' => 'storage/' . $qrPath]); // Guardamos la ruta pública

        return redirect()->route('animales.index')->with('success', 'Especie registrada con éxito. QR generado.');
    }

    // Muestra la ficha de un animal (GET /scan/{qrCode})
    // 🚩 CORRECCIÓN/OPTIMIZACIÓN: Usa la clave $qrCode para capturar el ID de la URL
    public function show(string $qrCode): View
    {
        // Busca el animal por su ID que es pasado como $qrCode
        $animal = Animal::findOrFail($qrCode);
        // Esta vista es accesible para TODOS, incluidos visitantes no logueados o usuarios regulares.
        return view('animales.show', compact('animal'));
    }

    // Muestra el formulario de edición (GET /animales/{animal}/edit)
    public function edit(Animal $animal): View
    {
        return view('guardaparque.animales.edit', compact('animal'));
    }

    // Actualiza un animal (PUT/PATCH /animales/{animal})
    public function update(Request $request, Animal $animal): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|max:255',
            'tipo' => 'required|in:Pacifico,Hostil',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // Añade validación para los otros campos si es necesario
        ]);

        $imagePath = $animal->imagen_path;
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen antigua si existe
            if ($animal->imagen_path) {
                Storage::disk('public')->delete($animal->imagen_path);
            }
            $imagePath = $request->file('imagen')->store('imagenes/animales', 'public');
        }

        $animal->update([
            'nombre_comun' => $validatedData['nombre_comun'],
            'tipo' => $validatedData['tipo'],
            'imagen_path' => $imagePath,
            // ... otros campos
        ]);

        return redirect()->route('animales.index')->with('success', 'Especie actualizada con éxito.');
    }

    // Elimina un animal (DELETE /animales/{animal})
    public function destroy(Animal $animal): RedirectResponse
    {
        // Eliminar archivos asociados (imagen y QR)
        if ($animal->imagen_path) {
            Storage::disk('public')->delete($animal->imagen_path);
        }
        if ($animal->codigo_qr) {
            // El código QR está guardado en public/storage/qrcodes/animales/
            Storage::disk('public')->delete(str_replace('storage/', '', $animal->codigo_qr));
        }

        $animal->delete();
        return redirect()->route('animales.index')->with('success', 'Especie eliminada con éxito.');
    }

    // LÓGICA DE FILTRADO POR TIPO (Ideal para la vista de consultas del usuario regular)
    // Nota: Esta lógica debería estar en ConsultaController si solo la usan los usuarios regulares,
    // pero funciona aquí si la usa el guardaparque.
    public function filterByType(string $tipo): View
    {
        if (!in_array($tipo, ['Pacifico', 'Hostil'])) {
            $animales = Animal::all();
        } else {
            $animales = Animal::where('tipo', $tipo)->get();
        }
        return view('guardaparque.animales.index', compact('animales', 'tipo'));
    }
}
