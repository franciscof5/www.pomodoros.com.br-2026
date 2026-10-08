<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Exclusive Content', 'sis-foca-js'); ?>";
</script>
<div class="col-12 content_closed">
	<h2 class="forte"><i class="fas fa-exclamation-triangle"></i> <?php _e("Restrict Area", "sis-foca-js"); ?> <i class="fas fa-exclamation-triangle"></i></h2>
	<!-- <p class="bg-danger"><i class="fas fa-exclamation-triangle"></i> <a href="#" class="abrir_login"><?php _e("Login", "sis-foca-js"); ?></a> <?php _e("to view the exclusive content", "sis-foca-js"); ?></p> -->
	<div class="loginformdiv">
		<?php wp_login_form();?>
		<div style="margin-top:-10px;">
			<?php do_action('wordpress_social_login');?>
			<div style="margin-top: -40px;">
				<?php do_action('bp_after_sidebar_login_form');?>
			</div>
		</div>
	</div>
</div>