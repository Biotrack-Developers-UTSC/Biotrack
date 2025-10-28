@extends('layouts.app')
@section('title', 'Gestión de Guardaparques | BioTrack')

@section('content')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-extrabold text-green-700 mb-8">
      Panel de Gestión de Biodiversidad
    </h1>

    {{-- MENÚ DE NAVEGACIÓN DENTRO DEL DASHBOARD --}}
    <nav class="flex space-x-4 border-b pb-2 mb-6" id="dashboard-nav">
      <button onclick="showSection('dashboard-general', this)" class="nav-btn active-btn">
        Resumen General
      </button>
      <button onclick="showSection('gestion-animales', this)" class="nav-btn">
        Gestión de Especies
      </button>
      <button onclick="showSection('gestion-alertas', this)" class="nav-btn">
        Alertas IoT
      </button>
      <button onclick="showSection('reportes', this)" class="nav-btn">
        Reportes
      </button>
    </nav>

    <div class="space-y-8">

      {{-- SECCIÓN 1: RESUMEN GENERAL (Estadísticas) --}}
      <div id="dashboard-general" class="section-content">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Resumen del Área</h2>
        @include('partials.dashboard_stats') {{-- Contadores: Animales registrados, Alertas activas, Sensores, etc. --}}
      </div>

      {{-- SECCIÓN 2: GESTIÓN DE ANIMALES (CRUD) --}}
      <div id="gestion-animales" class="section-content hidden">
        <h2 class="text-3xl font-bold text-green-600 mb-6">CRUD de Especies</h2>
        {{-- Incluye la tabla con botones de Editar/Eliminar --}}
        @include('guardaparque.animales.crud_index')
      </div>

      {{-- SECCIÓN 3: GESTIÓN DE ALERTAS IoT --}}
      <div id="gestion-alertas" class="section-content hidden">
        <h2 class="text-3xl font-bold text-red-600 mb-6">Gestión de Alertas (Sensores Arduino/IoT)</h2>
        {{-- Aquí va el contenido del CRUD de Alertas (AlertaController) --}}
        @include('guardaparque.alertas.crud_index')
      </div>

      {{-- SECCIÓN 4: REPORTES --}}
      <div id="reportes" class="section-content hidden">
        <h2 class="text-3xl font-bold text-blue-600 mb-6">Generación de Reportes</h2>
        @include('partials.reports')
      </div>
    </div>


  </div>

  <script>
    // JS para controlar la navegación interna (showSection)
    document.addEventListener('DOMContentLoaded', () => {
      // Asegurar que solo la primera sección esté activa al inicio
      document.querySelectorAll('.section-content').forEach((section, index) => {
        section.classList.toggle('hidden', index !== 0);
      });
      document.querySelector('#dashboard-nav .nav-btn:first-child').classList.add('active-btn');
    });

    function showSection(sectionName, clickedButton) {
      // Ocultar todas las secciones
      document.querySelectorAll(&#39;.section - content &#39;).forEach(section =& gt; {
        section.classList.add(&#39; hidden &#39;);
      });

      // Mostrar la sección requerida
      document.getElementById(sectionName).classList.remove(&#39; hidden &#39;);

      // Manejar el estado activo del botón
      document.querySelectorAll(&#39; #dashboard - nav.nav - btn &#39;).forEach(btn =& gt; {
        btn.classList.remove(&#39; active - btn &#39;);
      });
      clickedButton.classList.add(&#39; active - btn &#39;);
    }


  </script>

  <style>
    .nav-btn {
      padding: 8px 16px;
      border-radius: 6px;
      transition: all 0.2s;
      cursor: pointer;
      color: #4B5563;
      /* Gris /
  font-weight: 500;
  }
  .nav-btn:hover {
  background-color: #F3F4F6; / Gris claro al pasar el ratón /
  }
  .active-btn {
  color: #10B981; / Verde */
      border-bottom: 2px solid #10B981;
      font-weight: 700;
      background-color: #ECFDF5;
    }
  </style>

@endsection