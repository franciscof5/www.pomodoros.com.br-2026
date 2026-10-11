<div class="pomo-page">
	<header class="pomo-page__head">
		<h1 class="pomo-page__title"><span class="fas fa-life-ring" aria-hidden="true"></span> <?php _e('Help &amp; Support', 'sis-foca-js'); ?></h1>
		<p class="pomo-page__subtitle"><?php _e('Support system, FAQ and contact', 'sis-foca-js'); ?></p>
	</header>

	<div class="pomo-section">
		<?php echo do_shortcode("[wp_support_plus]"); ?>
	</div>

	<div class="pomo-card">
		<h2 class="pomo-page__title" style="font-size:20px;"><span class="fas fa-circle-question" aria-hidden="true"></span> <?php _e('FAQ', 'sis-foca-js'); ?></h2>
		<p class="pomo-page__subtitle"><?php _e('We are building our FAQ', 'sis-foca-js'); ?></p>
	</div>

	<div class="pomo-card" id="footer-contact-form" style="margin-top:16px;">
		<h2 class="pomo-page__title" style="font-size:20px;"><span class="fas fa-envelope" aria-hidden="true"></span> <?php _e('Contact Us', 'sis-foca-js'); ?></h2>
		<?php
			global $locale;
			if ($locale == "pt_BR" || $locale == "pt")
				echo do_shortcode('[contact-form-7 id="1526" title="Contato"]');
			else
				echo do_shortcode('[contact-form-7 id="3950" title="Contato"]');
		?>
	</div>
</div><!-- .pomo-page -->
