const CACHE_NAME = 'biotrack-app-shell-v2';

const urlsToCache = [
    '/',                      // Página principal
    '/welcome',               // Dashboard
    '/consultas/usuarios',    // Consulta de usuarios
    '/guardaparques/alertas', // Consulta de alertas
    '/animales',              // CRUD/consulta de especies
    '/offline.html',          // Página de respaldo offline

    // Estilos y recursos
    '/styles/styles.css',
    '/manifest.json',
    '/images/logo-192.png',
    '/images/logo-512.png',
];

// Instalación del Service Worker y cacheo del App Shell
self.addEventListener('install', (event) => {
    console.log('[SW] Instalando y cacheando App Shell...');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
            .then(() => self.skipWaiting())
    );
});

// Activación y limpieza de cachés antiguos
self.addEventListener('activate', (event) => {
    console.log('[SW] Activado. Limpiando versiones anteriores...');
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Intercepción de solicitudes
self.addEventListener('fetch', (event) => {
    const req = event.request;
    const url = new URL(req.url);

    // Evita cachear peticiones POST o rutas de autenticación
    const isAuthPage = url.pathname.startsWith('/login') || url.pathname.startsWith('/register');
    const isApi = url.pathname.startsWith('/api/');
    const isPost = req.method !== 'GET';

    if (isAuthPage || isApi || isPost) {
        event.respondWith(fetch(req));
        return;
    }

    // Estrategia Cache-First con fallback a red y luego a offline
    event.respondWith(
        caches.match(req)
            .then(res => res || fetch(req))
            .catch(() => caches.match('/offline.html'))
    );
});
