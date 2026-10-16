(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	function each(list, fn) {
		Array.prototype.forEach.call(list, fn);
	}

	function toast(message, kind) {
		if (!window.alertify) return;
		if (kind === 'suc') {
			alertify.success(message);
		} else if (kind === 'er') {
			alertify.error(message);
		} else {
			alertify.log(message);
		}
	}

	ready(function () {
		var body = document.body;

		var toggle = document.querySelector('.pomo-appbar__toggle');
		if (toggle) {
			toggle.addEventListener('click', function () {
				body.classList.toggle('pomo-nav-open');
			});
		}

		var backdrop = document.createElement('div');
		backdrop.className = 'pomo-settings-backdrop';
		body.appendChild(backdrop);

		function setSettings(open) {
			body.classList.toggle('pomo-settings-open', !!open);
		}

		each(document.querySelectorAll('.js-pomo-settings'), function (el) {
			el.addEventListener('click', function (event) {
				event.preventDefault();
				setSettings(!body.classList.contains('pomo-settings-open'));
			});
		});
		backdrop.addEventListener('click', function () {
			setSettings(false);
		});
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') setSettings(false);
		});

		each(document.querySelectorAll('.abrir_login'), function (el) {
			el.addEventListener('click', function (event) {
				event.preventDefault();
				var box = document.getElementById('loginlogbox');
				if (box) box.style.display = (box.style.display === 'none' ? 'block' : 'none');
			});
		});

		var clockButton = document.getElementById('relogio');
		if (clockButton) {
			clockButton.addEventListener('keydown', function (event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					clockButton.click();
				}
			});
		}

		var tabs = document.querySelectorAll('[data-pomo-tab]');
		each(tabs, function (tab) {
			tab.addEventListener('click', function () {
				var target = tab.getAttribute('data-pomo-tab');
				each(tabs, function (other) {
					var active = other === tab;
					other.classList.toggle('is-active', active);
					other.setAttribute('aria-selected', active ? 'true' : 'false');
				});
				each(document.querySelectorAll('.pomo-panel'), function (panel) {
					panel.classList.toggle('is-active', panel.id === target);
				});
			});
		});

		// Make the whole option row clickable for the radio pills.
		each(document.querySelectorAll('#pomopainel ul li'), function (li) {
			var radio = li.querySelector('input[type="radio"]');
			if (!radio) return;
			li.addEventListener('click', function (event) {
				if (event.target === radio) return;
				radio.checked = true;
				radio.dispatchEvent(new Event('change', { bubbles: true }));
			});
		});

		/* -------------------------------------------------------------- */
		/* Preferences: volume / sound / voice                            */
		/* -------------------------------------------------------------- */
		// The focus screen persists these through the timer engine
		// (update_session). On every other app page the engine is absent, so
		// we save them here through the dedicated save_user_settings action.
		var hasEngine = !!document.getElementById('title_box');
		if (!hasEngine) {
			var ajaxUrl = window.ajaxurl || (window.location.origin + '/wp-admin/admin-ajax.php');
			var saveTimer = null;

			function collectSettings() {
				var payload = { action: 'save_user_settings' };
				var volume = document.getElementById('rangeVolume');
				var sound = document.getElementById('soundfx_enabled');
				var voice = document.getElementById('voice_enabled');
				if (volume) payload.range_volume = volume.value;
				if (sound) payload.soundfx_enabled = sound.checked ? 'true' : 'false';
				if (voice) payload.voice_enabled = voice.checked ? 'true' : 'false';
				return payload;
			}

			function saveSettings() {
				var payload = collectSettings();
				if (window.jQuery) {
					window.jQuery.post(ajaxUrl, payload);
					return;
				}
				var xhr = new XMLHttpRequest();
				xhr.open('POST', ajaxUrl, true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.send(Object.keys(payload).map(function (key) {
					return encodeURIComponent(key) + '=' + encodeURIComponent(payload[key]);
				}).join('&'));
			}

			function scheduleSave() {
				if (saveTimer) window.clearTimeout(saveTimer);
				saveTimer = window.setTimeout(saveSettings, 350);
			}

			each(document.querySelectorAll('#rangeVolume, #soundfx_enabled, #voice_enabled'), function (el) {
				el.addEventListener('change', scheduleSave);
				if (el.id === 'rangeVolume') el.addEventListener('input', scheduleSave);
			});
		}

		/* -------------------------------------------------------------- */
		/* Notifications (Web Push / VAPID + Service Worker)              */
		/* Delivered by the system push service: works with the screen    */
		/* off and even when the browser/app is closed.                   */
		/* -------------------------------------------------------------- */
		var userIdBox = document.getElementById('pomo-user-id');
		var userId = userIdBox ? userIdBox.value : '';
		var notifyButton = document.querySelector('.js-pomo-notify');
		var notifyLabel = notifyButton ? notifyButton.querySelector('.js-pomo-notify-label') : null;
		var pushCfg = window.pomoPush || {};

		function setNotifyState(on) {
			if (!notifyButton) return;
			notifyButton.classList.toggle('is-on', !!on);
			if (notifyLabel) notifyLabel.textContent = on ? 'Notificações ativas' : 'Ativar notificações';
		}

		function urlBase64ToUint8Array(base64String) {
			var padding = '='.repeat((4 - (base64String.length % 4)) % 4);
			var base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
			var raw = window.atob(base64);
			var out = new Uint8Array(raw.length);
			for (var i = 0; i < raw.length; ++i) out[i] = raw.charCodeAt(i);
			return out;
		}

		function pushSupported() {
			return ('serviceWorker' in navigator) && ('PushManager' in window) && ('Notification' in window);
		}

		function getRegistration() {
			return navigator.serviceWorker.register(pushCfg.sw || '/sw.js', { scope: '/' })
				.then(function () { return navigator.serviceWorker.ready; });
		}

		function saveSubscription(sub) {
			if (!window.jQuery || !pushCfg.ajax) return;
			window.jQuery.post(pushCfg.ajax, {
				action: 'save_push_subscription',
				subscription: JSON.stringify(sub)
			});
		}

		function removeSubscription(endpoint) {
			if (!window.jQuery || !pushCfg.ajax) return;
			window.jQuery.post(pushCfg.ajax, {
				action: 'remove_push_subscription',
				endpoint: endpoint
			});
		}

		function subscribePush() {
			return getRegistration().then(function (reg) {
				return reg.pushManager.getSubscription().then(function (existing) {
					if (existing) {
						saveSubscription(existing);
						setNotifyState(true);
						return existing;
					}
					return reg.pushManager.subscribe({
						userVisibleOnly: true,
						applicationServerKey: urlBase64ToUint8Array(pushCfg.vapid)
					}).then(function (sub) {
						saveSubscription(sub);
						setNotifyState(true);
						return sub;
					});
				});
			});
		}

		function unsubscribePush() {
			return getRegistration().then(function (reg) {
				return reg.pushManager.getSubscription().then(function (sub) {
					if (!sub) {
						setNotifyState(false);
						return null;
					}
					var endpoint = sub.endpoint;
					return sub.unsubscribe().then(function () {
						removeSubscription(endpoint);
						setNotifyState(false);
						return null;
					});
				});
			});
		}

		function requestPermission(callback) {
			if (!('Notification' in window)) {
				callback('denied');
				return;
			}
			try {
				var result = Notification.requestPermission(callback);
				if (result && typeof result.then === 'function') {
					result.then(callback);
				}
			} catch (e) {
				callback('default');
			}
		}

		function refreshNotifyState() {
			if (!notifyButton) return;
			if (!pushSupported() || Notification.permission !== 'granted') {
				setNotifyState(false);
				return;
			}
			getRegistration().then(function (reg) {
				return reg.pushManager.getSubscription();
			}).then(function (sub) {
				setNotifyState(!!sub);
				if (sub) saveSubscription(sub);
			}).catch(function () {
				setNotifyState(false);
			});
		}

		if (notifyButton) {
			notifyButton.addEventListener('click', function () {
				if (!pushSupported()) {
					toast('Este navegador não suporta notificações push.', 'er');
					return;
				}
				if (notifyButton.classList.contains('is-on')) {
					unsubscribePush().then(function () {
						toast('Notificações desativadas', 'log');
					});
					return;
				}
				requestPermission(function (permission) {
					if (permission !== 'granted') {
						toast(permission === 'denied'
							? 'Notificações bloqueadas. Habilite para este site nas configurações do navegador.'
							: 'Permissão de notificações não concedida', 'er');
						setNotifyState(false);
						return;
					}
					subscribePush().then(function () {
						toast('Notificações ativadas', 'suc');
					}).catch(function () {
						toast('Não foi possível ativar as notificações', 'er');
					});
				});
			});
		}
		refreshNotifyState();
	});
})();
