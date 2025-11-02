@extends('layouts.app')

@section('title', 'Configuración IoT - BioTrack')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-red-600 mb-6">💡 Configuración IoT / Arduino</h1>
        <p class="mb-4 text-gray-700">Aquí puedes administrar dispositivos IoT, configuraciones de sensores y
            automatizaciones con Python.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="font-semibold text-xl mb-2">Sensores Activos</h2>
                <p class="text-gray-600">Lista de sensores conectados actualmente.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="font-semibold text-xl mb-2">Alertas IoT</h2>
                <p class="text-gray-600">Configura alertas automáticas según la lectura de sensores.</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="font-semibold text-xl mb-2">Scripts Python</h2>
                <p class="text-gray-600">Sube y ejecuta scripts de automatización para tus dispositivos IoT.</p>
            </div>
        </div>
    </div>
@endsection