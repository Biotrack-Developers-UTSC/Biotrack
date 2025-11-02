@extends('layouts.app')

@section('title', 'Editar Especie')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-green-700">✏️ Editar Especie</h2>
            <a href="{{ route('animales.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">← Volver al
                CRUD de Especies</a>
        </div>

        <form action="{{ route('animales.update', $animal) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Información General</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700">Nombre común</label>
                    <input type="text" name="nombre_comun" value="{{ old('nombre_comun', $animal->nombre_comun) }}"
                        class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Nombre científico</label>
                    <input type="text" name="nombre_cientifico"
                        value="{{ old('nombre_cientifico', $animal->nombre_cientifico) }}"
                        class="w-full border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Hábitat</label>
                    <input type="text" name="habitat" value="{{ old('habitat', $animal->habitat) }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Tipo</label>
                    <select name="tipo" class="w-full border-gray-300 rounded-lg">
                        <option value="Pacífico" {{ $animal->tipo == 'Pacífico' ? 'selected' : '' }}>Pacífico</option>
                        <option value="Hostil" {{ $animal->tipo == 'Hostil' ? 'selected' : '' }}>Hostil</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block font-semibold text-gray-700">Descripción</label>
                <textarea name="descripcion" rows="4"
                    class="w-full border-gray-300 rounded-lg">{{ old('descripcion', $animal->descripcion) }}</textarea>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8">Ubicación del Hábitat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700">Latitud</label>
                    <input type="number" step="any" name="latitud" value="{{ old('latitud', $animal->latitud) }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Longitud</label>
                    <input type="number" step="any" name="longitud" value="{{ old('longitud', $animal->longitud) }}"
                        class="w-full border-gray-300 rounded-lg">
                </div>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8">Imágenes y Código QR</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700">Imagen actual</label>
                    <img id="preview" src="{{ $animal->imagen_path ? asset($animal->imagen_path) : '' }}"
                        class="w-48 h-48 object-cover rounded-lg shadow mb-2 {{ $animal->imagen_path ? '' : 'hidden' }}">
                    <input type="file" name="imagen" class="form-control mt-2">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Código QR</label>
                    @if ($animal->codigo_qr)
                        <img src="{{ asset($animal->codigo_qr) }}" alt="QR del animal"
                            class="w-40 h-40 object-contain rounded-lg shadow mb-2">
                    @else
                        <p class="text-gray-500">Se generará al guardar cambios.</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('animales.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">←
                    Cancelar</a>
                <a href="{{ route('animales.regenerarQR', $animal->id) }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">🔁 Regenerar QR</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">💾 Guardar
                    cambios</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const inputFile = document.querySelector('input[name="imagen"]');
            const preview = document.getElementById('preview');

            inputFile.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const maxSize = 10 * 1024 * 1024; // 10 MB

                    if (file.size > maxSize) {
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Archivo muy pesado',
                            html: `El archivo pesa <strong>${fileSizeMB} MB</strong> y supera el límite máximo de <strong>10 MB</strong>.<br>Por favor selecciona uno más ligero.`,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar'
                        });
                        inputFile.value = '';
                        preview.classList.add('hidden');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        preview.src = ev.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection