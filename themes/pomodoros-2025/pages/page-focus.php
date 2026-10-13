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

if ( ! function_exists( 'pomo_arc_path' ) ) {
	/**
	 * Build an SVG arc path for a ring.
	 * Angles in degrees: 0 = top (12h), positive = clockwise.
	 */
	function pomo_arc_path( $cx, $cy, $r, $start_deg, $end_deg ) {
		$point = function ( $deg ) use ( $cx, $cy, $r ) {
			$rad = deg2rad( $deg - 90 );
			return array( $cx + $r * cos( $rad ), $cy + $r * sin( $rad ) );
		};
		list( $x1, $y1 ) = $point( $start_deg );
		list( $x2, $y2 ) = $point( $end_deg );
		$delta = $end_deg - $start_deg;
		$large = abs( $delta ) > 180 ? 1 : 0;
		$sweep = $delta >= 0 ? 1 : 0;
		return sprintf(
			'M %.3f %.3f A %.3f %.3f 0 %d %d %.3f %.3f',
			$x1, $y1, $r, $r, $large, $sweep, $x2, $y2
		);
	}
}

// Session ring geometry (4 pomodoros; time runs counterclockwise).
$pomo_cx    = 130;
$pomo_cy    = 130;
$pomo_r_out = 120;
$pomo_r_in  = 100;
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
				<svg class="pomo-clock__ring" viewBox="0 0 260 260" aria-hidden="true">
					<!-- Outer session ring: 4 pomodoros, each = 25min focus (green) + 5min rest (orange).
					     Progress runs counterclockwise, so segments go from the top into negative angles. -->
					<circle class="pomo-session__track" cx="<?php echo $pomo_cx; ?>" cy="<?php echo $pomo_cy; ?>" r="<?php echo $pomo_r_out; ?>"></circle>
					<?php for ( $pomo_q = 0; $pomo_q < 4; $pomo_q++ ) :
						$pomo_start = -$pomo_q * 90;
						$pomo_focus_end = $pomo_start - 75;
						$pomo_rest_end  = $pomo_start - 90;
					?>
						<path class="pomo-session__seg pomo-session__seg--focus"
							data-a1="<?php echo esc_attr( $pomo_start ); ?>"
							data-a2="<?php echo esc_attr( $pomo_focus_end ); ?>"
							d="<?php echo esc_attr( pomo_arc_path( $pomo_cx, $pomo_cy, $pomo_r_out, $pomo_start, $pomo_focus_end ) ); ?>"></path>
						<path class="pomo-session__seg pomo-session__seg--rest"
							data-a1="<?php echo esc_attr( $pomo_focus_end ); ?>"
							data-a2="<?php echo esc_attr( $pomo_rest_end ); ?>"
							d="<?php echo esc_attr( pomo_arc_path( $pomo_cx, $pomo_cy, $pomo_r_out, $pomo_focus_end, $pomo_rest_end ) ); ?>"></path>
					<?php endfor; ?>
					<circle class="pomo-session__marker" id="pomo-session-marker" cx="<?php echo $pomo_cx; ?>" cy="<?php echo ( $pomo_cy - $pomo_r_out ); ?>" r="5"></circle>
					<!-- Inner ring: current pomodoro countdown (clockwise). -->
					<circle class="pomo-clock__track" cx="<?php echo $pomo_cx; ?>" cy="<?php echo $pomo_cy; ?>" r="<?php echo $pomo_r_in; ?>"></circle>
					<circle class="pomo-clock__progress" id="pomo-ring" cx="<?php echo $pomo_cx; ?>" cy="<?php echo $pomo_cy; ?>" r="<?php echo $pomo_r_in; ?>" transform="rotate(-90 <?php echo $pomo_cx; ?> <?php echo $pomo_cy; ?>) translate(0,260) scale(1,-1)"></circle>
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
				<div class="pomo-card pomo-tasks">
					<div id="auto_cicler" class="pomo-tasks__block">
						<div class="pomo-tasks__head">
							<h3 class="pomo-tasks__title">
								<span class="fas fa-arrows-spin" aria-hidden="true"></span>
								<?php _e('Automatic cycle', 'sis-foca-js'); ?>
							</h3>
							<span class="pomo-tasks__count" id="pomo-cycle-count">0</span>
							<div class="pomo-tasks__actions">
								<button type="button" id="cycle_start" title="<?php esc_attr_e('Start cycler', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Start cycler', 'sis-foca-js'); ?>"><span class="fas fa-play" aria-hidden="true"></span></button>
								<button type="button" id="cycle_prev" title="<?php esc_attr_e('Previous task', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Previous task', 'sis-foca-js'); ?>"><span class="fas fa-backward" aria-hidden="true"></span></button>
								<button type="button" id="cycle_next" title="<?php esc_attr_e('Next task', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Next task', 'sis-foca-js'); ?>"><span class="fas fa-forward" aria-hidden="true"></span></button>
								<button type="button" id="cycle_empty" title="<?php esc_attr_e('Clear cycler', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Clear cycler', 'sis-foca-js'); ?>"><span class="fas fa-trash" aria-hidden="true"></span></button>
							</div>
						</div>
						<ul id="contem-ciclo" data-empty="<?php esc_attr_e('Drag tasks here to build an automatic cycle', 'sis-foca-js'); ?>">
							<?php echo get_user_meta(get_current_user_id(), "cycle_list", true); ?>
						</ul>
					</div>

					<div class="pomo-tasks__block">
						<div class="pomo-tasks__head">
							<h3 class="pomo-tasks__title">
								<span class="fas fa-list-check" aria-hidden="true"></span>
								<?php _e('TODO list', 'sis-foca-js'); ?>
							</h3>
							<span class="pomo-tasks__count" id="pomo-todo-count">0</span>
						</div>
						<ul id="contem-modelos" data-empty="<?php esc_attr_e('No tasks yet. Create one on the left.', 'sis-foca-js'); ?>">
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
								$tags_plain = "";
								$tags_html = "";
								$posttags = get_the_tags();
								if ($posttags) {
									$slugs = array();
									foreach ($posttags as $tag) {
										$slugs[] = $tag->slug;
									}
									$tags_plain = implode(", ", $slugs);
									foreach ($slugs as $slug) {
										$tags_html .= '<span class="pomo-task__tag"><span class="fas fa-tags" aria-hidden="true"></span>' . esc_html($slug) . '</span>';
									}
								}
								?>
								<li class="modelo-carregado" id="modelo-carregado-<?php echo $counter; ?>">
									<div class="model-container" data-modelid="<?php echo $counter ?>">
										<span class="pomo-task__handle fas fa-grip-vertical" aria-hidden="true"></span>
										<div class="pomo-task__body">
											<span class="pomo-task__title" id="bxtitle<?php echo $counter; ?>"><?php echo esc_html(get_the_title()); ?></span>
											<?php if ($tags_html) : ?>
												<span class="pomo-task__tags"><?php echo $tags_html; ?></span>
											<?php endif; ?>
											<span id="bxtag<?php echo $counter; ?>" hidden><?php echo esc_html($tags_plain); ?></span>
										</div>
									</div>
									<div class="model-container-extra">
										<button type="button" class="delete-task-model-btn" data-modelid="<?php echo $counter ?>" title="<?php esc_attr_e('Mark as done', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Mark as done', 'sis-foca-js'); ?>"><span class="fas fa-check"></span></button>
										<button type="button" class="remove-task-from-list-btn" data-modelid="<?php echo $counter ?>" title="<?php esc_attr_e('Remove from list', 'sis-foca-js'); ?>" aria-label="<?php esc_attr_e('Remove from list', 'sis-foca-js'); ?>"><span class="fas fa-trash"></span></button>
									</div>
								</li>
							<?php endwhile;
							wp_reset_postdata();
							?>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</div>
