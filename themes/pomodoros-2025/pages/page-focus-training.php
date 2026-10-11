<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Exclusive Content', 'sis-foca-js'); ?>";
</script>

<div class="bg-gray-900 text-gray-100 min-h-screen pt-24 pb-16">
	<div class="mx-auto max-w-3xl px-4 sm:px-6">
		<header class="mb-8 text-center">
			<h1 class="flex items-center justify-center gap-3 text-2xl sm:text-3xl font-bold text-white">
				<i class="fas fa-graduation-cap" aria-hidden="true"></i> <?php _e("Focus Training", "sis-foca-js"); ?>
			</h1>
		</header>

		<div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 space-y-5">
			<p class="text-gray-300 leading-relaxed">
				<?php _e("Pomodoros.com.br has been online since 2011, and Francisco Matelli Matulovic, founder, has been using the Pomodoro Technique and many other time management practices since 2007. With his management degree, master's course plus personal experience in time management, he developed an exclusive course.", "sis-foca-js"); ?>
			</p>

			<a class="block bg-green-900/40 border border-green-700/60 rounded-2xl p-4 text-center hover:bg-green-900/60 transition"
				href="https://www.treinamentoemfoco.com.br">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banners/treinamentoemfoco.jpg"
					id="pomodoros-banner" alt="Treinamento em Foco" class="w-full rounded-xl mb-3">
				<span class="font-semibold text-green-300">
					<?php _e("Focus Training", "sis-foca-js"); ?>: <?php _e("Be more productive", "sis-foca-js"); ?>
				</span>
			</a>

			<p class="text-gray-300 leading-relaxed">
				<?php _e("Francisco says that after many years of helping people and keeping Pomodoros online, he decided to open the exclusive course to get even more involved with site users, students and professionals that want to get the most of their time.", "sis-foca-js"); ?>
			</p>
		</div>
	</div>
</div>
