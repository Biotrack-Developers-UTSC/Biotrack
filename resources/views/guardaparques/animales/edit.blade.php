@extends('layouts.app')

@section('title', 'Editar Especie')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-green-700">✏️ Editar Especie</h2>
            <a href="{{ route('animales.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                ← Volver al CRUD de Especies
            </a>
        </div>

        <form action="{{ route('animales.update', $animal->id) }}" method="POST" enctype="multipart/form-data">
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
                        <option value="Pacifico" {{ $animal->tipo == 'Pacifico' ? 'selected' : '' }}>Pacífico</option>
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
                    @if ($animal->imagen_path)
                        <img src="{{ asset('storage/' . $animal->imagen_path) }}" alt="Imagen del animal"
                            class="w-48 rounded-lg shadow mb-2">
                    @else
                        <p class="text-gray-500">No hay imagen registrada.</p>
                    @endif
                    <input type="file" name="imagen" class="w-full border-gray-300 rounded-lg mt-2">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700">Código QR actual</label>
                    @if ($animal->codigo_qr)
                        <img src="{{ asset('storage/' . $animal->codigo_qr) }}" alt="Código QR" class="w-32 rounded-lg shadow">
                    @else
                        <p class="text-gray-500">No hay QR generado.</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('animales.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection