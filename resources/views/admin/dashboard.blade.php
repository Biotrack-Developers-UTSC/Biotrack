@extends('layouts.app')
@section('title', 'Panel de Administración Global | BioTrack')

@section('content')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-extrabold text-red-700 mb-8">
      Panel de Control Global (ADMIN) 🛠️
    </h1>

    {{-- MENÚ DE NAVEGACIÓN DENTRO DEL DASHBOARD --}}
    <nav class="flex space-x-4 border-b pb-2 mb-6" id="dashboard-nav-admin">
      <button onclick="showAdminSection('dashboard-general', this)" class="nav-btn active-btn">
        Resumen General
      </button>
      {{-- SECCIÓN EXCLUSIVA DE ADMIN --}}
      <button onclick="showAdminSection('gestion-usuarios', this)" class="nav-btn">
        Gestión de Usuarios
      </button>
      {{-- SECCIONES HEREDADAS DE GUARDAPARQUES --}}
      <button onclick="showAdminSection('gestion-animales', this)" class="nav-btn">
        Gestión de Especies
      </button>
      <button onclick="showAdminSection('gestion-alertas', this)" class="nav-btn">
        Alertas IoT
      </button>
      <button onclick="showAdminSection('configuracion', this)" class="nav-btn">
        Configuración
      </button>
    </nav>

    <div class="space-y-8">

      {{-- SECCIÓN 1: RESUMEN GENERAL --}}
      <div id="dashboard-general" class="section-content">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Resumen del Sistema</h2>
        @include('partials.dashboard_stats')
      </div>

      {{-- 🌟 SECCIÓN 2: GESTIÓN DE USUARIOS (CRUD de Admins/Guardaparques) --}}
      <div id="gestion-usuarios" class="section-content hidden">
        <h2 class="text-3xl font-bold text-red-600 mb-6">CRUD de Roles y Usuarios</h2>

        {{-- ENLACE PRINCIPAL: Lleva a la tabla real del CRUD --}}
        <a href="{{ route('administracion.usuarios.index') }}"
          class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors shadow-md inline-block">
          <i class="fas fa-table mr-2"></i> Ver Tabla de Usuarios (Completa)
        </a>

        {{-- CORRECCIÓN A LA LÍNEA 56 (Reemplazado por contenido estático o resumen) --}}
        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
          <p class="text-gray-700">Haz clic en el botón de arriba para acceder al panel de gestión de usuarios. Aquí solo
            se muestra el enlace directo para evitar errores de carga de datos.</p>
        </div>
        {{-- Fin de la corrección --}}

      </div>

      {{-- SECCIÓN 3: GESTIÓN DE ANIMALES (CRUD HEREDADO) --}}
      <div id="gestion-animales" class="section-content hidden">
        <h2 class="text-3xl font-bold text-green-600 mb-6">CRUD de Especies</h2>
        {{-- ENLACE AL CONTROLADOR DE ANIMALES --}}
        <a href="{{ route('animales.index') }}"
          class="px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors shadow-md inline-block">
          <i class="fas fa-table mr-2"></i> Ver Tabla de Especies
        </a>
        @include('consultas.index')
      </div>

      {{-- SECCIÓN 4: GESTIÓN DE ALERTAS IoT (HEREDADO) --}}
      <div id="gestion-alertas" class="section-content hidden">
        <h2 class="text-3xl font-bold text-yellow-600 mb-6">Gestión de Alertas</h2>
        {{-- ENLACE AL CONTROLADOR DE ALERTAS --}}
        <a href="{{ route('alertas.index') }}"
          class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition-colors shadow-md inline-block">
          <i class="fas fa-exclamation-triangle mr-2"></i> Ver Tabla de Alertas
        </a>
        @include('guardaparque.alertas.index')
      </div>

      {{-- SECCIÓN 5: CONFIGURACIÓN AVANZADA --}}
      <div id="configuracion" class="section-content hidden">
        <h2 class="text-3xl font-bold text-blue-600 mb-6">Configuración del Sistema</h2>
        <a href="{{ route('admin.config') }}"
          class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors shadow-md inline-block">
          <i class="fas fa-cogs mr-2"></i> Ir a Configuración
        </a>
        @include('partials.admin_config_tools')
      </div>
    </div>


  </div>

  <script>
    // Implementación corregida de showAdminSection
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.section-content').forEach((section, index) => {
        section.classList.toggle('hidden', index !== 0);
      });
      // Inicializar el primer botón activo
      document.querySelector('#dashboard-nav-admin .nav-btn:first-child').classList.add('active-btn');
    });

    function showAdminSection(sectionName, clickedButton) {
      // Ocultar todas las secciones de contenido
      document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
      });
      document.getElementById(sectionName).classList.remove('hidden');

      // Remover clase activa de todos los botones
      document.querySelectorAll('#dashboard-nav-admin .nav-btn').forEach(btn => {
        btn.classList.remove('active-btn', 'text-red-600', 'font-semibold', 'border-b-2', 'border-red-600');
        btn.classList.add('text-gray-600', 'hover:text-red-600');
      });

      // Aplicar clase activa al botón clicado
      clickedButton.classList.remove('text-gray-600', 'hover:text-red-600');
      clickedButton.classList.add('active-btn', 'text-red-600', 'font-semibold', 'border-b-2', 'border-red-600');
    }
  </script>

  <style>
    /* Estilos de navegación de pestañas específicos para Admin (Rojo) */
    .nav-btn {
      padding: 8px 16px;
      border-radius: 6px;
      transition: all 0.2s;
      cursor: pointer;
      color: #4B5563;
      font-weight: 500;
    }

    .nav-btn:hover {
      background-color: #F3F4F6;
    }

    .active-btn {
      color: #DC2626;
      /* Rojo para Admin */
      border-bottom: 2px solid #DC2626;
      font-weight: 700;
      background-color: #FEF2F2;
    }
  </style>

@endsection