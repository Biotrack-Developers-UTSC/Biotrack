const CACHE_NAME = 'biotrack-cache';

// Importante: La lista de URLs a cachear debe incluir todas las páginas principales 
// que componen el App Shell.
const urlsToCache = [
    '/',               // Home Page Pública
    '/login',          // Login Page
    '/register',       // Register Page
    '/home',           // Home Page POST-LOGIN

    // Assets Estáticos (Asegúrate de que estas rutas sean correctas en tu carpeta public)
    '/styles/styles.css',
    '/styles/authloginregister.css',
    '/styles/dashboard.css',
    '/manifest.json',
];

self.addEventListener('install', (event) => {
    console.log('[SW] Instalando y cacheando App Shell.');
    // Esperar hasta que se complete la apertura y el llenado de la caché
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Cacheando recursos estáticos.');
                return cache.addAll(urlsToCache);
            })
            .then(() => self.skipWaiting()) // Forzar la activación inmediata
            .catch((error) => {
                console.error('[SW] Fallo al cachear los recursos:', error);
            })
    );
});

self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Evitar cachear peticiones POST (registro, login) y API. 
    // Estas deben ir directamente a la red.
    const isAuthRequest = (url.pathname.startsWith('/login') || url.pathname.startsWith('/register')) && event.request.method === 'POST';
    const isApiRequest = url.pathname.startsWith('/api/');

    // Si es POST o API, ir directamente a la red
    if (isAuthRequest || isApiRequest || event.request.method !== 'GET') {
        event.respondWith(fetch(event.request));
        return;
    }

    // Estrategia Cache-First para recursos estáticos y App Shell
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Si el recurso está en caché, devolverlo
                if (response) {
                    return response;
                }

                // Si no está en caché, ir a la red
                return fetch(event.request);
            })
            .catch(() => {
                // Estrategia de fallback para páginas clave en modo offline
                if (url.pathname === '/login' || url.pathname === '/home') {
                    // Si falla el login o el home, mostramos la página de login cacheada.
                    return caches.match('/login');
                }
                if (url.pathname === '/') {
                    // Si falla la raíz, mostramos la página pública cacheada.
                    return caches.match('/');
                }
                // Para otros recursos, podría devolver una página genérica de offline si la tuvieras.
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
                    // Eliminar cachés que no están en la lista blanca (obsoletos)
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim()) // Tomar control de las páginas existentes
    );
});
