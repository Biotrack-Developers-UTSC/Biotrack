@extends('layouts.app')

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
                        class="w-full border rounded p-2">
                    @error('nombre_comun') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nombre_cientifico" class="block font-medium text-gray-700">Nombre Científico</label>
                    <input type="text" id="nombre_cientifico" name="nombre_cientifico"
                        value="{{ old('nombre_cientifico') }}" class="w-full border rounded p-2">
                    @error('nombre_cientifico') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="habitat" class="block font-medium text-gray-700">Hábitat</label>
                    <input type="text" id="habitat" name="habitat" value="{{ old('habitat') }}"
                        class="w-full border rounded p-2">
                    @error('habitat') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tipo" class="block font-medium text-gray-700">Tipo</label>
                    <select id="tipo" name="tipo" class="w-full border rounded p-2">
                        <option value="">Seleccionar...</option>
                        <option value="Pacifico" {{ old('tipo') == 'Pacifico' ? 'selected' : '' }}>Pacífico</option>
                        <option value="Hostil" {{ old('tipo') == 'Hostil' ? 'selected' : '' }}>Hostil</option>
                    </select>
                    @error('tipo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="descripcion" class="block font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full border rounded p-2">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
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
                <input type="file" id="imagen" name="imagen" class="w-full border rounded p-2">
                @error('imagen') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('animales.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    💾 Guardar
                </button>
            </div>
        </form>
    </div>
@endsection