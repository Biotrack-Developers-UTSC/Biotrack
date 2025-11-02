{{-- resources/views/guardaparques/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Guardaparques | BioTrack')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-extrabold text-green-700 mb-8">Panel de Gestión de Biodiversidad</h1>

    <nav class="flex space-x-4 border-b pb-2 mb-6" id="dashboard-nav">
      <button onclick="showSection('dashboard-general', this)" class="nav-btn active-btn">Resumen General</button>
      <button onclick="showSection('gestion-animales', this)" class="nav-btn">Gestión de Especies</button>
      <button onclick="showSection('gestion-alertas', this)" class="nav-btn">Alertas IoT</button>
      <button onclick="showSection('reportes', this)" class="nav-btn">Reportes</button>
    </nav>

    <div class="space-y-8">
      {{-- Resumen General --}}
      <div id="dashboard-general" class="section-content">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Resumen del Área</h2>
        <p>Total Animales: {{ $totalAnimales }}</p>
        <p>Alertas Activas: {{ $alertasActivas }}</p>
        <p>Total Sensores: {{ $totalSensores }}</p>
      </div>

      {{-- Gestión de Animales --}}
      <div id="gestion-animales" class="section-content hidden">
        <h2 class="text-3xl font-bold text-green-600 mb-6">CRUD de Especies</h2>
        <a href="{{ route('animales.index') }}"
          class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors shadow-md inline-block">
          <i class="fas fa-table mr-2"></i> Ver Tabla de Especies
        </a>
      </div>

      {{-- Gestión de Alertas --}}
      <div id="gestion-alertas" class="section-content hidden">
        <h2 class="text-3xl font-bold text-red-600 mb-6">Gestión de Alertas (Sensores Arduino/IoT)</h2>
        @include('guardaparques.alertas.index', ['alertas' => $alertas])
      </div>

      {{-- Reportes --}}
      <div id="reportes" class="section-content hidden">
        <h2 class="text-3xl font-bold text-blue-600 mb-6">Generación de Reportes</h2>
        @include('partials.reports')
      </div>
    </div>
  </div>

  <script>
    function showSection(sectionName, clickedButton) {
      document.querySelectorAll('.section-content').forEach(section => section.classList.add('hidden'));
      document.getElementById(sectionName).classList.remove('hidden');
      document.querySelectorAll('#dashboard-nav .nav-btn').forEach(btn => btn.classList.remove('active-btn'));
      clickedButton.classList.add('active-btn');
    }
  </script>
@endsection