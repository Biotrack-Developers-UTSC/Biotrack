@extends('layouts.app')
@section('title', 'Ficha Pública: ' . $animal->nombre_comun)

{{-- Se requiere que el layout principal tenga secciones @yield('styles') y @yield('scripts') --}}
@section('styles')
    {{-- Leaflet CSS para los estilos del mapa --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 250px;
            width: 100%;
            border-radius: 8px;
        }

        .ficha-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .ficha-grid {
                /* Definimos 2 columnas: 1 para la imagen, 1 para el contenido */
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-cyan-700 mb-2">{{ $animal->nombre_comun }}</h1>
            <p class="text-xl text-gray-600 italic">{{ $animal->nombre_cientifico }}</p>
        </header>

        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-cyan-500">

            <div class="ficha-grid">

                {{-- ========== COLUMNA IZQUIERDA: IMAGEN (TOP LEFT y BOTTOM LEFT) ========== --}}
                <div class="md:row-span-2 flex flex-col items-center">
                    <img src="{{ asset('storage/' . $animal->imagen_path) }}" alt="{{ $animal->nombre_comun }}"
                        class="w-full h-full object-cover rounded-xl shadow-lg mb-4" style="max-height: 550px;"
                        onerror="this.onerror=null;this.src='https://placehold.co/600x600/e0f2f1/0891b2?text=Sin+Imagen';">
                </div>

                {{-- ========== COLUMNA DERECHA: MAPA (TOP RIGHT) ========== --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3 border-b pb-2">Última Ubicación</h3>

                    {{-- Contenedor del Mapa Leaflet --}}
                    <div id="map"></div>

                    <p class="text-xs text-gray-500 mt-2">Lat: {{ $animal->latitud ?? 'N/A' }}, Lng:
                        {{ $animal->longitud ?? 'N/A' }}</p>
                </div>

                {{-- ========== COLUMNA DERECHA: INFO Y QR (BOTTOM RIGHT) ========== --}}
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2 border-b pb-2">Detalles y Herramientas</h3>

                    {{-- Detalles Clave --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-800 mb-2">Hábitat:</p>
                        <p class="text-gray-600 font-medium">{{ $animal->habitat }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-800 mb-2">Clasificación:</p>
                        <span class="px-4 py-1 inline-flex text-sm font-bold rounded-full 
                            @if($animal->tipo === 'Pacifico') bg-green-600 text-white 
                            @else bg-red-600 text-white @endif">
                            {{ $animal->tipo }}
                        </span>
                    </div>

                    {{-- QR y Descripción --}}
                    <div class="p-4 bg-cyan-50 rounded-lg text-center border border-cyan-100">
                        <p class="font-medium text-cyan-700 mb-3">Descripción:</p>
                        <p class="text-sm text-gray-700 mb-4">{{ $animal->descripcion ?? 'Descripción no disponible.' }}</p>

                        @if($animal->codigo_qr)
                            <img src="{{ asset($animal->codigo_qr) }}" alt="QR Code" class="mx-auto" width="100">
                            <p class="text-xs text-gray-500 mt-1">Código de Identificación Rápida</p>
                        @endif
                    </div>

                </div>

            </div>

            {{-- Botón de Volver --}}
            <div class="mt-8 border-t pt-6 text-center">
                <a href="{{ route('consultas.animales') }}"
                    class="px-6 py-3 bg-cyan-600 text-white font-semibold rounded-lg hover:bg-cyan-700 transition-colors shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i> Volver al Catálogo
                </a>
            </div>

        </div>
    </div>

    {{-- 🌟 SCRIPTS DE LEAFLET (Implementación) 🌟 --}}
    @section('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20n6aR4S668jA8F3m9JjPj1XQoQ65yVl91P8qD+a9aA=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Aseguramos que las coordenadas existan para inicializar el mapa
                // Usamos los valores de la DB, con fallback seguro si son nulos.
                const lat = {{ $animal->latitud ?? 20.6 }};
                const lng = {{ $animal->longitud ?? -99.1 }};

                // Inicializar el mapa
                const map = L.map('map').setView([lat, lng], 10);

                // Añadir capa de OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Añadir un marcador a la ubicación del animal
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('<b>{{ $animal->nombre_comun }}</b><br>Última Posición.')
                    .openPopup();
            });
        </script>
    @endsection
@endsection