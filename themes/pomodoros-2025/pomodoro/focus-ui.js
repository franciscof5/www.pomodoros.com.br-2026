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
		/* Notifications (OneSignal web push)                             */
		/* -------------------------------------------------------------- */
		var userIdBox = document.getElementById('pomo-user-id');
		var userId = userIdBox ? userIdBox.value : '';
		var notifyButton = document.querySelector('.js-pomo-notify');
		var notifyLabel = notifyButton ? notifyButton.querySelector('.js-pomo-notify-label') : null;

		function setNotifyState(on) {
			if (!notifyButton) return;
			notifyButton.classList.toggle('is-on', !!on);
			if (notifyLabel) notifyLabel.textContent = on ? 'Notificações ativas' : 'Ativar notificações';
		}

		// The OneSignal snippet defines window.OneSignal as an array (a command
		// queue). Only treat it as "ready" once the real SDK object is present.
		function realOneSignal() {
			var sdk = window.OneSignal;
			if (!sdk || Array.isArray(sdk)) return null;
			if (typeof sdk.init === 'function' || sdk.User || sdk.Notifications ||
				typeof sdk.registerForPushNotifications === 'function' ||
				typeof sdk.showNativePrompt === 'function') {
				return sdk;
			}
			return null;
		}

		function whenOneSignalReady(callback, attempt) {
			attempt = attempt || 0;
			var sdk = realOneSignal();
			if (sdk) {
				callback(sdk);
				return;
			}
			if (attempt >= 40) {
				callback(null);
				return;
			}
			window.setTimeout(function () {
				whenOneSignalReady(callback, attempt + 1);
			}, 250);
		}

		function linkUser(sdk) {
			if (!userId || !sdk) return;
			try {
				if (typeof sdk.login === 'function') { sdk.login(String(userId)); return; }
				if (sdk.User && typeof sdk.User.login === 'function') { sdk.User.login(String(userId)); return; }
				if (typeof sdk.setExternalUserId === 'function') { sdk.setExternalUserId(String(userId)); return; }
				if (typeof sdk.push === 'function') {
					sdk.push(function () {
						var one = window.OneSignal;
						try {
							if (one && typeof one.setExternalUserId === 'function') one.setExternalUserId(String(userId));
							else if (one && typeof one.login === 'function') one.login(String(userId));
						} catch (e) {}
					});
				}
			} catch (e) {}
		}

		function subscribe(sdk) {
			if (!sdk) return;
			linkUser(sdk);
			try {
				if (sdk.User && sdk.User.PushSubscription && typeof sdk.User.PushSubscription.optIn === 'function') {
					sdk.User.PushSubscription.optIn();
					return;
				}
				if (typeof sdk.registerForPushNotifications === 'function') {
					sdk.registerForPushNotifications();
					return;
				}
				if (typeof sdk.setSubscription === 'function') {
					sdk.setSubscription(true);
				}
			} catch (e) {}
		}

		function unsubscribe(sdk) {
			if (!sdk) return;
			try {
				if (sdk.User && sdk.User.PushSubscription && typeof sdk.User.PushSubscription.optOut === 'function') {
					sdk.User.PushSubscription.optOut();
					return;
				}
				if (typeof sdk.setSubscription === 'function') {
					sdk.setSubscription(false);
				}
			} catch (e) {}
		}

		// Ask the browser directly (native prompt), bypassing the OneSignal
		// prompt UI which does not always show on Firefox mobile. This also
		// overrides any previous OneSignal opt-out.
		function requestPermission(callback) {
			var done = false;
			function finish(permission) {
				if (done) return;
				done = true;
				callback(permission || 'default');
			}

			if ('Notification' in window && typeof Notification.requestPermission === 'function') {
				try {
					var result = Notification.requestPermission(finish);
					if (result && typeof result.then === 'function') {
						result.then(finish);
					}
					return;
				} catch (e) {}
			}

			var sdk = realOneSignal();
			if (sdk && sdk.Notifications && typeof sdk.Notifications.requestPermission === 'function') {
				try {
					var p = sdk.Notifications.requestPermission();
					if (p && typeof p.then === 'function') {
						p.then(function (granted) { finish(granted ? 'granted' : 'denied'); });
						return;
					}
				} catch (e) {}
			}
			finish('denied');
		}

		function refreshNotifyState() {
			if (!notifyButton) return;

			var granted = ('Notification' in window) && Notification.permission === 'granted';
			if (!granted) {
				setNotifyState(false);
				return;
			}
			setNotifyState(true);

			whenOneSignalReady(function (sdk) {
				if (!sdk) return;
				try {
					if (sdk.User && sdk.User.PushSubscription) {
						var ps = sdk.User.PushSubscription;
						if (typeof ps.optedIn === 'boolean') setNotifyState(ps.optedIn);
						return;
					}
					if (typeof sdk.isPushNotificationsEnabled === 'function') {
						var result = sdk.isPushNotificationsEnabled(function (enabled) {
							setNotifyState(!!enabled);
						});
						if (result && typeof result.then === 'function') {
							result.then(function (enabled) { setNotifyState(!!enabled); });
						}
					}
				} catch (e) {}
			});
		}

		if (notifyButton) {
			notifyButton.addEventListener('click', function () {
				// Toggle: if already active, turn it off; otherwise ask the
				// browser permission (directly) and opt the user in.
				if (notifyButton.classList.contains('is-on')) {
					whenOneSignalReady(function (sdk) { unsubscribe(sdk); });
					setNotifyState(false);
					toast('Notificações desativadas', 'log');
					return;
				}

				requestPermission(function (permission) {
					if (permission !== 'granted') {
						if (permission === 'denied') {
							toast('Notificações bloqueadas. Habilite para este site nas configurações do navegador.', 'er');
						} else {
							toast('Permissão de notificações não concedida', 'er');
						}
						setNotifyState(false);
						return;
					}
					setNotifyState(true);
					toast('Notificações ativadas', 'suc');
					whenOneSignalReady(function (sdk) {
						if (sdk) subscribe(sdk);
					});
				});
			});
		}

		// Link the WP user id as soon as the SDK is available.
		if (userId) {
			whenOneSignalReady(function (sdk) {
				if (sdk) linkUser(sdk);
			});
		}

		refreshNotifyState();
	});
})();
