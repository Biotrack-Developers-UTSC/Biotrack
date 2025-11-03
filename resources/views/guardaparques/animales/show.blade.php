@extends('layouts.dashboard')
@section('title', $animal->nombre_comun)

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('animales.index') }}"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                ← Volver al CRUD de Especies
            </a>
        </div>
        <h2 class="text-2xl font-bold mb-6 text-green-700">
            🔍 Detalles del Animal: {{ $animal->nombre_comun }}
        </h2>

        <table class="w-full border border-gray-200 rounded-lg mb-6">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="font-semibold p-3 bg-gray-50 w-1/3">Nombre común</td>
                    <td class="p-3">{{ $animal->nombre_comun }}</td>
                </tr>
                <tr>
                    <td class="font-semibold p-3 bg-gray-50">Nombre científico</td>
                    <td class="p-3 italic">{{ $animal->nombre_cientifico }}</td>
                </tr>
                <tr>
                    <td class="font-semibold p-3 bg-gray-50">Hábitat</td>
                    <td class="p-3">{{ $animal->habitat }}</td>
                </tr>
                <tr>
                    <td class="font-semibold p-3 bg-gray-50">Tipo</td>
                    <td class="p-3">{{ $animal->tipo }}</td>
                </tr>
                <tr>
                    <td class="font-semibold p-3 bg-gray-50">Descripción</td>
                    <td class="p-3 text-gray-700">{{ $animal->descripcion }}</td>
                </tr>
                <tr>
                    <td class="font-semibold p-3 bg-gray-50">Coordenadas</td>
                    <td class="p-3">
                        {{ $animal->latitud ?? 'N/A' }}, {{ $animal->longitud ?? 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Imagen</h3>
                {{-- Mostrar imagen del animal --}}
                @if ($animal->imagen_path)
                    <img src="{{ asset($animal->imagen_path) }}" alt="Imagen del animal" class="rounded-lg shadow-md w-full">
                @else
                    <div class="bg-gray-100 rounded-lg h-48 flex items-center justify-center text-gray-500">
                        Sin imagen disponible
                    </div>
                @endif
            </div>

            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Código QR</h3>
                {{-- Mostrar QR --}}
                @if ($animal->codigo_qr)
                    <img src="{{ asset($animal->codigo_qr) }}" alt="QR" class="w-32 rounded-lg shadow">
                @else
                    <p class="text-gray-500">No hay QR generado.</p>
                @endif
            </div>
        </div>

        @if ($animal->latitud && $animal->longitud)
            <div class="mt-8">
                <h3 class="text-xl font-bold text-green-700 mb-2">📍 Ubicación del hábitat</h3>
                <div id="map" style="height: 400px; border-radius: 10px;"></div>
            </div>
        @endif
    </div>

    {{-- Leaflet Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @if ($animal->latitud && $animal->longitud)
                const map = L.map('map').setView([{{ $animal->latitud }}, {{ $animal->longitud }}], 10);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);
                L.marker([{{ $animal->latitud }}, {{ $animal->longitud }}])
                    .addTo(map)
                    .bindPopup("<b>{{ $animal->nombre_comun }}</b><br>{{ $animal->habitat }}");
            @endif
                        });
    </script>
@endsection