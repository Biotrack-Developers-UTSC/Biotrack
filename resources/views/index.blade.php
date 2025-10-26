<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioTrack- Plataforma de Seguimiento de Especies</title>

    <meta name="theme-color" content="#9cd4c2" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">

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
        <h1>BioTrack</h1>
        <nav class="nav-links">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="#acerca">Acerca de Nosotros</a>
            <a href="#contacto">Contacto</a>
            <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
        </nav>
    </header>

    <section class="hero" id="inicio">
        <h2>Monitoreo Inteligente de Especies Silvestres</h2>
        <p>Una plataforma integral que utiliza tecnología IoT para el seguimiento en tiempo real de especies silvestres,
            facilitando la investigación, conservación y protección de la biodiversidad.</p>
    </section>

    <main class="main-content">
        <h2 class="section-title">Nuestras Soluciones</h2>

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

        <div class="about-section" id="acerca">
            <h2 class="section-title">Acerca de Nosotros</h2>
            <div class="about-grid">
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

                <div class="about-item">
                    <h3>Valores</h3>
                    <ul>
                        <li>Compromiso con la conservación ambiental</li>
                        <li>Colaboración entre ciencia y comunidad</li>
                        <li>Innovación tecnológica responsable</li>
                        <li>Transparencia y seguridad de datos</li>
                    </ul>
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