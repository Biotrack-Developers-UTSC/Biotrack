const CACHE_NAME = 'biotrack-cache';

// Importante: Las URLs de caché deben reflejar la NUEVA estructura de archivos.
const urlsToCache = [
    '/',                    // Home Page (ruta de Laravel)
    '/login',               // Login Page
    '/register',            // Register Page
    '/dashboard',           // Dashboard Page

    // Assets Estáticos: 
    '/styles/style.css',
    '/styles/login.css',
    '/styles/register.css',
    '/styles/dashboard.css',
    '/styles/style_auth.css',
    '/manifest.json',
];

self.addEventListener('install', (event) => {
    console.log('[SW] Instalando y cacheando App Shell.');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(urlsToCache))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Evitar cachear peticiones POST (registro, login) y API
    const isAuthRequest = (url.pathname.startsWith('/login') || url.pathname.startsWith('/register')) && event.request.method === 'POST';

    if (isAuthRequest || event.request.method !== 'GET') {
        event.respondWith(fetch(event.request));
        return;
    }

    // Estrategia Cache-First para recursos estáticos y App Shell
    event.respondWith(
        caches.match(event.request)
            .then((response) => response || fetch(event.request))
            .catch(() => {
                // Si falla, al menos muestra la Home Page cacheada
                if (url.pathname === '/login' || url.pathname === '/dashboard') return caches.match('/login');
                if (url.pathname === '/') return caches.match('/');
            })
    );
});

self.addEventListener('activate', (event) => {
    console.log('[SW] Activado. Limpiando cachés antiguos...');
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});