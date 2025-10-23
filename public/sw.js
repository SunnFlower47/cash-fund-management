const CACHE_NAME = 'cash-management-v1.1.0';
const STATIC_CACHE_NAME = 'cash-management-static-v1.1.0';

// Static assets to cache (images, CSS, JS)
const staticUrlsToCache = [
  '/css/app.css',
  '/js/app.js',
  '/manifest.json',
  // PWA Icons
  '/icons/icon-72x72.png',
  '/icons/icon-96x96.png',
  '/icons/icon-128x128.png',
  '/icons/icon-144x144.png',
  '/icons/icon-152x152.png',
  '/icons/icon-192x192.png',
  '/icons/icon-384x384.png',
  '/icons/icon-512x512.png',
  // App Icons - Navigation & UI
  '/money-transfer.png',
  '/money.png',
  '/calendar.png',
  '/searching.png',
  '/receipt.png',
  '/profile.png',
  '/seting.png',
  '/logout.png',
  '/user.png',
  '/history.png',
  '/book-history.png',
  '/flash-sale.png',
  '/filter.png'
];

// Dynamic pages that need fresh data
const dynamicPages = [
  '/dashboard',
  '/transactions',
  '/payment-proofs',
  '/settings',
  '/backup'
];

// Install event - cache only static resources
self.addEventListener('install', function(event) {
  console.log('Service Worker: Install event');
  event.waitUntil(
    caches.open(STATIC_CACHE_NAME)
      .then(function(cache) {
        console.log('Service Worker: Caching static files');
        return cache.addAll(staticUrlsToCache);
      })
      .catch(function(error) {
        console.log('Service Worker: Cache failed', error);
      })
  );
  self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
  console.log('Service Worker: Activate event');
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.map(function(cacheName) {
          if (cacheName !== STATIC_CACHE_NAME) {
            console.log('Service Worker: Deleting old cache', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch event - smart caching strategy
self.addEventListener('fetch', function(event) {
  // Skip non-GET requests
  if (event.request.method !== 'GET') {
    return;
  }

  // Skip external requests
  if (!event.request.url.startsWith(self.location.origin)) {
    return;
  }

  const url = new URL(event.request.url);
  const isDynamicPage = dynamicPages.some(page => url.pathname.startsWith(page));
  const isStaticAsset = staticUrlsToCache.some(asset => url.pathname.includes(asset));
  const isIconFile = url.pathname.endsWith('.png') && (url.pathname.includes('/money') ||
    url.pathname.includes('/profile') || url.pathname.includes('/calendar') ||
    url.pathname.includes('/searching') || url.pathname.includes('/receipt') ||
    url.pathname.includes('/seting') || url.pathname.includes('/logout') ||
    url.pathname.includes('/user') || url.pathname.includes('/history') ||
    url.pathname.includes('/book-history') || url.pathname.includes('/flash-sale') ||
    url.pathname.includes('/filter'));

  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // For dynamic pages (CRUD operations), always fetch fresh data
        if (isDynamicPage) {
          console.log('Service Worker: Dynamic page - fetching fresh data', event.request.url);
          return fetch(event.request)
            .then(function(networkResponse) {
              // Cache the response for offline use, but don't serve stale data
              if (networkResponse && networkResponse.status === 200) {
                const responseToCache = networkResponse.clone();
                caches.open(STATIC_CACHE_NAME)
                  .then(function(cache) {
                    cache.put(event.request, responseToCache);
                  });
              }
              return networkResponse;
            })
            .catch(function(error) {
              console.log('Service Worker: Network failed for dynamic page', error);
              // Fallback to cached version only if network fails
              if (response) {
                console.log('Service Worker: Serving cached version as fallback', event.request.url);
                return response;
              }
              // Return offline page for navigation requests
              if (event.request.mode === 'navigate') {
                return caches.match('/offline.html');
              }
              throw error;
            });
        }

        // For icon files, always serve from cache first (aggressive caching)
        if (isIconFile) {
          if (response) {
            console.log('Service Worker: Serving icon from cache', event.request.url);
            return response;
          }

          console.log('Service Worker: Fetching icon from network', event.request.url);
          return fetch(event.request).then(function(networkResponse) {
            if (networkResponse && networkResponse.status === 200) {
              const responseToCache = networkResponse.clone();
              caches.open(STATIC_CACHE_NAME)
                .then(function(cache) {
                  cache.put(event.request, responseToCache);
                });
            }
            return networkResponse;
          });
        }

        // For static assets, serve from cache first, then network
        if (isStaticAsset) {
          if (response) {
            console.log('Service Worker: Serving static asset from cache', event.request.url);
            return response;
          }

          console.log('Service Worker: Fetching static asset from network', event.request.url);
          return fetch(event.request).then(function(networkResponse) {
            if (networkResponse && networkResponse.status === 200) {
              const responseToCache = networkResponse.clone();
              caches.open(STATIC_CACHE_NAME)
                .then(function(cache) {
                  cache.put(event.request, responseToCache);
                });
            }
            return networkResponse;
          });
        }

        // For other requests, try network first, then cache
        return fetch(event.request)
          .then(function(networkResponse) {
            if (networkResponse && networkResponse.status === 200) {
              const responseToCache = networkResponse.clone();
              caches.open(STATIC_CACHE_NAME)
                .then(function(cache) {
                  cache.put(event.request, responseToCache);
                });
            }
            return networkResponse;
          })
          .catch(function(error) {
            console.log('Service Worker: Network failed, trying cache', error);
            if (response) {
              console.log('Service Worker: Serving from cache', event.request.url);
              return response;
            }
            // Return offline page for navigation requests
            if (event.request.mode === 'navigate') {
              return caches.match('/offline.html');
            }
            throw error;
          });
      })
  );
});

// Background sync for offline actions
self.addEventListener('sync', function(event) {
  if (event.tag === 'background-sync') {
    console.log('Service Worker: Background sync');
    event.waitUntil(doBackgroundSync());
  }
});

function doBackgroundSync() {
  // Handle offline actions when connection is restored
  return Promise.resolve();
}

// Push notifications (optional)
self.addEventListener('push', function(event) {
  if (event.data) {
    const data = event.data.json();
    const options = {
      body: data.body,
      icon: '/icons/icon-192x192.png',
      badge: '/icons/icon-72x72.png',
      vibrate: [100, 50, 100],
      data: {
        dateOfArrival: Date.now(),
        primaryKey: 1
      },
      actions: [
        {
          action: 'explore',
          title: 'Lihat',
          icon: '/icons/icon-96x96.png'
        },
        {
          action: 'close',
          title: 'Tutup',
          icon: '/icons/icon-96x96.png'
        }
      ]
    };

    event.waitUntil(
      self.registration.showNotification(data.title, options)
    );
  }
});

// Notification click handler
self.addEventListener('notificationclick', function(event) {
  event.notification.close();

  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/dashboard')
    );
  }
});
