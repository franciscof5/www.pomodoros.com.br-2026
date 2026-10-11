<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Mobile', 'sis-foca-js'); ?>";
</script>

<div class="bg-gray-900 text-gray-100 min-h-screen pt-24 pb-16">
	<div class="mx-auto max-w-md px-4 sm:px-6">
		<?php if (is_user_logged_in()) { ?>
			<script>
				window.location = "https://www.pomodoros.com.br/focus";
			</script>
		<?php } ?>

		<header class="mb-8 text-center">
			<h1 class="text-2xl sm:text-3xl font-bold text-white"><?php _e("Pomodoros Mobile", "sis-foca-js"); ?></h1>
			<p class="mt-2 text-sm text-amber-300"><?php _e("Login to access the app", "sis-foca-js"); ?></p>
		</header>

		<div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8">
			<?php wp_login_form(); ?>
			<div class="mt-4">
				<?php do_action('wordpress_social_login'); ?>
			</div>
		</div>

		<?php if (function_exists("show_lang_options")) { ?>
			<div class="mt-6 text-center text-gray-400"><?php show_lang_options(); ?></div>
		<?php } ?>

		<div class="mt-8 text-center">
			<?php echo show_sponsor("onlythumb"); ?>
		</div>
	</div>
</div>
