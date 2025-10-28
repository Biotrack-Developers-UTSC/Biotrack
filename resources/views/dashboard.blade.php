@extends('layouts.app')
@section('title', 'Consulta de Especies')

@section('content')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-6 border-b pb-2">
      Catálogo de Especies Silvestres 🌿
    </h1>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-8">
      <h2 class="text-2xl font-semibold text-green-700 mb-4">Buscar y Consultar</h2>
      <p class="text-gray-600 mb-4">
        Explora la fauna registrada en el sistema. Puedes filtrar por nombre, tipo de hábitat o escanear un código QR.
      </p>

      {{-- Formulario de Búsqueda y Filtros (Se asume que ConsultaController maneja esto) --}}
      <div class="flex flex-wrap gap-4 items-center">
        <input type="text" placeholder="Buscar por nombre común..."
          class="flex-grow p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">

        <a href="#"
          class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition duration-150 shadow-md">
          <i class="fas fa-search"></i> Buscar
        </a>

        {{-- Botón de Escaneo QR (para escanear QRs de animales) --}}
        <a href="{{ route('qr.scan') }}"
          class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-150 shadow-md">
          <i class="fas fa-qrcode"></i> Escanear QR
        </a>
      </div>
    </div>

    {{-- Aquí se incluyen los resultados o la tabla de solo lectura --}}
    <div class="mt-8">
      @include('consultas.animales_list') {{-- Ejemplo: una tabla de solo lectura --}}
    </div>


  </div>
@endsection