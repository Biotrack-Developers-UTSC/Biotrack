<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AnimalController extends Controller
{
    /** 📋 Mostrar listado de animales con filtros */
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

    /** 🦎 Formulario de registro de nueva especie */
    public function create()
    {
        return view('guardaparques.animales.create');
    }

    /** 💾 Guardar nueva especie con imagen y QR */
    public function store(Request $request)
    {
        // Validación (hasta 10 MB)
        $validatedData = $request->validate([
            'nombre_comun' => 'required|string|max:255',
            'nombre_cientifico' => 'required|string|max:255',
            'habitat' => 'nullable|string|max:255',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10 MB
        ], [
            'imagen.max' => 'La imagen no puede superar los 10 MB.',
        ]);

        // Crear registro inicial
        $animal = Animal::create($request->except('imagen'));

        // Carpetas
        $animalDir = public_path('images/animals');
        $qrDir = public_path('images/qr');
        if (!is_dir($animalDir))
            mkdir($animalDir, 0755, true);
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);

        // Subir imagen si existe
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'animal_' . $animal->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($animalDir, $filename);
            $animal->imagen_path = 'images/animals/' . $filename;
        }

        // Generar QR
        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = "Especie: {$animal->nombre_comun}\nNombre científico: {$animal->nombre_cientifico}\nHábitat: {$animal->habitat}\nTipo: {$animal->tipo}";
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));
        $animal->codigo_qr = $qrPath;

        $animal->save();

        return redirect()->route('animales.index')->with('success', '✅ Especie registrada correctamente.');
    }

    /** 📄 Mostrar detalles del animal */
    public function show(Animal $animal)
    {
        return view('guardaparques.animales.show', compact('animal'));
    }

    /** 🌎 Ficha pública */
    public function ficha_publica(Animal $animal)
    {
        return view('guardaparques.animales.ficha_publica', compact('animal'));
    }

    /** ✏️ Formulario de edición */
    public function edit(Animal $animal)
    {
        return view('guardaparques.animales.edit', compact('animal'));
    }

    /** 💾 Actualizar especie con imagen y QR */
    public function update(Request $request, Animal $animal)
    {
        $request->validate([
            'nombre_comun' => 'required|string|max:255',
            'nombre_cientifico' => 'required|string|max:255',
            'habitat' => 'nullable|string|max:255',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10 MB
        ], [
            'imagen.max' => 'La imagen no puede superar los 10 MB.',
        ]);

        // Actualizar campos
        $animal->fill($request->only([
            'nombre_comun',
            'nombre_cientifico',
            'habitat',
            'tipo',
            'descripcion',
            'latitud',
            'longitud'
        ]));

        // Procesar imagen si se subió
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'animal_' . $animal->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $animalDir = public_path('images/animals');
            if (!is_dir($animalDir))
                mkdir($animalDir, 0755, true);

            // Borrar imagen anterior
            if ($animal->imagen_path && file_exists(public_path($animal->imagen_path))) {
                unlink(public_path($animal->imagen_path));
            }

            $file->move($animalDir, $filename);
            $animal->imagen_path = 'images/animals/' . $filename;
        }

        // Generar QR
        $qrDir = public_path('images/qr');
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);
        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = route('animales.show', $animal->id);
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));
        $animal->codigo_qr = $qrPath;

        $animal->save();

        return redirect()->route('animales.index')->with('success', '✅ Especie actualizada correctamente.');
    }

    /** 🔁 Regenerar QR */
    public function regenerarQR($id)
    {
        $animal = Animal::findOrFail($id);
        $qrDir = public_path('images/qr');
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);

        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = "Especie: {$animal->nombre_comun}\nNombre científico: {$animal->nombre_cientifico}\nHábitat: {$animal->habitat}\nTipo: {$animal->tipo}";
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));

        $animal->codigo_qr = $qrPath;
        $animal->save();

        return redirect()->back()->with('success', '🔁 QR regenerado correctamente.');
    }

    /** 🗑️ Eliminar especie e imágenes */
    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        if ($animal->imagen_path && file_exists(public_path($animal->imagen_path))) {
            unlink(public_path($animal->imagen_path));
        }

        if ($animal->codigo_qr && file_exists(public_path($animal->codigo_qr))) {
            unlink(public_path($animal->codigo_qr));
        }

        $animal->delete();

        return redirect()->route('animales.index')->with('success', '❌ Especie eliminada correctamente.');
    }
}
