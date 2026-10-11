<?php
/**
 * Focus page - modern dark UI.
 *
 * Keeps every id, form field and AJAX endpoint used by
 * pomodoro/pomodoro-functions.js and the WordPress contract
 * (projectimer_focus posts). The look is defined in
 * pomodoro/focus-modern.css, scoped to body.pomo-app (all app pages).
 * The shared app bar lives in part-appbar.php (rendered by header-app.php).
 */

// Tom Select (modern tags box) + jquery-ui (sortable cycler and draggable TODO list)
wp_register_script("tom-select-js", get_bloginfo("stylesheet_directory") . "/assets/tom-select/tom-select.complete.min.js");
wp_register_style('tom-select-css', get_bloginfo("stylesheet_directory") . "/assets/tom-select/tom-select.default.min.css", __FILE__);

wp_register_script("jquery-ui-js", get_bloginfo("stylesheet_directory") . "/assets/jquery-ui/jquery-ui.min.js");
wp_register_style('jquery-ui-css', get_bloginfo("stylesheet_directory") . "/assets/jquery-ui/jquery-ui.min.css", __FILE__);
wp_register_script("jquery-ui-touhc-js", get_bloginfo("stylesheet_directory") . "/assets/jquery.ui.touch-punch.min.js");
wp_enqueue_script("jquery-color", get_bloginfo("stylesheet_directory") . "/assets/jquery.color-2.1.2.min.js");

// wake lock + voice
wp_register_script("nosleep-js", get_bloginfo("stylesheet_directory") . "/assets/NoSleep.min.js");
wp_register_script("artyom-js", get_bloginfo("stylesheet_directory") . "/assets/artyom.window.min.js");

wp_enqueue_script("pomodoros-js");
wp_enqueue_script("rangeslider-js");
wp_enqueue_script("sound-js");
wp_enqueue_script("tom-select-js");
wp_enqueue_style("tom-select-css");
wp_enqueue_script("jquery-ui-js");
wp_enqueue_style("jquery-ui-css");
wp_enqueue_script("jquery-ui-touhc-js");
wp_enqueue_script("nosleep-js");
wp_enqueue_script("artyom-js");

// pomodoro/focus-modern.css and pomodoro/focus-ui.js are enqueued from
// functions.php (load_scritps) so the dark theme is printed in <head>.

$theme_uri = get_stylesheet_directory_uri();
$pomo_user_id = is_user_logged_in() ? get_current_user_id() : 0;
$current_user = wp_get_current_user();
?>
	<script>
		document.title = "Pomodoros <?php global $title_apendix;
		echo $title_apendix . ' >> ';
		_e('Focus', 'sis-foca-js'); ?>";
	</script>

	<audio id="active_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/crank-2.mp3" preload="auto"></audio>
	<audio id="pomodoro_completed_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/23193__kaponja__10trump-tel.mp3" preload="auto"></audio>
	<audio id="session_reseted_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/magic-chime-02.mp3" preload="auto"></audio>

	<div class="pomo-focus">

		<section class="pomo-timer">
			<div class="pomo-clock" id="relogio" data-mode="focus" role="button" tabindex="0"
				aria-label="<?php _e('Start or stop the timer', 'sis-foca-js'); ?>">
				<svg class="pomo-clock__ring" viewBox="0 0 240 240" aria-hidden="true">
					<circle class="pomo-clock__track" cx="120" cy="120" r="110"></circle>
					<circle class="pomo-clock__progress" id="pomo-ring" cx="120" cy="120" r="110"></circle>
				</svg>
				<div class="pomo-clock__readout">
					<div class="pomo-clock__time" id="pomodoro-time" role="timer">25:00</div>
					<div class="pomo-clock__label" id="pomodoro-mode"><?php _e('Focus', 'sis-foca-js'); ?></div>
				</div>
			</div>
			<input type="text" disabled="disabled" id="secondsRemaining_box" hidden>

			<form onsubmit="return false;">
				<input type="button"
					value="<?php _e('loading', 'sis-foca-js'); ?>..."
					id="action_button_id"
					tabindex="1"
					disabled="true" />
			</form>

			<ul id="pomolist">
				<li class="pomoindi" id="pomoindi1">1</li>
				<li class="pomoindi" id="pomoindi2">2</li>
				<li class="pomoindi" id="pomoindi3">3</li>
				<li class="pomoindi" id="pomoindi4">4</li>
			</ul>

			<div class="pomo-timer__controls">
				<button type="button" onclick="reset_pomodoro_session()" class="btn-round"
					title="<?php _e('Reset session', 'sis-foca-js'); ?>"
					aria-label="<?php _e('Reset session', 'sis-foca-js'); ?>">
					<span class="fas fa-arrows-rotate" aria-hidden="true"></span>
				</button>
				<button type="button" onclick="set_continuous_session()" id="resetter_btn" class="btn-round"
					title="<?php _e('Continuous session', 'sis-foca-js'); ?>"
					aria-label="<?php _e('Continuous session', 'sis-foca-js'); ?>">
					<span class="fas fa-forward" aria-hidden="true"></span>
				</button>
				<button type="button" class="pomo-notify js-pomo-notify"
					title="<?php _e('Enable notifications', 'sis-foca-js'); ?>">
					<span class="fas fa-bell" aria-hidden="true"></span>
					<span class="js-pomo-notify-label"><?php _e('Enable notifications', 'sis-foca-js'); ?></span>
				</button>
			</div>
		</section>

		<div class="pomo-tabs" role="tablist">
			<button type="button" class="pomo-tab is-active" data-pomo-tab="profile" role="tab" aria-selected="true">
				<span class="fas fa-stopwatch" aria-hidden="true"></span> <?php _e('Pomodoro', 'sis-foca-js'); ?>
			</button>
			<button type="button" class="pomo-tab" data-pomo-tab="buzz" role="tab" aria-selected="false">
				<span class="fas fa-list" aria-hidden="true"></span> <?php _e('Tasks', 'sis-foca-js'); ?>
			</button>
		</div>

		<div id="tab-focus" class="pomo-panels">
			<section class="pomo-panel is-active" id="profile" role="tabpanel">
				<form name="pomopainel" id="pomopainel" class="pomo-card">
					<div class="form-group">
						<label for="title_box"><span class="fas fa-paste" aria-hidden="true"></span> <?php _e('Task', 'sis-foca-js'); ?></label>
						<input type="text" id="title_box" maxlength="70" tabindex="2" name="ti33" class="form-control">
					</div>
					<div class="form-group">
						<label for="tags_box"><span class="fas fa-tags" aria-hidden="true"></span> <?php _e('Project tags', 'sis-foca-js'); ?></label>
						<select id="tags_box" multiple="multiple" tabindex="3" data-placeholder="<?php _e('project1, project2', 'sis-foca-js'); ?>"></select>
					</div>
					<div class="form-group">
						<label for="description_box"><span class="fas fa-note-sticky" aria-hidden="true"></span> <?php _e('Notes', 'sis-foca-js'); ?></label>
						<textarea rows="2" id="description_box" tabindex="4" class="form-control"></textarea>
					</div>

					<label><span class="fas fa-paperclip" aria-hidden="true"></span> <?php _e('What kind of task is that?', 'sis-foca-js'); ?></label>
					<ul>
						<li><input type="radio" name="cat_vl" value="27" CHECKED> <?php _e('Work', 'sis-foca-js'); ?></li>
						<li><input type="radio" name="cat_vl" value="26"> <?php _e('Study', 'sis-foca-js'); ?></li>
						<li><input type="radio" name="cat_vl" value="28"> <?php _e('Personal', 'sis-foca-js'); ?></li>
					</ul>
					<label><span class="fas fa-eye" aria-hidden="true"></span> <?php _e('Privacy', 'sis-foca-js'); ?></label>
					<ul>
						<li><input type="radio" name="priv_vl" value="publish" CHECKED> <?php _e('Public', 'sis-foca-js'); ?></li>
						<li><input type="radio" name="priv_vl" value="private"> <?php _e('Private', 'sis-foca-js'); ?></li>
					</ul>

					<button type="button" class="btn btn-dark btn-darkness" id="botao-salvar-modelo">
						<span class="fas fa-save" aria-hidden="true"></span> <?php _e('Save Task', 'sis-foca-js'); ?>
					</button>
					<input type="hidden" id="data_box">
					<input type="hidden" id="status_box">
					<input type="hidden" id="post_id_box">
					<input type="hidden" id="pomodoroAtivoBox" value='<?php echo esc_attr(get_user_meta(get_current_user_id(), "pomodoroAtivo", true)); ?>'>
				</form>
			</section>

			<section class="pomo-panel" id="buzz" role="tabpanel">
				<div class="pomo-card">
					<div id="auto_cicler">
						<label><span class="fas fa-arrows-spin" aria-hidden="true"></span> <?php _e('Automatic cycle', 'sis-foca-js'); ?></label>
						<div>
							<button type="button" id="cycle_start" title="<?php _e('Start cycler', 'sis-foca-js'); ?>"><span class="fas fa-play" aria-hidden="true"></span></button>
							<button type="button" id="cycle_prev" title="<?php _e('Previous task', 'sis-foca-js'); ?>"><span class="fas fa-backward" aria-hidden="true"></span></button>
							<button type="button" id="cycle_next" title="<?php _e('Next task', 'sis-foca-js'); ?>"><span class="fas fa-forward" aria-hidden="true"></span></button>
							<button type="button" id="cycle_empty" title="<?php _e('Clear cycler', 'sis-foca-js'); ?>"><span class="fas fa-trash" aria-hidden="true"></span></button>
						</div>
						<p><small><?php _e('Drop tasks below', 'sis-foca-js'); ?></small></p>
						<ul id="contem-ciclo">
							<?php echo get_user_meta(get_current_user_id(), "cycle_list", true); ?>
						</ul>
					</div>

					<label style="display:block;margin-top:18px;"><span class="fas fa-list" aria-hidden="true"></span> <?php _e('TODO list', 'sis-foca-js'); ?></label>
					<ul id="contem-modelos">
						<?php
						$args = array(
							'post_type' => 'projectimer_focus',
							'post_status' => 'pending',
							'author' => get_current_user_id(),
							'order' => 'ASC',
							'posts_per_page' => -1,
						);
						$the_query = new WP_Query($args);

						while ($the_query->have_posts()) : $the_query->the_post();
							$counter = $post->ID;
							$taglist = "";
							$posttags = get_the_tags();
							if ($posttags) {
								$i = 1;
								$c = count($posttags);
								foreach ($posttags as $tag) {
									if ($i < $c) {
										$taglist .= "<span class='fas fa-tags' aria-hidden='true'></span>" . $tag->slug . ", ";
									} else {
										$taglist .= "<span class='fas fa-tags' aria-hidden='true'></span>" . $tag->slug . " ";
									}
									$i++;
								}
							}
							?>
							<li class="modelo-carregado" id="modelo-carregado-<?php echo $counter; ?>">
								<div class="model-container" data-modelid="<?php echo $counter ?>">
									<span class="fas fa-move" aria-hidden="true"></span>
									<?php echo '<span id="bxtitle' . $counter . '">' . esc_html(get_the_title()) . "</span>"; ?>
									<span id="bxtag<?php echo $counter; ?>" hidden><?php echo wp_kses_post($taglist); ?></span>
								</div>
								<div class="model-container-extra">
									<button type="button" class="btn btn-xs btn-success delete-task-model-btn" data-modelid="<?php echo $counter ?>"><span class="fas fa-check"></span></button>
									<button type="button" class="btn btn-xs btn-none remove-task-from-list-btn" data-modelid="<?php echo $counter ?>"><span class="fas fa-trash" style="color:black"></span></button>
								</div>
							</li>
						<?php endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</section>
		</div>
	</div>
