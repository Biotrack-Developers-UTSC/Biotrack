<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioTrack - Monitoreo de Biodiversidad en Tiempo Real</title>

    <meta name="theme-color" content="#37936B" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    {{-- Usamos el estilo base de la Home Page --}}
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @auth
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endauth

    {{-- Registro del Service Worker (Si lo usas) --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('serviceWorker.js') }}')
                    .then(reg => console.log('Service Worker registrado:', reg.scope))
                    .catch(err => console.error('Error al registrar SW:', err));
            });
        }
    </script>
</head>

<body>
    <header class="header">
        <div class="header-container">
            <h1>BioTrack</h1>
            <nav class="nav-links">
                <a href="{{ route('index') }}">Inicio</a>
                <a href="#soluciones">Soluciones</a>
                <a href="#acerca">Acerca de Nosotros</a>
                <a href="#contacto">Contacto</a>

                @auth
                    {{-- Usamos la ruta 'welcome' como el dashboard principal --}}
                    <a href="{{ route('welcome') }}" class="btn-dashboard"><i class="fas fa-desktop"></i> Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login"><i class="fas fa-sign-in-alt"></i> Entrar</a>
                    <a href="{{ route('register') }}" class="hero-btn--secondary">Registro</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- 🌟 HERO SECTION 🌟 --}}
    <section class="hero hero--visual" id="inicio">
        <div class="hero-visual-overlay"></div>
        <div class="hero-content">
            <h2 class="hero-title">Protegiendo el Pulso de la Vida Silvestre</h2>
            <p class="hero-subtitle">Una plataforma integral que combina tecnología IoT y datos en tiempo real para la
                conservación efectiva de especies en hábitats críticos.</p>

            @auth
                <a href="{{ route('welcome') }}" class="hero-btn hero-btn--primary">Ir al Monitoreo</a>
            @else
                <a href="{{ route('login') }}" class="hero-btn hero-btn--primary">Iniciar Monitoreo</a>
                <a href="{{ route('register') }}" class="hero-btn hero-btn--secondary">¡Únete y Colabora!</a>
            @endauth

        </div>
    </section>

    <main class="main-content">
        <h2 class="section-title" id="soluciones">El Impacto de BioTrack</h2>

        {{-- 🌟 SECCIÓN DE ESTADÍSTICAS 🌟 --}}
        <div class="stats-grid-wrapper">
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-icon text-teal-600"><i class="fas fa-satellite-dish"></i></span>
                    <p class="stat-number">24/7</p>
                    <p class="stat-label">Monitoreo en Tiempo Real</p>
                </div>
                <div class="stat-card">
                    <span class="stat-icon text-green-600"><i class="fas fa-tree"></i></span>
                    <p class="stat-number">1200+ km²</p>
                    <p class="stat-label">Área Protegida</p>
                </div>
                <div class="stat-card">
                    <span class="stat-icon text-yellow-600"><i class="fas fa-binoculars"></i></span>
                    <p class="stat-number">47 Especies</p>
                    <p class="stat-label">Bajo Seguimiento Activo</p>
                </div>
            </div>
        </div>

        {{-- Resto de las secciones (Nuestras Soluciones, Acerca de Nosotros) --}}
        <h2 class="section-title mt-12">Nuestras Soluciones</h2>

        {{-- 🌟 USER CARDS (Contenido Original) 🌟 --}}
        <div class="user-cards">
            <div class="user-card">
                <h3>Para Investigadores / Biólogos</h3>
                <ul>
                    <li>Panel de rastreo en tiempo real por especie y zona</li>
                    <li>Historial de movimiento, comportamiento y salud</li>
                    <li>Alertas por anomalías, migración o riesgo ambiental</li>
                    <li>Exportación de datos para análisis científico</li>
                </ul>
            </div>

            <div class="user-card">
                <h3>Para Guardaparques / Autoridades</h3>
                <ul>
                    <li>Visualización de fauna en áreas protegidas</li>
                    <li>Alertas por ingreso a zonas de riesgo o caza ilegal</li>
                    <li>Gestión de patrullajes y vigilancia</li>
                    <li>Reportes de conservación y cumplimiento legal</li>
                </ul>
            </div>

            <div class="user-card">
                <h3>Para Comunidades / Ciudadanos</h3>
                <ul>
                    <li>Información educativa sobre especies locales</li>
                    <li>Participación en monitoreo comunitario</li>
                    <li>Reporte de avistamientos o amenazas</li>
                    <li>Acceso a mapas y datos abiertos de biodiversidad</li>
                </ul>
            </div>
        </div>

        {{-- 🌟 ACERCA DE NOSOTROS (Contenido Detallado) 🌟 --}}
        <div class="about-section" id="acerca">
            <h2 class="section-title">Acerca de Nosotros</h2>
            <div class="about-grid">

                <div class="about-item">
                    <h3>Proyecto Integrador (Tópicos)</h3>
                    <p>BioTrack combina tecnologías IoT, Plataforma Web (Laravel) y Gamificación para una solución
                        completa de conservación digital.</p>
                    <ul>
                        <li><span style="font-weight: bold;">Tecnología IoT:</span> Recolección de datos de sensores de
                            campo.</li>
                        <li><span style="font-weight: bold;">Plataforma Web:</span> Desarrollada en PHP Laravel y MySQL.
                        </li>
                        <li><span style="font-weight: bold;">Gamificación:</span> Incluye un juego de fútbol y quiz
                            relacionado con la biodiversidad.</li>
                    </ul>
                </div>

                <div class="about-item">
                    <h3>Visión</h3>
                    <p>Convertirnos en una herramienta líder en conservación digital, integrando tecnología IoT para
                        proteger y monitorear especies silvestres en tiempo real.</p>
                </div>

                <div class="about-item">
                    <h3>Misión</h3>
                    <p>Facilitar el seguimiento, análisis y protección de la biodiversidad mediante una plataforma
                        accesible para investigadores, guardaparques y comunidades locales.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer" id="contacto">
        <p>© 2025 Plataforma de Seguimiento de Especies | Proyecto Académico</p>
        <p>Contacto: info@conservaciondigital.org | Tel: +123 456 7890</p>
    </footer>
</body>

</html>