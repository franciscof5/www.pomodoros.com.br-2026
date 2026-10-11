<div class="pomo-page">
	<header class="pomo-page__head">
		<h1 class="pomo-page__title"><span class="fas fa-lock" aria-hidden="true"></span> <?php _e('Restricted Area', 'sis-foca-js'); ?></h1>
	</header>

	<div class="loginformdiv">
		<?php wp_login_form(); ?>
		<div style="margin-top:12px;">
			<?php do_action('wordpress_social_login'); ?>
			<div style="margin-top:8px;">
				<?php do_action('bp_after_sidebar_login_form'); ?>
			</div>
		</div>
	</div>
</div><!-- .pomo-page -->
