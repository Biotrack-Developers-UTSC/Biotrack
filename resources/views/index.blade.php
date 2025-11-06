<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>BioTrack - Monitoreo Inteligente de Biodiversidad</title>

    <meta name="theme-color" content="#37936B" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Registro del Service Worker --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ asset('ServiceWorker.js') }}')
                    .then(reg => console.log('[SW] registrado en:', reg.scope))
                    .catch(err => console.error('[SW] error:', err));
            });
        }
    </script>
</head>

<body>
    {{-- HEADER --}}
    <header class="header">
        <div class="header-container">
            <h1>BioTrack</h1>
            <nav class="nav-links">
                <a href="{{ route('index') }}">Inicio</a>
                <a href="#impacto">Impacto</a>
                <a href="#soluciones">Soluciones</a>
                <a href="#acerca">Acerca</a>
                <a href="#contacto">Contacto</a>

                @auth
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
    {{-- 🌿 HERO PRINCIPAL --}}
    <section class="hero hero--visual" id="inicio">
        <div class="hero-visual-overlay"></div>
        <div class="hero-content">
            <h2 class="hero-title">Tecnología que Protege la Vida</h2>
            <p class="hero-subtitle">
                BioTrack conecta sensores IoT, inteligencia de datos y comunidades locales para monitorear ecosistemas
                en tiempo real. Detecta cambios ambientales, previene riesgos y promueve la conservación de la
                biodiversidad.
            </p>

            @auth
                <a href="{{ route('welcome') }}" class="hero-btn hero-btn--primary">Ir al Monitoreo</a>
            @else
                <a href="{{ route('login') }}" class="hero-btn hero-btn--primary">Iniciar Monitoreo</a>
                <a href="{{ route('register') }}" class="hero-btn hero-btn--secondary">Unirme a BioTrack</a>
            @endauth
        </div>
    </section>
    <main class="main-content">

        {{-- 🌍 INTRODUCCIÓN --}}
        <section class="intro-section text-center" id="impacto">
            <h2 class="section-title">Una Revolución en la Conservación</h2>
            <p class="intro-text">
                En BioTrack creemos que la tecnología puede ser una aliada poderosa para la naturaleza.
                Con sensores distribuidos en hábitats naturales, recopilamos datos de temperatura, movimiento, humedad y
                presencia animal,
                alertando en tiempo real sobre anomalías o amenazas.
                Nuestro objetivo: proteger especies, restaurar ecosistemas y fortalecer la ciencia ciudadana.
            </p>
        </section>

        {{-- 📊 ESTADÍSTICAS DESTACADAS --}}
        <div class="stats-grid-wrapper">
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-icon text-teal-600"><i class="fas fa-satellite-dish"></i></span>
                    <p class="stat-number">24/7</p>
                    <p class="stat-label">Monitoreo Activo</p>
                </div>
                <div class="stat-card">
                    <span class="stat-icon text-green-600"><i class="fas fa-leaf"></i></span>
                    <p class="stat-number">1200+ km²</p>
                    <p class="stat-label">Área Natural Protegida</p>
                </div>
                <div class="stat-card">
                    <span class="stat-icon text-yellow-600"><i class="fas fa-paw"></i></span>
                    <p class="stat-number">47</p>
                    <p class="stat-label">Especies Monitoreadas</p>
                </div>
                <div class="stat-card">
                    <span class="stat-icon text-red-600"><i class="fas fa-bell"></i></span>
                    <p class="stat-number">300+</p>
                    <p class="stat-label">Alertas Procesadas</p>
                </div>
            </div>
        </div>

        {{-- 💡 SOLUCIONES --}}
        <h2 class="section-title" id="soluciones">Nuestras Soluciones</h2>
        <div class="user-cards">
            <div class="user-card">
                <h3><i class="fas fa-flask mr-2"></i> Para Investigadores</h3>
                <ul>
                    <li>Análisis de datos IoT sobre comportamiento animal</li>
                    <li>Series temporales y tendencias ecológicas</li>
                    <li>Exportación de métricas y visualización avanzada</li>
                    <li>Conexión con bases científicas abiertas</li>
                </ul>
            </div>

            <div class="user-card">
                <h3><i class="fas fa-shield-alt mr-2"></i> Para Guardaparques</h3>
                <ul>
                    <li>Alertas inmediatas por riesgo ambiental o caza</li>
                    <li>Panel de vigilancia y gestión de rutas</li>
                    <li>Reportes automáticos por sensor IoT</li>
                    <li>Herramientas offline para zonas sin cobertura</li>
                </ul>
            </div>

            <div class="user-card">
                <h3><i class="fas fa-users mr-2"></i> Para Comunidades</h3>
                <ul>
                    <li>Participación en monitoreo colaborativo</li>
                    <li>Reportes de avistamientos o amenazas</li>
                    <li>Educación ambiental gamificada</li>
                    <li>Transparencia y datos abiertos</li>
                </ul>
            </div>
        </div>

        {{-- 💚 ACERCA DE NOSOTROS --}}
        <section class="about-section" id="acerca">
            <h2 class="section-title">Acerca de Nosotros</h2>
            <div class="about-grid">
                <div class="about-item">
                    <h3>Proyecto Integrador</h3>
                    <p>BioTrack surge como un proyecto académico interdisciplinario que une la ingeniería, la biología y
                        la educación digital
                        para construir una herramienta de monitoreo ambiental en tiempo real.</p>
                </div>
                <div class="about-item">
                    <h3>Misión</h3>
                    <p>Proporcionar una plataforma accesible y tecnológica que facilite el análisis, seguimiento y
                        protección de especies y ecosistemas naturales.</p>
                </div>
                <div class="about-item">
                    <h3>Visión</h3>
                    <p>Ser una referencia en conservación digital inteligente, combinando innovación, comunidad y datos
                        abiertos para proteger el planeta.</p>
                </div>
            </div>
        </section>
    </main>

    {{-- 📞 FOOTER --}}
    <footer class="footer" id="contacto">
        <p>© 2025 BioTrack | Tecnología para la Conservación</p>
        <p>Contacto: info@biotrack.org | Tel: +52 444 000 0000</p>
    </footer>

    <!-- 🔔 Notificación de estado de conexión -->
    <div id="connection-status" class="connection-banner hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const banner = document.getElementById('connection-status');

            function showStatus(isOnline) {
                banner.textContent = isOnline
                    ? '✅ Conexión restaurada — estás en línea'
                    : '⚠️ Estás sin conexión — modo offline activo';
                banner.className = `connection-banner ${isOnline ? 'online' : 'offline'}`;
                banner.classList.remove('hidden');

                // Oculta el banner después de unos segundos si vuelve el internet
                if (isOnline) {
                    setTimeout(() => banner.classList.add('hidden'), 4000);
                }
            }

            // Detectar cambios de conexión
            window.addEventListener('online', () => showStatus(true));
            window.addEventListener('offline', () => showStatus(false));

            // Estado inicial
            if (!navigator.onLine) showStatus(false);
        });
    </script>
</body>

</html>