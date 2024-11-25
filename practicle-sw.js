const cacheVersion = "393113";
const cacheName = `Practicle-${cacheVersion}`;
const filesToCache = [];

self.addEventListener("install", function (event) {
  event.waitUntil(
    caches
      .open(cacheName)
      .then(function (cache) {
        return cache.addAll(filesToCache);
      })
      .then(() => {
        return self.skipWaiting();
      })
  );
});

self.addEventListener("activate", function (event) {
  event.waitUntil(
    caches
      .keys()
      .then(function (cacheNames) {
        return Promise.all(
          cacheNames
            .filter(function (existingCacheName) {
              return (
                existingCacheName.startsWith("Practicle-") &&
                existingCacheName !== cacheName
              );
            })
            .map(function (existingCacheName) {
              return caches.delete(existingCacheName);
            })
        );
      })
      .then(() => {
        return self.clients.claim();
      })
  );
});

self.addEventListener("fetch", function (event) {
  if (event.request.method === "GET") {
    const url = new URL(event.request.url);

    if (event.request.url.includes("/login.php")) {
      event.respondWith(
        fetch(event.request).catch(function () {
          notifyUser(
            event,
            "Network service is unavailable, serving from cache."
          );
          return caches.match("/login.php");
        })
      );
    } else if (url.pathname.includes("/getdata.php")) {
      // Always fetch fresh copy of dynamic data requests
      event.respondWith(fetch(event.request));
    } else if (url.pathname.includes(".php") && url.search) {
      event.respondWith(
        fetch(event.request).catch(function () {
          notifyUser(
            event,
            "Network service is unavailable, dynamic data might be outdated."
          );
          return caches.match("/");
        })
      );
    } else if (!url.pathname.includes(".php")) {
      event.respondWith(
        caches.match(event.request).then(function (response) {
          if (response) {
            return response;
          }
          return fetch(event.request)
            .then(function (networkResponse) {
              return caches.open(cacheName).then(function (cache) {
                cache.put(event.request, networkResponse.clone());
                return networkResponse;
              });
            })
            .catch(function () {
              notifyUser(
                event,
                "Network service is unavailable, serving from cache."
              );
              return caches.match("/");
            });
        })
      );
    } else {
      event.respondWith(fetch(event.request));
    }
  }
});

self.addEventListener("sync", function (event) {
  if (event.tag === "sync-post-requests") {
    event
      .waitUntil
      // Process queued POST requests here
      // This will typically involve reading from IndexedDB and retrying the requests
      ();
  }
});

function notifyUser(event, message) {
  self.clients.matchAll().then(function (clients) {
    clients.forEach(function (client) {
      console.log("[Service Worker] Sending message to client", client.id);
      client.postMessage({
        type: "NETWORK_STATUS",
        message: message,
        url: event.request.url
      });
    });
  });
}
