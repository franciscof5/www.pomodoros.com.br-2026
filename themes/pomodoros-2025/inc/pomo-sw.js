/* Pomodoros Service Worker - Web Push (VAPID).
 * Served at /sw.js (scope /) so push works with the screen off and even when
 * the browser/app is closed.
 */

self.addEventListener('install', function (event) {
	self.skipWaiting();
});

self.addEventListener('activate', function (event) {
	event.waitUntil(self.clients.claim());
});

self.addEventListener('push', function (event) {
	var payload = {};
	try {
		payload = event.data ? event.data.json() : {};
	} catch (e) {
		payload = { body: event.data ? event.data.text() : '' };
	}

	var title = payload.title || 'Pomodoros';
	var options = {
		body: payload.body || '',
		icon: payload.icon || '/wp-content/themes/pomodoros-2025/pomodoros-favicon.png',
		badge: payload.badge || '/wp-content/themes/pomodoros-2025/pomodoros-favicon.png',
		tag: payload.tag || 'pomodoro',
		renotify: true,
		data: {
			url: (payload.data && payload.data.url) || payload.url || '/focus/'
		}
	};

	event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
	event.notification.close();
	var target = (event.notification.data && event.notification.data.url) || '/focus/';
	event.waitUntil(
		self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
			for (var i = 0; i < clientList.length; i++) {
				var client = clientList[i];
				if (client.url.indexOf(target) !== -1 && 'focus' in client) {
					return client.focus();
				}
			}
			if (self.clients.openWindow) {
				return self.clients.openWindow(target);
			}
		})
	);
});
