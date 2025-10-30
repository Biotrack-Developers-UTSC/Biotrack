@extends('layouts.app')
@section('title', 'Detalles de Especie: ' . $animal->nombre_comun)

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-green-700">

            <header class="mb-8 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-extrabold text-green-800">{{ $animal->nombre_comun }}</h1>
                    <p class="text-lg text-gray-500 mt-1">({{ $animal->nombre_cientifico }})</p>
                </div>
                <a href="{{ route('animales.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left"></i> Volver al CRUD
                </a>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Columna de Imagen y QR --}}
                <div class="md:col-span-1 space-y-4">
                    <h3 class="text-xl font-semibold text-gray-700">Archivos y QR</h3>

                    <div class="p-4 bg-gray-50 rounded-lg text-center border">
                        <p class="font-medium mb-2">Imagen Actual:</p>
                        @if($animal->imagen_path)
                            <img src="{{ asset('storage/' . $animal->imagen_path) }}" alt="{{ $animal->nombre_comun }}"
                                class="w-full h-auto object-cover rounded-lg shadow-md mb-3"
                                onerror="this.onerror=null;this.src='https://placehold.co/300x200/cccccc/333333?text=Sin+Imagen';">
                        @else
                            <p class="text-sm text-gray-500">No hay imagen cargada.</p>
                        @endif
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg text-center border">
                        <p class="font-medium mb-2">Código QR:</p>
                        @if($animal->codigo_qr)
                            {{-- La ruta del QR codifica la URL pública para escanear --}}
                            <img src="{{ asset($animal->codigo_qr) }}" alt="QR Code" class="mx-auto" width="150" height="150">
                            <p class="text-xs text-gray-600 mt-2">Usado para la ficha pública.</p>
                        @else
                            <p class="text-sm text-red-500">QR Pendiente de generación.</p>
                        @endif
                    </div>
                </div>

                {{-- Columna de Metadatos y Ubicación --}}
                <div class="md:col-span-2 space-y-6">
                    <h3 class="text-xl font-semibold text-gray-700">Metadatos de Gestión</h3>

                    <table class="w-full text-left divide-y divide-gray-200 border rounded-lg">
                        <tbody class="divide-y divide-gray-100">
                            <tr class="bg-green-50">
                                <th class="px-4 py-3 font-medium text-green-700 w-1/3">Nombre Científico</th>
                                <td class="px-4 py-3 text-gray-800">{{ $animal->nombre_cientifico }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-700 w-1/3">Tipo de Especie</th>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($animal->tipo === 'Pacifico') bg-green-200 text-green-900 
                                @else bg-red-200 text-red-900 @endif">
                                        {{ $animal->tipo }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-700 w-1/3">Hábitat</th>
                                <td class="px-4 py-3 text-gray-800">{{ $animal->habitat }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-700 w-1/3">Última Latitud (GPS)</th>
                                <td class="px-4 py-3 text-gray-800">{{ $animal->latitud ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-700 w-1/3">Última Longitud (GPS)</th>
                                <td class="px-4 py-3 text-gray-800">{{ $animal->longitud ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-700 w-1/3">Registro Creado</th>
                                <td class="px-4 py-3 text-gray-800">{{ $animal->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 class="text-xl font-semibold text-gray-700">Descripción</h3>
                    <p class="text-gray-600 bg-gray-50 p-4 rounded-lg border">
                        {{ $animal->descripcion ?? 'No hay descripción detallada disponible.' }}
                    </p>

                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="mt-8 border-t pt-6 text-right space-x-3">
                {{-- El botón de editar apunta al formulario de edición --}}
                <a href="{{ route('animales.edit', $animal) }}"
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar Datos
                </a>

                {{-- El botón de Eliminar usa un formulario DELETE --}}
                <form action="{{ route('animales.destroy', $animal) }}" method="POST" class="inline"
                    onsubmit="return confirm('ATENCIÓN: ¿Estás seguro de ELIMINAR esta especie y todos sus registros?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md">
                        <i class="fas fa-trash"></i> Eliminar Especie
                    </button>
                </form>
            </div>

        </div>


    </div>
@endsection