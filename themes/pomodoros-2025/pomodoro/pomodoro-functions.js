(function () {
	'use strict';

	var $ = window.jQuery;

	var CONFIG = {
		focusSeconds: 1500,
		restSeconds: 300,
		bigRestSeconds: 1800,
		pomodorosPerBigRest: 4,
		tickMs: 200,
		syncMs: 15000,
		flipMs: 300,
		syncGraceMs: 20000,
		clipboardDebounceMs: 600,
		colorDefault: '#000000',
		colorFocus: '#006633',
		colorRest: '#990000',
		images: {
			upRight: '/pomodoro/Double/Up/Right/',
			downRight: '/pomodoro/Double/Down/Right/',
			upLeft: '/pomodoro/Double/Up/Left/',
			downLeft: '/pomodoro/Double/Down/Left/'
		}
	};

	var S = {
		mode: 'focus',
		running: false,
		endsAt: 0,
		remaining: CONFIG.focusSeconds,
		completedInCycle: 0,
		autoAction: false,
		autoCycle: false,
		cycleIndex: 1,
		ajaxBusy: false,
		startedAt: 0,
		lastSecond: -1,
		digits: [-1, -1, -1, -1],
		volume: 100,
		voice: null,
		noSleep: null,
		wakeLock: null,
		wakeBound: false,
		syncTimer: null,
		tickTimer: null,
		digitalTimer: null,
		clipboardTimer: null,
		listenTimer: null,
		tagSelect: null,
		sortableReady: false,
		applyingTags: false,
		lastTagsSignature: '',
		qtddTasks: 0
	};

	function byId(id) {
		return document.getElementById(id);
	}

	function val(id) {
		var el = byId(id);
		return el ? el.value : '';
	}

	function setVal(id, value) {
		var el = byId(id);
		if (el) {
			el.value = (value === undefined || value === null) ? '' : value;
		}
	}

	function text(id) {
		var el = byId(id);
		return el ? el.textContent : '';
	}

	function checked(id) {
		var el = byId(id);
		return !!(el && el.checked);
	}

	function t(name, fallback) {
		var value = window[name];
		return (value === undefined || value === null) ? fallback : value;
	}

	function themeBase() {
		return (window.pomodorosData && window.pomodorosData.themeUrl) || '';
	}

	function isAdmin() {
		return !!(window.data_from_php && window.data_from_php.is_admin);
	}

	function debug() {
		if (isAdmin() && window.console && console.log) {
			try {
				console.log.apply(console, arguments);
			} catch (e) {}
		}
	}

	function pad(n) {
		return (n < 10 ? '0' : '') + n;
	}

	function formatClock(seconds) {
		var safe = Math.max(0, Math.floor(seconds));
		return pad(Math.floor(safe / 60)) + ':' + pad(safe % 60);
	}

	function escapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
	}

	function announce(message, kind) {
		if (S.voice) {
			try {
				S.voice.shutUp();
			} catch (e) {}
			if (S.volume > 1 && checked('voice_enabled') && typeof S.voice.say === 'function') {
				try {
					S.voice.say(message, {
						onStart: function () {
							if (window.artyom_voice) window.artyom_voice.dontObey();
						},
						onEnd: function () {
							if (window.artyom_voice) window.artyom_voice.obey();
						}
					});
				} catch (e) {}
			}
		}
		if (typeof window.alertify === 'undefined') return;
		if (kind === 'suc') {
			alertify.success(message);
		} else if (kind === 'er') {
			alertify.error(message);
		} else {
			alertify.log(message);
		}
	}

	function audioEl(name) {
		var map = {
			active: 'active_sound',
			completed: 'pomodoro_completed_sound',
			reset: 'session_reseted_sound'
		};
		return byId(map[name]);
	}

	function playSound(name) {
		if (!checked('soundfx_enabled')) return;
		var audio = audioEl(name);
		if (!audio) return;
		try {
			audio.currentTime = 0;
			var promise = audio.play();
			if (promise && promise.catch) promise.catch(function () {});
		} catch (e) {}
	}

	function applyAudioVolume() {
		['active_sound', 'pomodoro_completed_sound', 'session_reseted_sound'].forEach(function (id) {
			var audio = byId(id);
			if (audio) {
				try {
					audio.volume = Math.min(1, Math.max(0, S.volume / 100));
				} catch (e) {}
			}
		});
	}

	function cancelAnimations(element) {
		if (element && typeof element.getAnimations === 'function') {
			element.getAnimations().forEach(function (animation) {
				animation.cancel();
			});
		}
	}

	function flip(upperId, lowerId, digit, pathUpper, pathLower) {
		var upper = byId(upperId);
		var lower = byId(lowerId);
		var upperBack = byId(upperId + 'Back');
		var lowerBack = byId(lowerId + 'Back');
		if (!upper || !lower || !upperBack || !lowerBack) return;

		var base = themeBase();

		cancelAnimations(upper);
		if (upperBack.getAttribute('src')) upper.setAttribute('src', upperBack.getAttribute('src'));
		upperBack.setAttribute('src', base + pathUpper + digit + '.png');
		upper.style.height = '64px';
		if (typeof upper.animate === 'function') {
			var up = upper.animate(
				[{ height: '64px' }, { height: '0px' }],
				{ duration: CONFIG.flipMs, easing: 'ease-in-out' }
			);
			up.onfinish = function () {
				up.cancel();
				upper.style.height = '0px';
			};
		} else {
			upper.style.height = '0px';
		}

		cancelAnimations(lower);
		if (lowerBack.getAttribute('src')) lower.setAttribute('src', lowerBack.getAttribute('src'));
		lowerBack.setAttribute('src', base + pathLower + digit + '.png');
		lower.style.height = '64px';
		lower.style.marginTop = '0px';
		if (typeof lower.animate === 'function') {
			var down = lower.animate(
				[
					{ height: '64px', marginTop: '0px' },
					{ height: '0px', marginTop: '50px' }
				],
				{ duration: CONFIG.flipMs, easing: 'ease-in-out' }
			);
			down.onfinish = function () {
				down.cancel();
				lower.style.height = '0px';
				lower.style.marginTop = '50px';
			};
		} else {
			lower.style.height = '0px';
			lower.style.marginTop = '50px';
		}
	}

	function setDigit(index, digit, upId, downId, upPath, downPath, force) {
		if (!force && S.digits[index] === digit) return;
		S.digits[index] = digit;
		flip(upId, downId, digit, upPath, downPath);
	}

	function updateDocumentTitle(seconds) {
		document.title = formatClock(seconds) + ' - ' + val('title_box');
	}

	function modeLabel() {
		if (S.mode === 'rest') return t('txt_mode_rest', 'Descanso');
		if (S.mode === 'bigRest') return t('txt_mode_big_rest', 'Grande descanso');
		return t('txt_mode_focus', 'Foco');
	}

	function updateClock(total) {
		var timeEl = byId('pomodoro-time');
		if (timeEl) timeEl.textContent = formatClock(total);

		var modeEl = byId('pomodoro-mode');
		if (modeEl) modeEl.textContent = modeLabel();

		var clock = byId('relogio');
		if (clock) clock.setAttribute('data-mode', S.mode);

		var ring = byId('pomo-ring');
		if (ring) {
			var radius = parseFloat(ring.getAttribute('r')) || 110;
			var circumference = 2 * Math.PI * radius;
			var denominator = durationFor(S.mode) || 1;
			var fraction = Math.min(1, Math.max(0, total / denominator));
			ring.style.strokeDasharray = circumference + ' ' + circumference;
			ring.style.strokeDashoffset = String(circumference * (1 - fraction));
		}

		if (document.body) document.body.classList.toggle('is-running', S.running);
	}

	function render(seconds, force) {
		var total = Math.max(0, Math.round(seconds));
		var minutes = Math.floor(total / 60);
		var secs = total % 60;
		var digits = [
			Math.floor(minutes / 10) % 10,
			minutes % 10,
			Math.floor(secs / 10) % 10,
			secs % 10
		];

		setDigit(0, digits[0], 'minutesUpLeft', 'minutesDownLeft', CONFIG.images.upLeft, CONFIG.images.downLeft, force);
		setDigit(1, digits[1], 'minutesUpRight', 'minutesDownRight', CONFIG.images.upRight, CONFIG.images.downRight, force);
		setDigit(2, digits[2], 'secondsUpLeft', 'secondsDownLeft', CONFIG.images.upLeft, CONFIG.images.downLeft, force);
		setDigit(3, digits[3], 'secondsUpRight', 'secondsDownRight', CONFIG.images.upRight, CONFIG.images.downRight, force);

		var box = byId('secondsRemaining_box');
		if (box) box.value = total + 's';

		updateClock(total);
		updateDocumentTitle(total);
	}

	function currentSeconds() {
		if (!S.running) return S.remaining;
		return Math.max(0, Math.ceil((S.endsAt - Date.now()) / 1000));
	}

	function durationFor(mode) {
		if (mode === 'rest') return CONFIG.restSeconds;
		if (mode === 'bigRest') return CONFIG.bigRestSeconds;
		return CONFIG.focusSeconds;
	}

	function tick() {
		var secs = Math.max(0, Math.ceil((S.endsAt - Date.now()) / 1000));
		if (secs !== S.lastSecond) {
			S.lastSecond = secs;
			render(secs);
		}
		if (secs <= 0) {
			stopTicking();
			complete();
		}
	}

	function startTicking() {
		if (S.tickTimer) return;
		S.tickTimer = window.setInterval(tick, CONFIG.tickMs);
		tick();
	}

	function stopTicking() {
		if (S.tickTimer) {
			window.clearInterval(S.tickTimer);
			S.tickTimer = null;
		}
	}

	function setButton(label, color) {
		var button = byId('action_button_id');
		if (!button) return;
		button.value = label;
		if ($ && $.fn && typeof $(button).animate === 'function') {
			$(button).stop(true, false).animate({ backgroundColor: color }, 2000);
		} else {
			button.style.backgroundColor = color;
		}
	}

	function getTagsValue() {
		if (S.tagSelect && typeof S.tagSelect.getValue === 'function') {
			return S.tagSelect.getValue();
		}
		var box = byId('tags_box');
		return box && $ ? $(box).val() : [];
	}

	function tagsText() {
		var value = getTagsValue();
		return value && value.toString ? value.toString().replace(/,/g, ', ') : '';
	}

	function turnOnIndicator(number) {
		var el = byId('pomoindi' + number);
		if (!el) return;
		el.classList.add('is-done');
		if ($ && $.fn && typeof $(el).animate === 'function') {
			$(el).stop(true, false).animate({ 'background-position': '-30px' });
		}
	}

	function resetIndicators() {
		for (var i = 1; i <= CONFIG.pomodorosPerBigRest; i++) {
			var el = byId('pomoindi' + i);
			if (!el) continue;
			el.classList.remove('is-done');
			if ($ && $.fn && typeof $(el).animate === 'function') {
				$(el).stop(true, false).animate({ 'background-position': '0px' });
			}
		}
	}

	function start_clock() {
		if (S.running) return;
		playSound('active');

		S.running = true;
		S.remaining = S.remaining > 0 ? S.remaining : durationFor(S.mode);
		S.endsAt = Date.now() + S.remaining * 1000;
		S.startedAt = Date.now();
		S.lastSecond = -1;
		startTicking();

		if (S.mode === 'focus') {
			setButton(t('textInterruptFocus', 'INTERROMPER FOCO'), CONFIG.colorFocus);
			announce(t('txt_started_countdown', 'Iniciar tarefa ') + val('title_box') + ', tags ' + tagsText());
			if (val('status_box') === 'draft') {
				setVal('status_box', 'future');
				save_progress('future');
			}
		} else {
			setButton(t('textInterruptRest', 'PARAR DESCANSO'), CONFIG.colorRest);
			announce(t('txt_rest_started', 'Tempo de descanso iniciado'));
		}

		ensureWakeLock();
	}

	function onPomodoroCompleted() {
		S.completedInCycle++;
		turnOnIndicator(S.completedInCycle);
		setVal('status_box', 'publish');
		save_progress('publish');

		if (S.completedInCycle >= CONFIG.pomodorosPerBigRest) {
			S.completedInCycle = 0;
			S.mode = 'bigRest';
			S.remaining = CONFIG.bigRestSeconds;
			S.lastSecond = -1;
			setButton(t('textBigRest', 'GRANDE DESCANSO'), CONFIG.colorDefault);
			announce(t('txt_bigrest_countdown', ''));
			document.title = t('txt_title_big_rest', 'GRANDE DESCANSO');
			resetIndicators();
		} else {
			S.mode = 'rest';
			S.remaining = CONFIG.restSeconds;
			S.lastSecond = -1;
			setButton(t('textRest', 'DESCANSAR!'), CONFIG.colorDefault);
			announce(t('txt_normalrest_countdown', ''));
			document.title = t('txt_title_rest', 'Hora do intervalo');
		}

		if (S.autoCycle) cycle_list_next();
	}

	function complete() {
		playSound('completed');
		stopTicking();
		S.running = false;

		if (S.mode === 'focus') {
			onPomodoroCompleted();
		} else {
			S.mode = 'focus';
			S.remaining = CONFIG.focusSeconds;
			S.lastSecond = -1;
			setButton(t('textPomodoro', 'FOCAR!'), CONFIG.colorDefault);
			announce(t('txt_completed_rest', 'Você completou o descanso, hora de pegar pesado!'), 'er');
			document.title = t('txt_title_done', 'Pomodoro completado!');
		}

		render(S.remaining, true);

		if (S.autoAction) action_button();
	}

	function interrupt() {
		if (S.mode === 'focus' && val('status_box') === 'future') {
			if (!window.confirm(t('txt_interrupted_ask', 'Deseja interromper a contagem e perder o tempo contabilizado?'))) {
				return;
			}
		}

		playSound('completed');
		stopTicking();
		S.running = false;
		S.mode = 'focus';
		S.remaining = CONFIG.focusSeconds;
		S.lastSecond = -1;

		announce(t('txt_interrupted_countdowns', 'Contagem interrompida!'), 'er');
		setButton(t('textPomodoro', 'FOCAR!'), CONFIG.colorDefault);
		render(S.remaining, true);

		if (val('status_box') === 'future') {
			setVal('status_box', 'draft');
			save_progress('interrupt');
		}
	}

	function action_button() {
		startListenChangesOnTaskForm();
		if (S.running) {
			interrupt();
		} else {
			start_clock();
		}
		ensureWakeLock();
	}

	function reset_pomodoro_session() {
		interrupt();
		S.completedInCycle = 0;
		announce(t('txt_session_reseted', 'Sessão reiniciada'));
		playSound('reset');
		resetIndicators();
	}

	function set_continuous_session() {
		S.autoAction = !S.autoAction;
		var button = byId('resetter_btn');
		if (S.autoAction) {
			announce(t('auto_action_enabled', 'Passador automático habilitado'));
			if (button) {
				button.style.backgroundColor = '#FFF';
				button.style.color = '#222';
			}
		} else {
			announce(t('auto_action_disabled', 'Passador automático desabilitado'));
			if (button) {
				button.style.backgroundColor = 'transparent';
				button.style.color = '#B8B8B8';
			}
		}
	}

	function getRadio(name) {
		var form = document.forms['pomopainel'];
		if (form && form.elements[name]) {
			var els = form.elements[name];
			if (els.length === undefined) return els.checked ? els.value : '';
			for (var i = 0; i < els.length; i++) {
				if (els[i].checked) return els[i].value;
			}
		}
		var list = document.getElementsByName(name);
		for (var j = 0; j < list.length; j++) {
			if (list[j].checked) return list[j].value;
		}
		return '';
	}

	function save_progress(action) {
		debug('save_progress', action);
		var payload = {
			action: 'save_progress',
			post_acao: action,
			post_titulo: val('title_box'),
			post_descri: val('description_box'),
			post_tags: getTagsValue(),
			post_cat: getRadio('cat_vl'),
			post_priv: getRadio('priv_vl'),
			post_local_city: text('user_location_city'),
			post_local_region: text('user_location_region'),
			post_local_country: text('user_location_country')
		};

		$.post(window.ajaxurl, payload, function (response) {
			if (response === 'NOTIN') {
				window.location.href = '/';
				return;
			}
			if (response) {
				announce(t('txt_save_success', 'Progresso salvado'), 'suc');
			} else {
				announce(t('txt_save_error', 'Problema ao salvar'), 'er');
			}
		});
	}

	function update_pomodoro_clipboard() {
		debug('update_pomodoro_clipboard');
		S.ajaxBusy = true;
		var payload = {
			action: 'update_session',
			post_titulo: val('title_box'),
			post_descri: val('description_box'),
			post_tags: getTagsValue(),
			post_cat: getRadio('cat_vl'),
			post_id: val('post_id_box'),
			post_priv: getRadio('priv_vl'),
			range_volume: $(byId('rangeVolume')).val(),
			soundfx_enabled: checked('soundfx_enabled'),
			voice_enabled: checked('voice_enabled')
		};
		if (S.running) payload.interval_clock = true;

		S.volume = parseInt(payload.range_volume, 10);
		if (isNaN(S.volume)) S.volume = 100;
		applyAudioVolume();
		if (S.voice && S.volume > 1) {
			try {
				S.voice.initialize({ volume: S.volume / 100 });
			} catch (e) {}
		}

		$.post(window.ajaxurl, payload, function (response) {
			S.ajaxBusy = false;
			if (response === 'NOTIN') {
				window.location.href = '/';
				return;
			}
			announce(t('txt_update_current_task', 'Salvando tarefa atual...'));
		});
	}

	function scheduleClipboardUpdate() {
		if (S.applyingTags) return;
		if (S.clipboardTimer) window.clearTimeout(S.clipboardTimer);
		S.clipboardTimer = window.setTimeout(function () {
			S.clipboardTimer = null;
			update_pomodoro_clipboard();
		}, CONFIG.clipboardDebounceMs);
	}

	function toTagArray(value) {
		if (value === undefined || value === null || value === '') return [];
		return Array.isArray(value) ? value : [value];
	}

	function buildTagOptions(box, current, available) {
		if (current && current.length) {
			var groupCurrent = document.createElement('optgroup');
			groupCurrent.label = t('txt_in_use', 'Em Uso');
			current.forEach(function (name) {
				var option = document.createElement('option');
				option.value = name;
				option.textContent = name;
				option.selected = true;
				groupCurrent.appendChild(option);
			});
			box.appendChild(groupCurrent);
		}
		if (available && available.length) {
			var groupAvailable = document.createElement('optgroup');
			groupAvailable.label = t('txt_available', 'Disponível');
			available.forEach(function (name) {
				var option = document.createElement('option');
				option.value = name;
				option.textContent = name;
				groupAvailable.appendChild(option);
			});
			box.appendChild(groupAvailable);
		}
	}

	function isTagsOpen() {
		if (!S.tagSelect) return false;
		try {
			return !!S.tagSelect.isOpen;
		} catch (e) {
			return false;
		}
	}

	function applyTags(current, available) {
		var box = byId('tags_box');
		if (!box || isTagsOpen()) return;

		current = toTagArray(current);
		available = toTagArray(available);

		var signature = JSON.stringify([current, available]);
		if (signature === S.lastTagsSignature) return;

		S.applyingTags = true;
		try {
			if (S.tagSelect) {
				try { S.tagSelect.destroy(); } catch (e) {}
				S.tagSelect = null;
			}
			box.innerHTML = '';
			buildTagOptions(box, current, available);
			if (window.TomSelect) {
				S.tagSelect = new window.TomSelect(box, {
					create: true,
					createOnBlur: false,
					persist: false,
					maxItems: null,
					delimiter: ',',
					plugins: ['remove_button'],
					render: {
						option: function (data, escape) {
							return '<div>' + escape(data.text) + '</div>';
						}
					}
				});
				S.tagSelect.on('change', scheduleClipboardUpdate);
			}
			S.lastTagsSignature = signature;
		} finally {
			S.applyingTags = false;
		}
	}

	function applyCategory(list) {
		if (!list || !list.length) return;
		var value = list[0] == 1 ? list[1] : list[0];
		var radios = document.getElementsByName('cat_vl');
		for (var i = 0; i < radios.length; i++) {
			radios[i].checked = String(radios[i].value) === String(value);
		}
	}

	function applySettings(volume, soundFx, voice) {
		S.volume = parseInt(volume, 10);
		if (isNaN(S.volume) || S.volume < 0 || S.volume > 100) S.volume = 100;

		var range = byId('rangeVolume');
		if (range) {
			range.value = S.volume;
			if ($ && $.fn && $.fn.rangeslider) {
				try {
					$(range).rangeslider('update', true);
				} catch (e) {}
			}
		}
		applyAudioVolume();

		var soundBox = byId('soundfx_enabled');
		if (soundBox) soundBox.checked = (soundFx === 'true' || soundFx === true);
		var voiceBox = byId('voice_enabled');
		if (voiceBox) voiceBox.checked = (voice === 'true' || voice === true);

		if (S.voice && S.volume > 1) {
			try {
				S.voice.initialize({ volume: S.volume / 100 });
			} catch (e) {}
		}
	}

	function isEditingTitle() {
		var active = document.activeElement;
		return !!active && (active.id === 'title_box' || active.id === 'description_box');
	}

	function resetAfterServerEnd() {
		stopTicking();
		S.running = false;
		S.mode = 'focus';
		S.remaining = CONFIG.focusSeconds;
		S.lastSecond = -1;
		setButton(t('textPomodoro', 'FOCAR!'), CONFIG.colorDefault);
		render(S.remaining, true);
	}

	function reconcile(serverRemaining) {
		var now = Date.now();

		if (serverRemaining > 0) {
			var drift = Math.abs(currentSeconds() - serverRemaining);
			if (S.mode !== 'focus' || !S.running || drift > 2) {
				S.mode = 'focus';
				S.remaining = serverRemaining;
				S.endsAt = now + serverRemaining * 1000;
				S.startedAt = now;
				S.lastSecond = -1;
				S.running = true;
				setButton(t('textInterruptFocus', 'INTERROMPER FOCO'), CONFIG.colorFocus);
				startTicking();
			}
			return;
		}

		if (S.mode === 'focus' && S.running) {
			if (now - S.startedAt < CONFIG.syncGraceMs) return;
			if (currentSeconds() <= 1) {
				complete();
			} else {
				resetAfterServerEnd();
			}
		}
	}

	function applySession(data) {
		if (!isEditingTitle()) {
			setVal('title_box', data.post_title);
			setVal('description_box', data.post_content);
		}
		setVal('status_box', data.post_status);
		setVal('post_id_box', data.ID);
		if (data.post_data !== undefined) setVal('data_box', data.post_data);

		applyTags(data.post_tags, data.tags_total);
		applyCategory(data.post_category);
		applySettings(data.range_volume, data.soundfx_enabled, data.voice_enabled);
		reconcile(parseInt(data.secondsRemainingFromPHP, 10) || 0);

		var button = byId('action_button_id');
		if (button && button.disabled) {
			button.disabled = false;
			if (!S.running) button.value = t('textPomodoro', 'FOCAR!');
		}
	}

	function load_initial_data() {
		debug('load_initial_data');
		S.ajaxBusy = true;
		$.post(window.ajaxurl, { action: 'load_session' }, function (response) {
			S.ajaxBusy = false;
			if (response === 'NOTIN') {
				window.location.href = '/';
				return;
			}
			var data;
			try {
				data = JSON.parse(response);
			} catch (e) {
				debug('load_session parse error', e);
				return;
			}
			applySession(data);
		});
	}

	function startListenChangesOnTaskForm() {
		if (S.listenTimer) return;
		S.listenTimer = window.setInterval(function () {
			if (!S.ajaxBusy && !isEditingTitle() && !isTagsOpen()) {
				load_initial_data();
			}
		}, CONFIG.syncMs);
	}

	function saveModel() {
		announce(t('txt_salving_model', 'Salvando'));
		var title = val('title_box');
		var tagsValue = getTagsValue();
		$.post(window.ajaxurl, {
			action: 'save_or_delete_model',
			post_titulo: title,
			post_descri: val('description_box'),
			post_tags: tagsValue
		}, function (response) {
			if (response === 'NOTIN') {
				window.location.href = '/';
				return;
			}
			if (!response || response == 0) {
				announce(t('txt_salving_model_task_null', 'Escreva algo no título da tarefa'), 'er');
				return;
			}
			var id = parseInt(response, 10);
			var tagsLabel = (tagsValue && tagsValue.toString) ? tagsValue.toString().replace(/,/g, ', ') : '';
			var html = '<li id="modelo-carregado-' + id + '" class="modelo-carregado ui-draggable ui-draggable-handle">' +
				'<div class="model-container" data-modelid="' + id + '">' +
					'<div class="col-xs-6"><span class="fas fa-move"></span>&nbsp;' +
						'<span id="bxtitle' + id + '">' + escapeHtml(title) + '</span></div>' +
					'<div class="col-xs-6"><span class="fas fa-tags"></span>&nbsp;' +
						'<span id="bxtag' + id + '">' + escapeHtml(tagsLabel) + '</span></div>' +
				'</div>' +
				'<div class="model-container-extra">' +
					'<button class="btn btn-xs btn-success delete-task-model-btn" data-modelid="' + id + '"><span class="fas fa-trash" style="color:black"></span></button>' +
					'<button class="btn btn-xs btn-none remove-task-from-list-btn" data-modelid="' + id + '"><span class="fas fa-trash"></span></button>' +
				'</div></li>';
			$('#contem-modelos').append(html);
			modelTaskButtons();
			announce(t('txt_salving_model_success', 'Tarefa salva'));
		});
	}

	function deleteModel(id) {
		$('#modelo-carregado-' + id).hide(1000);
		announce(t('txt_deleting_model', 'Completando tarefa...'));
		$.post(window.ajaxurl, {
			action: 'save_or_delete_model',
			post_para_deletar: id
		}, function (response) {
			if (response === 'NOTIN') {
				window.location.href = '/';
				return;
			}
			if (response) {
				announce(t('txt_deleting_model_sucess', 'Parabéns!'));
			} else {
				announce(t('txt_save_error', 'Problema ao salvar'), 'er');
			}
		});
	}

	function loadModel(id) {
		debug('loadModel', id);
		announce(t('txt_loading_model', 'Tarefa carregada, hora de produzir!'));
		var titleEl = byId('bxtitle' + id);
		if (titleEl) setVal('title_box', titleEl.textContent);
		var contentEl = byId('bxcontent' + id);
		setVal('description_box', contentEl ? contentEl.textContent : '');

		var tagEl = byId('bxtag' + id);
		var tags = [];
		if (tagEl) {
			tagEl.textContent.split(',').forEach(function (part) {
				var clean = part.replace(/\s+/g, '');
				if (clean) tags.push(clean);
			});
		}
		if (S.tagSelect && tags.length) {
			S.tagSelect.addOptions(tags.map(function (name) {
				return { value: name, text: name };
			}));
			S.tagSelect.setValue(tags);
		}
	}

	function cycle_list_update(clean) {
		var payload = {
			action: 'update_cycle_list',
			list: $('#contem-ciclo').html(),
			clean: clean
		};
		if (clean) announce('Cleaning list...');
		$.post(window.ajaxurl, payload, function (response) {
			if (clean) {
				if (response) {
					announce('Cycle list cleared');
					$('#contem-ciclo').html('');
				}
			} else if (response) {
				announce('updating cycle list');
			} else {
				announce('Not updated cycle list', 'er');
			}
		});
	}

	function cycle_list_load_model() {
		var currentModelId = jQuery('#contem-ciclo li:nth-child(' + S.cycleIndex + ')').find('div').data('modelid');
		jQuery('#contem-ciclo li').each(function () {
			jQuery(this).removeClass('cycleSelectedTask');
			jQuery(this).animate({ 'background-color': '#FFF', color: '#000' }, 200);
		});
		jQuery('#contem-ciclo li:nth-child(' + S.cycleIndex + ')')
			.addClass('cycleSelectedTask')
			.animate({ 'background-color': '#222', color: '#CCC' }, 300);
		if (currentModelId !== undefined) loadModel(currentModelId);
	}

	function cycle_list_play() {
		if (S.autoCycle) {
			S.autoCycle = false;
			announce(t('auto_cycle_disabled', 'Ciclo automático desabilitado'));
			$('#cycle_start').html('<span class="fas fa-play" aria-hidden="true"></span>');
			$('#cycle_start').css({ 'background-color': '#CCC', color: '#222' });
			$('#contem-ciclo li').each(function () {
				jQuery(this).animate({ 'background-color': '#FFF', color: '#000' }, 500);
			});
		} else {
			if (!$('#contem-ciclo li').length) {
				announce('You must add at least one task', 'er');
				return;
			}
			S.autoCycle = true;
			announce(t('auto_cycle_enabled', 'Ciclo automático habilitado'));
			$('#cycle_start').html('<span class="fas fa-stop" aria-hidden="true"></span>');
			$('#cycle_start').css({ 'background-color': '#222', color: '#CCC' });
			cycle_list_load_model();
		}
	}

	function cycle_list_next() {
		S.qtddTasks = jQuery('ul#contem-ciclo li').length;
		if (S.qtddTasks === S.cycleIndex) {
			S.cycleIndex = 1;
		} else {
			S.cycleIndex++;
		}
		cycle_list_load_model();
	}

	function cycle_list_prev() {
		S.qtddTasks = jQuery('ul#contem-ciclo li').length;
		if (S.cycleIndex <= 1) {
			S.cycleIndex = S.qtddTasks;
		} else {
			S.cycleIndex--;
		}
		cycle_list_load_model();
	}

	function setupSortable() {
		if (S.sortableReady || !$ || !$.fn || !$.fn.sortable) return;
		var removeIntent = false;

		$('#contem-ciclo').sortable({
			revert: true,
			over: function () {
				removeIntent = false;
			},
			out: function () {
				removeIntent = true;
			},
			beforeStop: function (event, ui) {
				if (removeIntent === true) ui.item.remove();
			},
			receive: function () {
				cycle_list_update();
			}
		}).droppable({
			out: function () {
				cycle_list_update();
			}
		});

		if ($.fn.draggable) {
			$('#contem-modelos li').draggable({
				connectToSortable: '#contem-ciclo',
				snap: '#contem-ciclo',
				snapMode: 'outer',
				helper: 'clone',
				revert: 'invalid',
				cursor: 'move'
			});
		}
		if ($.fn.disableSelection) $('ul, li').disableSelection();

		S.sortableReady = true;
	}

	function modelTaskButtons() {
		$('#botao-salvar-modelo').off('click.pom').on('click.pom', function (e) {
			e.preventDefault();
			saveModel();
		});
		$('.delete-task-model-btn').off('click.pom').on('click.pom', function (e) {
			e.preventDefault();
			deleteModel($(this).data('modelid'));
		});
		$('.remove-task-from-list-btn').off('click.pom').on('click.pom', function (e) {
			e.preventDefault();
			$(this).parent().parent().remove();
			cycle_list_update();
		});
		$('#contem-modelos .model-container').off('click.pom').on('click.pom', function (e) {
			e.preventDefault();
			loadModel($(this).data('modelid'));
		});
		setupSortable();
		S.qtddTasks = $('ul#contem-ciclo li').length;
	}

	var grupoDeComandos = [{
		indexes: ['iniciar', 'focar', 'começar', 'interromper'],
		action: function () {
			if (S.voice) S.voice.say('Pois não');
			action_button();
		}
	}];

	var groupOfCommands = [{
		indexes: ['start', 'focus', 'begin', 'interrupt', 'stop'],
		action: function () {
			if (S.voice) S.voice.say('Ok');
			action_button();
		}
	}];

	var groupSwith = [{
		indexes: ['switch to portuguese', 'switch to english'],
		action: function (i) {
			var langs = ['pt-BR', 'en-US'];
			if (S.voice) S.voice.initialize({ lang: langs[i] || 'en-US' });
		}
	}];

	function startContinuousArtyom() {
		if (typeof window.Artyom === 'undefined') return;
		try {
			S.voice = new window.Artyom();
			window.artyom_voice = S.voice;
			S.voice.fatality();

			var locale = (window.data_from_php && window.data_from_php.php_locale) || 'pt_BR';
			var lang = 'pt-BR';
			var commands = grupoDeComandos;
			if (locale.indexOf('pt') === 0) {
				lang = 'pt-BR';
				commands = grupoDeComandos;
			} else if (locale.indexOf('es') === 0) {
				lang = 'es-ES';
			} else if (locale.indexOf('fr') === 0) {
				lang = 'fr-FR';
			} else if (locale.indexOf('zh') === 0) {
				lang = 'CN';
			} else if (locale.indexOf('en') === 0) {
				lang = 'en-US';
				commands = groupOfCommands;
			}

			var supported = typeof S.voice.recognizingSupported === 'function' ? S.voice.recognizingSupported() : false;
			S.voice.initialize({
				lang: lang,
				continuous: true,
				listen: supported,
				debug: isAdmin(),
				speed: 1
			}).then(function () {
				debug('artyom ready');
			});
			if (supported) {
				S.voice.addCommands(commands);
				S.voice.addCommands(groupSwith);
			}
		} catch (e) {
			debug('artyom error', e);
		}
	}

	function ensureWakeLock() {
		if ('wakeLock' in navigator) {
			if (document.visibilityState !== 'visible' || S.wakeLock) return;
			try {
				navigator.wakeLock.request('screen').then(function (lock) {
					S.wakeLock = lock;
					lock.addEventListener('release', function () {
						S.wakeLock = null;
					});
				}).catch(function () {});
			} catch (e) {}
			return;
		}
		if (typeof window.NoSleep === 'function') {
			try {
				if (!S.noSleep) S.noSleep = new window.NoSleep();
				S.noSleep.enable();
			} catch (e) {}
		}
	}

	function startNoSleepWakeLock() {
		if (S.wakeBound) return;
		S.wakeBound = true;
		var handler = function () {
			ensureWakeLock();
			document.removeEventListener('click', handler, false);
			document.removeEventListener('touchstart', handler, false);
		};
		document.addEventListener('click', handler, false);
		document.addEventListener('touchstart', handler, false);
	}

	function atualizarRelogioDigital() {
		var now = new Date();
		var hours = byId('relogio-horas');
		var minutes = byId('relogio-minutos');
		if (hours) hours.textContent = pad(now.getHours());
		if (minutes) minutes.textContent = pad(now.getMinutes());
	}

	function scheduleDigitalClock() {
		atualizarRelogioDigital();
		var now = new Date();
		var wait = (60 - now.getSeconds()) * 1000 - now.getMilliseconds() + 50;
		S.digitalTimer = window.setTimeout(scheduleDigitalClock, wait);
	}

	function bindClick(id, handler) {
		var el = byId(id);
		if (el) {
			el.addEventListener('click', function (e) {
				e.preventDefault();
				handler();
			});
		}
	}

	function bindFormChange() {
		['title_box', 'description_box'].forEach(function (id) {
			var el = byId(id);
			if (el) {
				el.addEventListener('change', scheduleClipboardUpdate);
				el.addEventListener('blur', scheduleClipboardUpdate);
			}
		});
		var tags = byId('tags_box');
		if (tags) tags.addEventListener('change', scheduleClipboardUpdate);

		['cat_vl', 'priv_vl'].forEach(function (name) {
			var list = document.getElementsByName(name);
			for (var i = 0; i < list.length; i++) {
				list[i].addEventListener('change', scheduleClipboardUpdate);
			}
		});

		['rangeVolume', 'soundfx_enabled', 'voice_enabled'].forEach(function (id) {
			var el = byId(id);
			if (el) el.addEventListener('change', scheduleClipboardUpdate);
		});
	}

	function bindUi() {
		var action = byId('action_button_id');
		if (action) {
			action.disabled = true;
			action.addEventListener('click', function (e) {
				e.preventDefault();
				action_button();
			});
		}
		var clock = byId('relogio');
		if (clock) {
			clock.addEventListener('click', function (e) {
				e.preventDefault();
				action_button();
			});
		}

		bindClick('session-reset-btn', reset_pomodoro_session);
		bindClick('continuos-session-btn', set_continuous_session);
		bindClick('cycle_empty', function () {
			cycle_list_update(true);
		});
		bindClick('cycle_start', cycle_list_play);
		bindClick('cycle_prev', cycle_list_prev);
		bindClick('cycle_next', cycle_list_next);

		modelTaskButtons();

		if ($ && $.fn && $.fn.rangeslider) {
			try {
				$('input[type="range"]').rangeslider();
			} catch (e) {}
		}
	}

	function init() {
		debug('init');
		scheduleDigitalClock();
		bindUi();
		bindFormChange();
		startContinuousArtyom();
		startNoSleepWakeLock();
		announce(t('txt_loading_initial_data', 'Bem vindo ao Pomodoros.com.br'));
		S.remaining = CONFIG.focusSeconds;
		render(S.remaining, true);
		load_initial_data();
		startListenChangesOnTaskForm();
	}

	window.action_button = action_button;
	window.reset_pomodoro_session = reset_pomodoro_session;
	window.set_continuous_session = set_continuous_session;
	window.startNoSleepWakeLock = startNoSleepWakeLock;
	window.startContinuousArtyom = startContinuousArtyom;
	window.load_initial_data = load_initial_data;
	window.update_pomodoro_clipboard = update_pomodoro_clipboard;
	window.load_model = loadModel;
	window.delete_model = deleteModel;
	window.cycle_list_update = cycle_list_update;
	window.cycle_list_play = cycle_list_play;
	window.cycle_list_next = cycle_list_next;
	window.cycle_list_prev = cycle_list_prev;
	window.getRadioCheckedValue = getRadio;

	document.addEventListener('visibilitychange', function () {
		if (document.hidden) return;
		render(currentSeconds());
		if (S.running) {
			ensureWakeLock();
			if (currentSeconds() <= 0) complete();
		}
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
