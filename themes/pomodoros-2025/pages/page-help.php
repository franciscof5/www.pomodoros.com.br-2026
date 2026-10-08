<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Help & Support System', 'sis-foca-js'); ?>";
</script>
<div class="content_nosidebar col-xs-12 ">
	<h2 class="forte"><?php _e("Support System", "sis-foca-js"); ?></h2>
	<?php 
	echo do_shortcode("[wp_support_plus]");
	?>
	<h2 class="forte">FAQ</h2>
	<p>We are building our FAQ</p>
	<div id="footer-contact-form">
		<h2 class="forte"><?php _e("Contact Us", "sis-foca-js"); ?></h2>
		<?php /* if(!is_user_logged_in()) { ?>
			<p class="bg-danger">
				<a href="#" class="abrir_login"><?php _e("Login", "sis-foca-js"); ?></a> <?php _e("now to use contact form", "sis-foca-js"); ?></p>
		<?php } else {*/ ?>
		<?php 
			global $locale;
			if($locale=="pt_BR" || $locale=="pt")
				echo do_shortcode( '[contact-form-7 id="1526" title="Contato"]' ); 
			else 
				echo do_shortcode( '[contact-form-7 id="3950" title="Contato"]' ); 
			?>
		<?php //} ?>
	</div>
</div>