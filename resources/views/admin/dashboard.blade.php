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
        {{-- Aquí va el contenido del CRUD de Usuarios (UserController) --}}
        @include('admin.users.crud_index')
      </div>

      {{-- SECCIÓN 3: GESTIÓN DE ANIMALES (CRUD HEREDADO) --}}
      <div id="gestion-animales" class="section-content hidden">
        <h2 class="text-3xl font-bold text-green-600 mb-6">CRUD de Especies (Guardaparques View)</h2>
        @include('guardaparque.animales.crud_index')
      </div>

      {{-- SECCIÓN 4: GESTIÓN DE ALERTAS IoT (HEREDADO) --}}
      <div id="gestion-alertas" class="section-content hidden">
        <h2 class="text-3xl font-bold text-yellow-600 mb-6">Gestión de Alertas (Sensores Arduino/IoT)</h2>
        @include('guardaparque.alertas.crud_index')
      </div>

      {{-- SECCIÓN 5: CONFIGURACIÓN AVANZADA --}}
      <div id="configuracion" class="section-content hidden">
        <h2 class="text-3xl font-bold text-blue-600 mb-6">Configuración del Sistema</h2>
        <div class="p-6 bg-yellow-50 rounded-lg border border-yellow-200">
          <p class="text-yellow-800">Herramientas para administración de logs, caché y reportes avanzados.</p>
        </div>
        @include('partials.admin_config_tools')
      </div>
    </div>


  </div>

  <script>
    // JS para controlar la navegación interna del DASHBOARD ADMIN
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.section-content').forEach((section, index) => {
        section.classList.toggle('hidden', index !== 0);
      });
      document.querySelector('#dashboard-nav-admin .nav-btn:first-child').classList.add('active-btn');
    });

    function showAdminSection(sectionName, clickedButton) {
      document.querySelectorAll(&#39;.section - content &#39;).forEach(section =& gt; {
        section.classList.add(&#39; hidden &#39;);
      });
      document.getElementById(sectionName).classList.remove(&#39; hidden &#39;);

      document.querySelectorAll(&#39; #dashboard - nav - admin.nav - btn &#39;).forEach(btn =& gt; {
        btn.classList.remove(&#39; active - btn &#39;);
      });
      clickedButton.classList.add(&#39; active - btn &#39;);
    }


  </script>

  <style>
    /* Estilos compartidos con Guardaparques, solo se repiten aquí por si no usas un archivo CSS externo /
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
  color: #DC2626; / Rojo para Admin */
    border-bottom: 2px solid #DC2626;
    font-weight: 700;
    background-color: #FEF2F2;
    }
  </style>

@endsection