// ChatConnect PWA Service Worker (enables Standalone App Installation on Samsung Tablet, Android, iOS & Desktop)
const CACHE_NAME = 'chatconnect-pwa-v1';
const PRECACHE_URLS = [
    '/manifest.json',
    '/icon.svg',
    '/icon-192.png',
    '/icon-512.png',
    '/apple-touch-icon.png'
];

self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(PRECACHE_URLS).catch(() => {}))
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});

