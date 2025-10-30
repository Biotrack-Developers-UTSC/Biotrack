@extends('layouts.app')
@section('title', 'Catálogo de Especies')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Catálogo de Especies Silvestres 🌿</h1>
            <p class="text-gray-600">Explora la fauna monitoreada por BioTrack. Usa el escáner QR para ver fichas
                detalladas.</p>
        </header>

        {{-- SECCIÓN DE FILTROS Y BÚSQUEDA --}}
        <div
            class="bg-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 items-center">
            <div class="w-full md:w-1/3">
                <label for="search" class="sr-only">Buscar Especie</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search" placeholder="Buscar por nombre común o científico..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                </div>
            </div>

            <div class="w-full md:w-auto">
                <label for="tipo_filtro" class="sr-only">Filtrar por Tipo</label>
                <select id="tipo_filtro"
                    class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                    <option value="">Mostrar todos los tipos</option>
                    <option value="Pacifico">Pacífico</option>
                    <option value="Hostil">Hostil</option>
                </select>
            </div>

            <button onclick="window.location.href='{{ route('qr.scanner.ui') }}'"
                class="w-full md:w-auto px-4 py-2 bg-cyan-600 text-white font-semibold rounded-lg hover:bg-cyan-700 transition-colors flex items-center justify-center">
                <i class="fas fa-qrcode mr-2"></i> Escanear QR
            </button>
        </div>

        {{-- TABLA DE RESULTADOS (Consulta de Solo Lectura) --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre Común</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hábitat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="animal-list" class="bg-white divide-y divide-gray-200">

                        {{-- Iterar sobre la colección de animales que viene de ConsultaController --}}
                        @forelse($animales as $animal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $animal->nombre_comun }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $animal->habitat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($animal->tipo === 'Pacifico') bg-green-100 text-green-800 
                                            @else bg-red-100 text-red-800 @endif">
                                        {{ $animal->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    {{-- Enlace que lleva a la ficha pública con mapa --}}
                                    <a href="{{ route('animales.ficha', $animal->id) }}"
                                        class="text-cyan-600 hover:text-cyan-900 ml-4">Ver Ficha Detallada</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 text-lg">
                                    No se encontraron especies.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection