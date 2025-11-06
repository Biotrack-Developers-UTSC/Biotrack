<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>@yield('title', 'BioTrack')</title>

  {{-- 🎨 Variables dinámicas de configuración --}}
  <style>
    :root {
      --primary-color:
        {{ $config['primary_color'] ?? '#37936B' }}
      ;
      --secondary-color:
        {{ $config['secondary_color'] ?? '#2f4f3e' }}
      ;
      --text-color:
        {{ $config['text_color'] ?? '#ffffff' }}
      ;
      --accent-color:
        {{ $config['accent_color'] ?? '#FFD700' }}
      ;
      --hero-bg: url('{{ $config['hero_bg'] ?? asset('images/default-hero.jpg') }}');
    }
  </style>

  {{-- ✅ Estilos globales --}}
  <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="icon" href="{{ asset('images/logo-192.png') }}" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  {{-- ✅ Registro del Service Worker --}}
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('{{ asset('serviceWorker.js') }}')
          .then(reg => console.log('[SW] Activo en:', reg.scope))
          .catch(err => console.error('[SW] Error:', err));
      });
    }
  </script>

  {{-- Estilos específicos por vista --}}
  @yield('styles')
</head>

<body>
  <div class="app">

    {{-- HEADER --}}
    <header>
      <div class="container header-content">
        <div>
          <strong>BioTrack</strong>
          <span class="badge">v0.1</span>
        </div>

        <nav>
          <a href="{{ route('index') }}">Inicio</a>

          @auth
            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('alertas.index') }}"
              class="{{ request()->routeIs('alertas.*') ? 'active' : '' }}">Alertas</a>
            <a href="{{ route('admin.config') }}"
              class="{{ request()->routeIs('admin.config') ? 'active' : '' }}">Configuración</a>
            <a href="{{ route('juegos.futbol') }}"
              class="{{ request()->routeIs('juegos.futbol') ? 'active' : '' }}">Juego</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
              @csrf
              <button style="background:none;border:0;color:#fca5a5;cursor:pointer">Salir</button>
            </form>
          @else
            <a href="{{ route('login') }}">Entrar</a>
            <a href="{{ route('register') }}">Registro</a>
          @endauth
        </nav>
      </div>
    </header>

    {{-- MAIN --}}
    <main>
      <div class="container">
        @yield('content')
      </div>
    </main>

    {{-- FOOTER --}}
    <footer>
      <div class="container">
        © BioTrack {{ date('Y') }} — Monitoreo de Biodiversidad
      </div>
    </footer>
  </div>
</body>

</html>