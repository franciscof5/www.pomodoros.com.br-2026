<?php global $user_prefered_language_prefix; ?>
<!DOCTYPE html>

<head lang="<?php echo isset($user_prefered_language) ? $user_prefered_language : 'pt_BR'; ?>">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<?php
    // from plugin f5sites-smart language
    global $title_apendix;
    ?>
	<title>Pomodoros
		<?php echo $title_apendix;
        wp_title(); ?>
	</title>

	<?php do_action('bp_head') ?>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<?php if (function_exists('bp_sitewide_activity_feed_link')): ?>
		<link rel="alternate" type="application/rss+xml"
			title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress') ?>"
			href="<?php bp_sitewide_activity_feed_link() ?>" />
	<?php endif; ?>

	<?php if (function_exists('bp_member_activity_feed_link') && bp_is_user()): ?>
		<link rel="alternate" type="application/rss+xml"
			title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e('Activity RSS Feed', 'buddypress') ?>"
			href="<?php bp_member_activity_feed_link() ?>" />
	<?php endif; ?>

	<?php if (function_exists('bp_group_activity_feed_link') && bp_is_group()): ?>
		<link rel="alternate" type="application/rss+xml"
			title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e('Group Activity RSS Feed', 'buddypress') ?>"
			href="<?php bp_group_activity_feed_link() ?>" />
	<?php endif; ?>

	<link rel="alternate" type="application/rss+xml"
		title="<?php bloginfo('name'); ?> <?php _e('Blog Posts RSS Feed', 'buddypress') ?>"
		href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="alternate" type="application/atom+xml"
		title="<?php bloginfo('name'); ?> <?php _e('Blog Posts Atom Feed', 'buddypress') ?>"
		href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!--link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet'-->
	<?php wp_head(); ?>

	<meta name="viewport" content="width=device-width, user-scalable=no">
</head>


<body <?php ?>>

	<?php do_action('bp_before_header') ?>

	<div id="main-cotainer-app" class="main-cotainer-app container-fluid content">

		<nav class="navbar navbar-dark">
			<a class="navbar-brand" title="<?php _e('Go to Pomodoros Blog', 'sis-foca-js'); ?>" href="/">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" id="pomodoros-topo"
					alt="Pomodoros">
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsePommoNabar"
				aria-controls="collapsePommoNabar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="collapsePommoNabar">
				<ul class="pomoNavbar">

					<span class="pomoNavbar-right icones-celular">
						<?php if (!is_user_logged_in()) { ?>
							<li>
								<a title="<?php _e('Login', 'sis-foca-js'); ?>"
									class="btn btn-transparent-dark btn-xs btn-expand abrir_login" id="login_login"
									tabindex="1">
										<?php _e('Login', 'sis-foca-js'); ?>
								</a>
							</li>
							<li>
								<a href="/register" class="btn btn-success btn-xs btn-expand " role="button"
									aria-pressed="true"
									title="<?php _e('Create your free pomodoros.com.br account', 'sis-foca-js'); ?>">
										<?php _e('Sign Up', 'sis-foca-js'); ?>
								</a>
							</li>
						<?php } else { ?>
							<span class="icones-celular">
								<li>
									<a title="<?php _e('Start Focus', 'sis-foca-js'); ?>"
										href="<?php bloginfo('url'); ?>/focus/"
										class="btn btn-transparent-blue btn-xs btn-expand">
										<span class="fas fa-stopwatch" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Focus', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('View Productivity', 'sis-foca-js'); ?>" href="<?php bloginfo('url'); ?>/users/<?php $current_user = wp_get_current_user();
    echo $current_user->user_login ?>" class="btn btn-transparent-blue btn-xs btn-expand">
										<span class="fas fa-chart-line" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											Stats
											<?php // _e("Productivity", "sis-foca-js"); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('Colleagues list', 'sis-foca-js'); ?>"
										href="<?php bloginfo('url'); ?>/users/" alt="Amigos"
										class="btn btn-transparent-blue btn-xs btn-expand">
										<span class="fas fa-users" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Colleagues', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('View the most productive users Ranking', 'sis-foca-js'); ?>"
										href="<?php bloginfo('url'); ?>/ranking/"
										class="btn btn-transparent-blue btn-xs btn-expand">
										<span class="fas fa-sort-amount-up" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Ranking', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('Perfomance Calendar', 'sis-foca-js'); ?>"
										href="<?php bloginfo('url'); ?>/calendar/"
										class="btn btn-transparent-blue btn-xs btn-expand">
										<span class="fas fa-calendar-alt" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Calendar', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('View your account', 'sis-foca-js'); ?>"
										class="btn btn-transparent-blue btn-xs btn-expand" href="<?php bloginfo('url'); ?>/users/<?php $current_user = wp_get_current_user();
    echo $current_user->user_login ?>/settings">
										<span class="fas fa-user-circle" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											Conta
											<?php // _e("My Acount", "sis-foca-js"); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('Open support ticket', 'sis-foca-js'); ?>"
										class="btn btn-transparent-blue btn-xs btn-expand"
										href="<?php bloginfo('url'); ?>/help">
										<span class="fas fa-envelope-open" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Support', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('Settings', 'sis-foca-js'); ?>"
										class="btn btn-transparent-blue btn-xs btn-expand abrir_settings" href="#">
										<span class="fas fa-gear" aria-hidden="true"></span><span
											class="d-none d-xs-block d-sm-block icon-leg">
											Config.
											<?php // _e("Settings", "sis-foca-js"); ?>
										</span>
									</a>
								</li>

								<li>
									<a title="<?php _e('Focus Training', 'sis-foca-js'); ?>"
										class="btn btn-transparent-blue btn-xs btn-expand"
										href="<?php bloginfo('url'); ?>/focus-training">
										<span class="fas fa-graduation-cap" aria-hidden="true"></span><span
											class="d-none d-xs-block d-sm-block icon-leg">
											Palestra
											<?php // _e("Focus Training", "sis-foca-js"); ?>
										</span>
									</a>
								</li>
								<li>
									<a title="<?php _e('Logout', 'sis-foca-js'); ?>"
										class="btn btn-transparent-red btn-xs btn-expand"
										href="<?php echo wp_logout_url(); ?>">
										<span class="fas fa-sign-out-alt" aria-hidden="true"></span>
										<span class="d-none d-xs-block d-sm-block icon-leg">
											<?php _e('Logout', 'sis-foca-js'); ?>
										</span>
									</a>
								</li>
							</span>
						<?php } ?>
					</span>
				<ul>

			</div>
			<!--/div-->
		</nav>

		
		<?php if (!is_user_logged_in()) { ?>
			<div id="loginlogbox">
				<?php wp_login_form(); ?>
				<div style="margin-top:-10px;">
					<?php do_action('wordpress_social_login'); ?>
					<div style="margin-top: -40px;">
						<?php do_action('bp_after_sidebar_login_form'); ?>
					</div>
				</div>
			</div>
		<?php } ?>
		
		<div id="settingsbox" class="row">
			<h2 class="forte">
				<span class="fas fa-cog" aria-hidden="true"></span><?php _e('Settings', 'sis-foca-js'); ?>
			</h2>

			<h3><span class="fas fa-volume-up" aria-hidden="true"></span> <?php _e('Volume', 'sis-foca-js'); ?></h3>			
			<div class="row">
				<!-- <div class="col-1">
					<span class="fas fa-volume-up" aria-hidden="true"></span>
				</div> -->
				<div class="col-12">
					<input type="range" id="rangeVolume" style="100%">
				</div>
				<!-- <div class="col-1">
					<span class="fas fa-volume-up" aria-hidden="true"></span>
				</div> -->
			</div>
			<h3>Sound options</h3>
			<div class="row">
				<div class="col-8">
					<p>Sound FX</p>
				</div>
				<div class="col-4">
					<input style="float:right" id="soundfx_enabled" name="someSwitchOption001" type="checkbox" checked="checked">
					<!-- <div class="material-switch pull-right" style="float: right;">
						<input id="soundfx_enabled" name="someSwitchOption001" type="checkbox" checked="checked" />
						<label for="sound-switcher" class="label-success"></label>
					</div> -->
				</div>
			</div>

			<div class="row">
				<div class="col-8">
					<p><?php _e('Voice', 'sis-foca-js'); ?></p>
				</div>
				<div class="col-4">
					<input style="float:right" id="voice_enabled" name="someSwitchOption002" type="checkbox" checked="checked">
					<!--div class="material-switch pull-right" style="float: right;">
					<input id="voice_enabled" name="someSwitchOption002" type="checkbox" checked="checked" />
					<label for="voice-switcher" class="label-success"></label>
				</div-->
				</div>
			</div>
			<hr />
			<?php if (function_exists('smartlang_show_lang_options')) { ?>
				<h3>Change Language</h3>
				<div class="">
					<p><?php smartlang_show_lang_options(true); ?></p>
				</div>
			<?php } ?>
			<?php if (bp_is_active('messages')) { ?>
				<div class="">
					<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
				</div>
			<?php } ?>
			<h3><?php _e('Export Calendar', 'sis-foca-js'); ?> (iCal)</h3>
			<div class="">
				<p class="Tahoma"><?php _e('See your pomodoros in the calendars of Google, Apple, Microsoft and others.', 'sis-foca-js'); // Veja seus pomodoros nos calendários da Google, Apple, Microsoft e outros. ?></p>
				<p><a href="/calendar" class="btn btn-primary" style="text-transform: uppercase;"><?php _e('Export Calendar', 'sis-foca-js'); ?></a></p>
			</div>
			<h3><?php _e('Export Worksheet', 'sis-foca-js'); // Exportar Planilha ?></h3>
			<div class="">
				<p class="Tahoma"><?php _e('Have control over your data, view your pomodoros in Microsoft Excel, LibreOffice Calc and others', 'sis-foca-js'); // Tenha controle sobre seus dados, visualize seus pomodoros no Microsoft Excel, LibreOffice Calc e outros ?></p>
				<p><a href="/csv" class="btn btn-primary" style="text-transform: uppercase;"><?php _e('Export Worksheet', 'sis-foca-js'); ?></a></p>
			</div>
		</div>

		<?php do_action('bp_header') ?>


		<?php do_action('bp_after_header') ?>
		<?php do_action('bp_before_container') ?>



		<!--  -->