<div class="pomo-page">
	<header class="pomo-page__head">
		<h1 class="pomo-page__title"><span class="fas fa-file-csv" aria-hidden="true"></span> <?php _e('Export CSV', 'sis-foca-js'); ?></h1>
		<p class="pomo-page__subtitle"><?php _e('Have more control over your data and view it in Excel, LibreOffice Calc and others.', 'sis-foca-js'); ?></p>
	</header>

	<div class="pomo-card">
		<?php echo do_shortcode('[wpcsv_export_form]'); ?>
		<p class="pomo-page__subtitle" style="margin-top:14px;"><?php _e('Note: in the future it will be possible to import pomodoros.', 'sis-foca-js'); ?></p>
	</div>
</div><!-- .pomo-page -->
