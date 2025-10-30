@extends('layouts.app')
@section('title', 'Registrar Nueva Especie')

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-green-700">
            <header class="mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800">Registro de Especie Silvestre</h1>
                <p class="text-gray-500">Completa los detalles de la especie para generar su registro y Código QR.</p>
            </header>

            {{-- Formulario para almacenar datos --}}
            <form action="{{ route('animales.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- Fila 1: Nombres y Tipo --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- CAMPO: NOMBRE COMÚN --}}
                    <div class="mb-4">
                        <label for="nombre_comun" class="block text-sm font-medium text-gray-700">Nombre Común <span
                                class="text-red-500">*</span></label>
                        <input type="text"
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            id="nombre_comun" name="nombre_comun" value="{{ old('nombre_comun') }}" required>
                        @error('nombre_comun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- CAMPO: NOMBRE CIENTÍFICO --}}
                    <div class="mb-4">
                        <label for="nombre_cientifico" class="block text-sm font-medium text-gray-700">Nombre Científico
                            <span class="text-red-500">*</span></label>
                        <input type="text"
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            id="nombre_cientifico" name="nombre_cientifico" value="{{ old('nombre_cientifico') }}" required>
                        @error('nombre_cientifico') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Fila 2: Hábitat y Tipo --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- CAMPO: HÁBITAT --}}
                    <div class="mb-4">
                        <label for="habitat" class="block text-sm font-medium text-gray-700">Hábitat (Ej: Bosque Húmedo,
                            Desierto) <span class="text-red-500">*</span></label>
                        <input type="text"
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            id="habitat" name="habitat" value="{{ old('habitat') }}" required>
                        @error('habitat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- CAMPO: TIPO (ENUM) --}}
                    <div class="mb-4">
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Clasificación <span
                                class="text-red-500">*</span></label>
                        <select id="tipo" name="tipo" required
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="Pacifico" {{ old('tipo') == 'Pacifico' ? 'selected' : '' }}>Pacífico (No agresivo)
                            </option>
                            <option value="Hostil" {{ old('tipo') == 'Hostil' ? 'selected' : '' }}>Hostil (Peligroso)</option>
                        </select>
                        @error('tipo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- CAMPO: DESCRIPCIÓN --}}
                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción Detallada</label>
                    <textarea id="descripcion" name="descripcion" rows="4"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('descripcion') }}</textarea>
                    @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- CAMPO: IMAGEN --}}
                <div class="mb-6">
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen de la Especie (Máx
                        2MB)</label>
                    <input type="file"
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        id="imagen" name="imagen" accept="image/jpeg,image/png">
                    @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-between items-center border-t pt-6">
                    <a href="{{ route('animales.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        ← Volver a la Lista
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-colors">
                        <i class="fas fa-save mr-2"></i> Registrar y Generar QR
                    </button>
                </div>
            </form>
        </div>


    </div>
@endsection