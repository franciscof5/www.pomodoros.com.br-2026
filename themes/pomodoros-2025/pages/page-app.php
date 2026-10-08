<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Mobile', 'sis-foca-js'); ?>";
</script>

<div id="center_layout" class="col-md-8 col-md-offset-2">
	
	<?php 
	if(is_user_logged_in()) { ?>
		<script>
			window.location = "https://www.pomodoros.com.br/focus";
		</script>
	<?php }	?>
	<h2 class="forte"><?php _e("Pomodoros Mobile", "sis-foca-js"); ?></h2>
	<p class="bg-dangerD"><?php _e("Login to access app", "sis-foca-js"); ?></p>

	<div id="">
		<?php wp_login_form(); ?>
		<div style="margin-top:-40px;">
			<?php do_action( 'wordpress_social_login' ); ?> 
			<div style="margin-top: -40px;">
				<?php do_action( 'bp_after_sidebar_login_form' ); ?>
			</div>
		</div>
	</div>
	<br style="clear:both; margin-top: 30px;">
	<p>
		<?php 
		if(function_exists("show_lang_options"))
			show_lang_options(); ?>
	</p>

	<center>		
		<?php echo show_sponsor("onlythumb"); ?>
	</center>
</div>
