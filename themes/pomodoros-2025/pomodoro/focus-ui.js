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
			if (typeof sdk.init === 'function' || typeof sdk.showNativePrompt === 'function' || typeof sdk.registerForPushNotifications === 'function') {
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
			if (attempt >= 48) {
				callback(null);
				return;
			}
			window.setTimeout(function () {
				whenOneSignalReady(callback, attempt + 1);
			}, 250);
		}

		function refreshNotifyState() {
			if (!notifyButton) return;

			if ('Notification' in window && Notification.permission === 'granted') {
				setNotifyState(true);
			}

			whenOneSignalReady(function (sdk) {
				if (!sdk || typeof sdk.isPushNotificationsEnabled !== 'function') return;
				try {
					var result = sdk.isPushNotificationsEnabled(function (enabled) {
						setNotifyState(enabled);
					});
					if (result && typeof result.then === 'function') {
						result.then(function (enabled) {
							setNotifyState(enabled);
						});
					}
				} catch (e) {}
			});
		}

		function linkUser(sdk) {
			if (!userId) return;
			sdk.push(function () {
				var one = window.OneSignal;
				try {
					if (typeof one.setExternalUserId === 'function') {
						one.setExternalUserId(String(userId));
					} else if (typeof one.login === 'function') {
						one.login(String(userId));
					}
				} catch (e) {}
			});
		}

		if (notifyButton) {
			notifyButton.addEventListener('click', function () {
				whenOneSignalReady(function (sdk) {
					if (sdk) {
						linkUser(sdk);
						try {
							if (typeof sdk.showNativePrompt === 'function') {
								sdk.showNativePrompt();
							} else if (typeof sdk.registerForPushNotifications === 'function') {
								sdk.registerForPushNotifications();
							} else if (typeof sdk.showHttpPrompt === 'function') {
								sdk.showHttpPrompt();
							} else if (sdk.Notifications && typeof sdk.Notifications.requestPermission === 'function') {
								sdk.Notifications.requestPermission();
							}
						} catch (e) {}
						window.setTimeout(refreshNotifyState, 900);
						return;
					}

					// OneSignal SDK not available: fall back to the native API so
					// the button still gives clear feedback instead of doing nothing.
					if ('Notification' in window) {
						toast('OneSignal não está configurado; pedindo permissão do navegador', 'log');
						try {
							Notification.requestPermission().then(function (permission) {
								var granted = permission === 'granted';
								setNotifyState(granted);
								toast(granted ? 'Permissão de notificações concedida' : 'Permissão de notificações negada', granted ? 'suc' : 'er');
							});
						} catch (e) {
							toast('Não foi possível pedir permissão de notificação', 'er');
						}
					} else {
						toast('Este navegador não suporta notificações', 'er');
					}
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
