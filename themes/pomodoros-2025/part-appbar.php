<?php
/**
 * Shared modern app bar for every app page.
 *
 * Rendered by header-app.php (and available to other shells via
 * get_template_part('part', 'appbar')). Marks the current route and
 * exposes login/settings/logout actions used by pomodoro/focus-ui.js.
 */

$pomo_custom_page = get_query_var('custom_page');
$pomo_logged_in   = is_user_logged_in();
$pomo_user        = wp_get_current_user();
$pomo_theme_uri   = get_stylesheet_directory_uri();
$pomo_home        = home_url('/');

$pomo_is = function ($page) use ($pomo_custom_page) {
	return $pomo_custom_page === $page ? ' is-current' : '';
};
?>
<header class="pomo-appbar">
	<a class="pomo-appbar__brand" href="<?php echo esc_url($pomo_home); ?>"
		title="<?php _e('Go to Pomodoros Blog', 'sis-foca-js'); ?>">
		<img src="<?php echo $pomo_theme_uri; ?>/images/pomodoro-logo-topo.png" alt="Pomodoros">
	</a>

	<button type="button" class="pomo-appbar__toggle" aria-label="<?php _e('Menu', 'sis-foca-js'); ?>">
		<span class="fas fa-bars" aria-hidden="true"></span>
	</button>

	<nav class="pomo-appbar__nav" aria-label="<?php _e('Main navigation', 'sis-foca-js'); ?>">
		<a class="pomo-appbar__link<?php echo $pomo_is('focus'); ?>" href="<?php echo esc_url($pomo_home); ?>focus/">
			<span class="fas fa-stopwatch" aria-hidden="true"></span> <?php _e('Focus', 'sis-foca-js'); ?>
		</a>
		<a class="pomo-appbar__link<?php echo $pomo_is('ranking'); ?>" href="<?php echo esc_url($pomo_home); ?>ranking/">
			<span class="fas fa-sort-amount-up" aria-hidden="true"></span> <?php _e('Ranking', 'sis-foca-js'); ?>
		</a>
		<a class="pomo-appbar__link<?php echo $pomo_is('calendar'); ?>" href="<?php echo esc_url($pomo_home); ?>calendar/">
			<span class="fas fa-calendar-alt" aria-hidden="true"></span> <?php _e('Calendar', 'sis-foca-js'); ?>
		</a>
		<a class="pomo-appbar__link" href="<?php echo esc_url($pomo_home); ?>users/">
			<span class="fas fa-users" aria-hidden="true"></span> <?php _e('Colleagues', 'sis-foca-js'); ?>
		</a>
		<?php if ($pomo_logged_in) { ?>
			<a class="pomo-appbar__link" href="<?php echo esc_url($pomo_home); ?>users/<?php echo esc_attr($pomo_user->user_login); ?>">
				<span class="fas fa-chart-line" aria-hidden="true"></span> Stats
			</a>
			<a class="pomo-appbar__link<?php echo $pomo_is('help'); ?>" href="<?php echo esc_url($pomo_home); ?>help">
				<span class="fas fa-life-ring" aria-hidden="true"></span> <?php _e('Support', 'sis-foca-js'); ?>
			</a>
			<a class="pomo-appbar__link js-pomo-settings" href="#">
				<span class="fas fa-gear" aria-hidden="true"></span> <?php _e('Settings', 'sis-foca-js'); ?>
			</a>
			<a class="pomo-appbar__link pomo-appbar__link--danger" href="<?php echo wp_logout_url(); ?>">
				<span class="fas fa-sign-out-alt" aria-hidden="true"></span> <?php _e('Logout', 'sis-foca-js'); ?>
			</a>
		<?php } else { ?>
			<a class="pomo-appbar__link abrir_login" href="#">
				<span class="fas fa-right-to-bracket" aria-hidden="true"></span> <?php _e('Login', 'sis-foca-js'); ?>
			</a>
			<a class="pomo-appbar__link" href="<?php echo esc_url($pomo_home); ?>register">
				<span class="fas fa-user-plus" aria-hidden="true"></span> <?php _e('Sign Up', 'sis-foca-js'); ?>
			</a>
		<?php } ?>
	</nav>
</header>
