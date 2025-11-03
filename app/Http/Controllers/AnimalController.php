<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AnimalController extends Controller
{
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

    public function create()
    {
        return view('guardaparques.animales.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_comun' => 'required|string|max:255',
            'nombre_cientifico' => 'required|string|max:255',
            'habitat' => 'nullable|string|max:255',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ], [
            'imagen.max' => 'La imagen no puede superar los 10 MB.',
        ]);

        $animal = Animal::create($request->except('imagen'));

        $animalDir = public_path('images/animals');
        $qrDir = public_path('images/qr');
        if (!is_dir($animalDir))
            mkdir($animalDir, 0755, true);
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'animal_' . $animal->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($animalDir, $filename);
            $animal->imagen_path = 'images/animals/' . $filename;
        }

        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = 'ANIMAL-' . $animal->id;
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));
        $animal->codigo_qr = $qrPath;

        $animal->save();

        return redirect()->route('animales.index')->with('success', '✅ Especie registrada correctamente.');
    }

    public function show(Animal $animal)
    {
        return view('guardaparques.animales.show', compact('animal'));
    }

    public function ficha_publica(Animal $animal)
    {
        return view('guardaparques.animales.ficha_publica', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        return view('guardaparques.animales.edit', compact('animal'));
    }

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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ], [
            'imagen.max' => 'La imagen no puede superar los 10 MB.',
        ]);

        $animal->fill($request->only([
            'nombre_comun',
            'nombre_cientifico',
            'habitat',
            'tipo',
            'descripcion',
            'latitud',
            'longitud'
        ]));

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = 'animal_' . $animal->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $animalDir = public_path('images/animals');
            if (!is_dir($animalDir))
                mkdir($animalDir, 0755, true);

            if ($animal->imagen_path && file_exists(public_path($animal->imagen_path))) {
                unlink(public_path($animal->imagen_path));
            }

            $file->move($animalDir, $filename);
            $animal->imagen_path = 'images/animals/' . $filename;
        }

        $qrDir = public_path('images/qr');
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);
        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = 'ANIMAL-' . $animal->id;
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));
        $animal->codigo_qr = $qrPath;

        $animal->save();

        return redirect()->route('animales.index')->with('success', '✅ Especie actualizada correctamente.');
    }

    public function regenerarQR($id)
    {
        $animal = Animal::findOrFail($id);
        $qrDir = public_path('images/qr');
        if (!is_dir($qrDir))
            mkdir($qrDir, 0755, true);

        $qrPath = 'images/qr/qr_' . $animal->id . '.svg';
        $qrData = 'ANIMAL-' . $animal->id;
        QrCode::format('svg')->size(300)->generate($qrData, public_path($qrPath));
        $animal->codigo_qr = $qrPath;
        $animal->save();

        return redirect()->back()->with('success', '🔁 QR regenerado correctamente.');
    }

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
