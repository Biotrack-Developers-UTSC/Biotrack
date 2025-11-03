@extends('layouts.dashboard')
@section('title', 'Mantenimiento del Sistema | BioTrack')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h1 class="text-4xl font-extrabold text-red-700 mb-10">⚙️ Mantenimiento del Sistema</h1>

        {{-- 📊 Estadísticas del sistema --}}
        @include('partials.dashboard_stats')

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 shadow">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">

            {{-- Limpiar cachés --}}
            <form action="{{ route('admin.system.clearCache') }}" method="POST" class="bg-white rounded-xl shadow p-6">
                @csrf
                <h2 class="text-2xl font-bold text-red-600 mb-3">🧹 Limpiar Caché</h2>
                <p class="text-gray-600 mb-4">Elimina cachés de configuración, rutas y vistas para resolver errores de
                    almacenamiento temporal.</p>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Limpiar
                    Caché</button>
            </form>

            {{-- Regenerar APP_KEY --}}
            <form action="{{ route('admin.system.regenerateKey') }}" method="POST" class="bg-white rounded-xl shadow p-6">
                @csrf
                <h2 class="text-2xl font-bold text-red-600 mb-3">🔑 Regenerar APP_KEY</h2>
                <p class="text-gray-600 mb-4">Genera una nueva clave de aplicación para reforzar la seguridad.
                    <strong>⚠️ Solo si es realmente necesario.</strong>
                </p>
                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">Regenerar
                    APP_KEY</button>
            </form>

            {{-- Actualizar Service Worker --}}
            <form action="{{ route('admin.system.updateSW') }}" method="POST" class="bg-white rounded-xl shadow p-6">
                @csrf
                <h2 class="text-2xl font-bold text-red-600 mb-3">📦 Actualizar Service Worker</h2>
                <p class="text-gray-600 mb-4">Recarga manualmente el archivo <code>sw.js</code> para forzar una nueva
                    versión de caché PWA.</p>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Actualizar
                    SW</button>
            </form>

            {{-- Comprobar estado del sistema --}}
            <form action="{{ route('admin.system.checkStatus') }}" method="POST" class="bg-white rounded-xl shadow p-6">
                @csrf
                <h2 class="text-2xl font-bold text-red-600 mb-3">🩺 Comprobar Estado del Sistema</h2>
                <p class="text-gray-600 mb-4">Verifica la conexión actual con la base de datos y el entorno de Laravel.</p>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Verificar
                    Estado</button>
            </form>
        </div>

        {{-- Información del entorno --}}
        <div class="mt-12 bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-red-600 mb-4">💻 Información del Entorno</h2>

            <div class="grid md:grid-cols-2 gap-4 text-gray-700 text-sm">
                <p><strong>Laravel:</strong> {{ app()->version() }}</p>
                <p><strong>PHP:</strong> {{ PHP_VERSION }}</p>
                <p><strong>APP_ENV:</strong> {{ env('APP_ENV') }}</p>
                <p><strong>APP_DEBUG:</strong> {{ env('APP_DEBUG') ? 'true' : 'false' }}</p>
                <p><strong>APP_URL:</strong> {{ env('APP_URL') }}</p>
                <p><strong>Servidor:</strong> {{ php_uname('s') }} ({{ php_uname('r') }})</p>
                <p><strong>Hora del servidor:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                <p><strong>Base de datos:</strong>
                    @php
                        try {
                            DB::connection()->getPdo();
                            echo '✅ Conectada';
                        } catch (Exception $e) {
                            echo '❌ Error de conexión';
                        }
                    @endphp
                </p>
            </div>
        </div>

        <div class="mt-10 text-sm text-gray-500">
            <p>🧠 <strong>Consejo:</strong> Usa este panel solo cuando debas solucionar problemas técnicos o mantenimiento
                general del sistema web.</p>
        </div>
    </div>
@endsection