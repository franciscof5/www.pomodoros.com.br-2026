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
	<script src="https://unpkg.com/@tailwindcss/browser@4"></script>
	<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

</head>


<body <?php ?>>
	<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50" x-data="{ open: false, mobileMenuOpen: false }">
		<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
			<div class="relative flex h-16 items-center justify-between">
				<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
					<!-- Botão para abrir o menu mobile-->
					<button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset" aria-controls="mobile-menu" aria-expanded="false">
						<span class="absolute -inset-0.5"></span>
						<span class="sr-only">Abrir menu principal</span>
						<svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
						</svg>
					</button>
				</div>
				<div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
					<div class="flex shrink-0 items-center">
						<img class="h-8 w-auto" src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" alt="Seu site">
					</div>
					<div class="hidden sm:ml-6 sm:block">
						<div class="flex space-x-4">
							<a href="#funcionalidades" class="rounded-md px-3 py-2 text-sm font-medium text-white" aria-current="page">Funcionalidades</a>
							<a href="#comunidades" class="rounded-md px-3 py-2 text-sm font-medium text-white" aria-current="page">Comunidade</a>
							<a href="#historico" class="rounded-md px-3 py-2 text-sm font-medium text-white" aria-current="page">Histórico</a>
							<a href="#depoimentos" class="rounded-md px-3 py-2 text-sm font-medium text-white" aria-current="page">Depoimentos</a>
						</div>
					</div>
				</div>
				<!-- Dropdown de usuário -->
				<div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
					<?php if (!is_user_logged_in()) { ?> 
						<!-- <a class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white" title="Login" href="/focus">Login</a> -->
						<a class="inline-block bg-green-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300" href="/register" title="Create your free pomodoros.com.br account">🚀 Registre-se Grátis</a>
						
					<?php } else { ?>
						<a class="rounded-md bg-purple-700 px-3 py-2 text-sm font-medium text-white" title="Focus" href="/focus/">
							<span class="fas fa-stopwatch" aria-hidden="true"></span>
							Focar
						</a>
					<?php } ?>
					<!-- <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
						<span class="absolute -inset-1.5"></span>
						<span class="sr-only">Ver notificações</span>
						<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
						</svg>
					</button> -->
				</div>
			</div>
		</div>

		<!-- Menu Mobile, exibe/oculta com base no estado de mobileMenuOpen -->
		<div x-show="mobileMenuOpen" x-transition class="sm:hidden" id="mobile-menu">
			<div class="space-y-1 px-2 pt-2 pb-3">
				<a href="#funcionalidades" class="block w-full rounded-md rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Funcionalidades</a>
				<a href="#comunidades" class="block w-full rounded-md rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Comunidade</a>
				<a href="#historico" class="block w-full rounded-md rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Histórico</a>
				<a href="#depoimentos" class="block w-full rounded-md rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Depoimentos</a>
				<!-- Dropdown de Projetos para Mobile
				<div x-data="{ open: false }" class="relative">
					<button @click="open = !open" class="block w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-purple-700">Projetos</button>
					<div x-show="open" x-transition @click.away="open = false" class="mt-2 w-full rounded-md bg-gray-700 shadow-lg z-10" x-cloak>
						<a href="#" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-600">Submenu Item 1</a>
						<a href="#" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-600">Submenu Item 2</a>
					</div>
				</div> -->
			</div>
		</div>
	</nav>

	<?php do_action('bp_before_header') ?>

	<div id="main-cotainer" class="container-fluid content">

		<?php do_action('bp_header') ?>
		<?php do_action('bp_after_header') ?>
		<?php do_action('bp_before_container') ?>

<?php /*
<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50" x-data="{ open: false, mobileMenuOpen: false }">
		<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
			<div class="relative flex h-16 items-center justify-between">
				<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
					<!-- Botão para abrir o menu mobile-->
					<button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset" aria-controls="mobile-menu" aria-expanded="false">
						<span class="absolute -inset-0.5"></span>
						<span class="sr-only">Abrir menu principal</span>
						<svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
						</svg>
					</button>
				</div>
				<div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
					<div class="flex shrink-0 items-center">
						<img class="h-8 w-auto" src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" alt="Seu site">
					</div>
					<div class="hidden sm:ml-6 sm:block">
						<div class="flex space-x-4">
							<a href="#funcionalidades" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Funcionalidades</a>
							<a href="#comunidades" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Comunidade</a>
							<a href="#historico" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Histórico</a>
							<a href="#depoimentos" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white" aria-current="page">Depoimentos</a>
						</div>
					</div>
				</div>
				<!-- Dropdown de usuário -->
				<div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
					<button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
						<span class="absolute -inset-1.5"></span>
						<span class="sr-only">Ver notificações</span>
						<svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
						</svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Menu Mobile, exibe/oculta com base no estado de mobileMenuOpen -->
		<div x-show="mobileMenuOpen" x-transition class="sm:hidden" id="mobile-menu">
			<div class="space-y-1 px-2 pt-2 pb-3">
				<a href="#" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>
				<a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
				<a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
				<!-- Dropdown de Projetos para Mobile -->
				<div x-data="{ open: false }" class="relative">
					<button @click="open = !open" class="block w-full rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projetos</button>
					<div x-show="open" x-transition @click.away="open = false" class="mt-2 w-full rounded-md bg-gray-700 shadow-lg z-10" x-cloak>
						<a href="#" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-600">Submenu Item 1</a>
						<a href="#" class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-600">Submenu Item 2</a>
					</div>
				</div>
			</div>
		</div>
	</nav>


	<div id="menu" class="container-fluid">
		<div class="row justify-content-between">
			<div class="contem-logo">
				<a title="Home" href="">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" alt="Pomodoros">
				</a>
			</div>
			<div>
				<a class="" title="Funcionalidades" tabindex="1">
					<span>Funcionalidades</span>
				</a>
				<a class="" title="Preço" tabindex="1">
					<span>Preço</span>
				</a>
				<a class="" title="Porque usar Pomodoros.com.br" tabindex="1">
					<span>Porque usar</span>
				</a>
			</div>
			<div>
				<?php if (!is_user_logged_in()) { ?> 
					<a class="abrir_login btn-black" title="Login" tabindex="1">
						<span>Login</span>
					</a>
					<a href="/register" class="btn-success" role="button" aria-pressed="true" title="Create your free pomodoros.com.br account">
						<span>Free Signup</span>
					</a>
				<?php } else { ?>
					<a class="" style="background:#9d3f72" title="Focus" href="/focus/">
						<span class="fas fa-stopwatch" aria-hidden="true"></span>
						Focus
					</a>
				<?php } ?>
			</div>
		</div>
	</div>

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
					<?php bp_message_get_notices();?>
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
*/ ?>
	