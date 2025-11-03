@extends('layouts.dashboard')
@section('title', 'Registrar Nueva Especie')

@section('content')
    <div class="container mx-auto py-10 max-w-4xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-emerald-700">🦎 Registrar Nueva Especie</h1>
            <a href="{{ route('animales.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                ← Volver al CRUD de Especies
            </a>
        </div>

        <form action="{{ route('animales.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-lg rounded-xl p-8 space-y-6">
            @csrf

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Información General</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre_comun" class="block font-medium text-gray-700">Nombre Común</label>
                    <input type="text" id="nombre_comun" name="nombre_comun" value="{{ old('nombre_comun') }}"
                        class="w-full border rounded p-2" required>
                    @error('nombre_comun') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nombre_cientifico" class="block font-medium text-gray-700">Nombre Científico</label>
                    <input type="text" id="nombre_cientifico" name="nombre_cientifico"
                        value="{{ old('nombre_cientifico') }}" class="w-full border rounded p-2" required>
                    @error('nombre_cientifico') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="habitat" class="block font-medium text-gray-700">Hábitat</label>
                    <input type="text" id="habitat" name="habitat" value="{{ old('habitat') }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label for="tipo" class="block font-medium text-gray-700">Tipo</label>
                    <select id="tipo" name="tipo" class="w-full border rounded p-2" required>
                        <option value="">Seleccionar...</option>
                        <option value="Pacífico" {{ old('tipo') == 'Pacífico' ? 'selected' : '' }}>Pacífico</option>
                        <option value="Hostil" {{ old('tipo') == 'Hostil' ? 'selected' : '' }}>Hostil</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full border rounded p-2">{{ old('descripcion') }}</textarea>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8">Ubicación del Hábitat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="latitud" class="block font-medium text-gray-700">Latitud</label>
                    <input type="number" step="any" id="latitud" name="latitud" value="{{ old('latitud') }}"
                        class="w-full border rounded p-2">
                </div>
                <div>
                    <label for="longitud" class="block font-medium text-gray-700">Longitud</label>
                    <input type="number" step="any" id="longitud" name="longitud" value="{{ old('longitud') }}"
                        class="w-full border rounded p-2">
                </div>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-8">Imagen</h2>
            <div>
                <img id="preview" src="" class="w-48 h-48 object-cover rounded-lg shadow mb-2 hidden">
                <input type="file" id="imagen" name="imagen" class="w-full border rounded p-2">
                @error('imagen') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('animales.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">💾 Guardar
                    y Generar QR</button>
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