@extends('layouts.app')
@section('title', 'Ficha Pública - ' . $animal->nombre_comun)

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">{{ $animal->nombre_comun }}</h1>

        <div class="flex space-x-3">
            {{-- Botón dinámico: si vino desde consultas --}}
            <a href="{{ route('consultas.index') }}" id="btn-volver-consultas"
                class="hidden px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                ← Volver al Catálogo Público
            </a>

            {{-- Botón CRUD (solo visible para admins o guardabosques) --}}
            @auth
                @php
                    $rolUsuario = auth()->user()->rol ?? auth()->user()->role ?? '';
                @endphp
                @if (in_array($rolUsuario, ['admin', 'guardabosques']))
                    <a href="{{ route('animales.index') }}"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        ← Volver al CRUD de Especies
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <h1 class="text-3xl font-bold text-green-700 mb-4 text-center">{{ $animal->nombre_comun }}</h1>
    <p class="text-center text-gray-600 italic mb-8">{{ $animal->nombre_cientifico }}</p>

    <div class="grid md:grid-cols-2 gap-8">
        {{-- IZQUIERDA --}}
        <div class="flex flex-col justify-start">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Información general</h2>
                <p><strong>Hábitat:</strong> {{ $animal->habitat }}</p>
                <p><strong>Tipo:</strong> {{ $animal->tipo }}</p>
                <p class="mt-3 text-gray-700"><strong>Descripción:</strong></p>
                <p class="text-gray-700 mb-4">{{ $animal->descripcion }}</p>

                {{-- Código QR debajo de la descripción --}}
                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Código QR</h2>
                    @if ($animal->codigo_qr)
                        <img src="{{ asset('storage/' . $animal->codigo_qr) }}" alt="Código QR"
                            class="w-40 rounded-lg shadow-md">
                    @else
                        <p class="text-gray-500">No hay QR generado.</p>
                    @endif
                </div>

                {{-- Imagen debajo del QR --}}
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Imagen del animal</h2>
                    @if ($animal->imagen_path)
                        <img src="{{ asset('storage/' . $animal->imagen_path) }}" alt="Imagen del animal"
                            class="rounded-lg shadow-md w-full">
                    @else
                        <div class="bg-gray-100 rounded-lg h-56 flex items-center justify-center text-gray-500">
                            Sin imagen disponible
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- DERECHA --}}
        <div class="flex flex-col justify-between">
            @if ($animal->latitud && $animal->longitud)
                <div class="h-full flex flex-col">
                    <h2 class="text-xl font-semibold text-green-700 mb-3">📍 Hábitat en el mapa</h2>
                    <div id="map" class="flex-1" style="height: 600px; border-radius: 10px;"></div>
                </div>
            @else
                <div class="flex-1 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                    No hay coordenadas registradas.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MAPA --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Mostrar botón de volver si vino desde consultas
        if (sessionStorage.getItem('from_consultas')) {
            document.getElementById('btn-volver-consultas').classList.remove('hidden');
            sessionStorage.removeItem('from_consultas');
        }

        @if ($animal->latitud && $animal->longitud)
            const map = L.map('map').setView([{{ $animal->latitud }}, {{ $animal->longitud }}], 9);
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
