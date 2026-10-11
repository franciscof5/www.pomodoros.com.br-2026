<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Calendar', 'sis-foca-js'); ?>";
</script>

<div class="pomo-page">
	<header class="pomo-page__head">
		<h1 class="pomo-page__title"><span class="fas fa-calendar-alt" aria-hidden="true"></span> <?php _e('Calendar', 'sis-foca-js'); ?></h1>
		<p class="pomo-page__subtitle"><?php _e('Your productivity calendar', 'sis-foca-js'); ?></p>
	</header>

	<div class="pomo-section">
		<?php echo do_shortcode("[ranking-calendar]"); ?>
	</div>
</div><!-- .pomo-page -->