<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BioTrack - Seguimiento de Especies Silvestres</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <meta name="theme-color" content="#9cd4c2" />
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="stylesheet" href="{{ asset('styles/dashboard.css') }}">

  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('{{ asset('ServiceWorker.js') }}')
          .then(reg => console.log('Service Worker registrado:', reg.scope));
      });
    }
  </script>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
  <header class="bg-white shadow-lg border-b-4 border-green-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center space-x-3">
          <h1 class="text-2xl font-bold text-gray-800">BioTrack</h1>
        </div>
        <nav class="hidden md:flex space-x-6">
          <button onclick="showSection('dashboard', this)"
            class="nav-btn text-green-600 font-semibold border-b-2 border-green-600">Dashboard</button>
          <button onclick="showSection('registro', this)"
            class="nav-btn text-gray-600 hover:text-green-600">Registro</button>
          <button onclick="showSection('sensores', this)" class="nav-btn text-gray-600 hover:text-green-600">Sensores
            IoT</button>
          <button onclick="showSection('reportes', this)"
            class="nav-btn text-gray-600 hover:text-green-600">Reportes</button>
        </nav>
        <div class="flex items-center space-x-4">
          <div class="flex items-center space-x-4">
            <span class="text-gray-800 font-medium" id="usuario">
              Hola, {{ Auth::user()->nombre ?? 'Guardaparque' }} 👋
            </span>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="px-4 py-2 bg-white text-gray-800 rounded-lg hover:bg-gray-100 transition-colors border border-gray-300">
                Cerrar Sesión
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <script>
    // Variables globales
    let especiesRegistradas = [];
    let deteccionesRecientes = [];

    // Navegación entre secciones (adaptada para recibir el botón como argumento)
    function showSection(sectionName, clickedButton) {
      document.querySelectorAll('.section').forEach(section => {
        section.classList.add('hidden');
      });

      document.getElementById(sectionName).classList.remove('hidden');

      document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.classList.remove('text-green-600', 'font-semibold', 'border-b-2', 'border-green-600');
        btn.classList.add('text-gray-600');
      });

      clickedButton.classList.remove('text-gray-600');
      clickedButton.classList.add('text-green-600', 'font-semibold', 'border-b-2', 'border-green-600');
    }

    // ... (El resto del código JavaScript para simulación, formularios y modales se mantiene aquí) ...

    // Llama a showSection() al cargar para que inicie en Dashboard
    document.addEventListener('DOMContentLoaded', function () {
      // ... (simulaciones, inicialización, etc.)

      // Función showSection para la inicialización
      const initialBtn = document.querySelector('.nav-links button.nav-btn');
      if (initialBtn) showSection('dashboard', initialBtn);

      // Iniciar simulación de datos en tiempo real
      simularDeteccionesRealTime();

      // Simular cambios en contadores
      setInterval(() => {
        const sensoresCount = document.getElementById('sensores-count');
        const alertasCount = document.getElementById('alertas-count');

        if (Math.random() > 0.7) {
          let currentSensores = parseInt(sensoresCount.textContent);
          sensoresCount.textContent = Math.max(20, currentSensores + (Math.random() > 0.5 ? 1 : -1));
        }

        if (Math.random() > 0.8) {
          let currentAlertas = parseInt(alertasCount.textContent);
          alertasCount.textContent = Math.max(0, currentAlertas + (Math.random() > 0.6 ? 1 : -1));
        }
      }, 10000);
    });

    // (Se mantiene la función showAnimalInfo, cerrarModal, simularDeteccionesRealTime, generarReporte, exportarDatos, generarInforme, programarReporte, actualizarContadores)
    // ... (resto del JS que no fue modificado)

    // Simulación de datos en tiempo real
    function simularDeteccionesRealTime() {
      // ... (código JavaScript original) ...
    }

    // Registro de especies
    document.getElementById('registro-form').addEventListener('submit', function (e) {
      e.preventDefault();
      // Esta es la lógica de frontend que debería comunicarse con una API de Laravel (ej. /api/especie)
      // Por ahora, solo simula el registro.
      // ... (código JavaScript original) ...
      alert('¡Especie registrada exitosamente! 🎉');
      limpiarFormulario();
      actualizarContadores();
    });

    // ... (funciones showAnimalInfo, limpiarFormulario, cerrarModal, etc.) ...
  </script>
</body>

</html>