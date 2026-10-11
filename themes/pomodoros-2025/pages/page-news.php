<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Blog', 'sis-foca-js'); ?>";
</script>

<div class="bg-gray-900 text-gray-100 min-h-screen pt-24 pb-16">
	<div class="mx-auto max-w-3xl px-4 sm:px-6">
		<?php if (function_exists("show_welcome_message")) show_welcome_message(true); ?>

		<header class="mb-8">
			<h1 class="flex items-center gap-3 text-2xl sm:text-3xl font-bold text-white">
				<i class="fas fa-comment" aria-hidden="true"></i> <?php _e("Pomodoros Blog", "sis-foca-js"); ?>
			</h1>
		</header>

		<div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8">
			<p class="text-gray-300 mb-5"><?php _e("We moved the blog, check it out", "sis-foca-js"); ?></p>
			<a class="inline-block bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-5 rounded-xl transition"
				href="https://conteudo.franciscomatelli.com.br/cat/projeto/pomodoros/">
				<?php _e("Open the Pomodoros blog", "sis-foca-js"); ?>
			</a>
		</div>
	</div>
</div>
