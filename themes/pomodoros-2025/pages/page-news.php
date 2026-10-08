<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Blog', 'sis-foca-js'); ?>";
</script>
	
	<?php 
	if(function_exists("show_welcome_message")) show_welcome_message(true); 
	global $user_prefered_language;
	?>
	<br>
	
	<div class="col-12 content_closed">
		<h2><i class="fas fa-comment"></i> <?php _e("Pomodoros Blog", "sis-foca-js"); ?></h2>
		<div class="row">
			<div class="col-12">
				<p>Movemos o blog, confira</p>
				<p><a class="btn btn-success" href="https://conteudo.franciscomatelli.com.br/cat/projeto/pomodoros/">Acessar blog do Pomodoros</a></p>
			</div>
		</div>
	</div><!-- #content -->
