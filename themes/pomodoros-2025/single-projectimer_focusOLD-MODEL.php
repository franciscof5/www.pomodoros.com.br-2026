<?php get_header(); ?>

<?php
if (!is_user_logged_in()) {
	locate_template( "part-closed.php", true );
} else {
?>
	<div class="content_pomodoro col-xs-12 col-sm-6 col-xs-offset-3">
	<div class="container-fluid">
		<br />
		<?php while ( have_posts() ) : the_post(); ?>
				<div class="row">
    				<div class="col-sm-1 col-md-offset-1">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '60' ); ?>
					</div>
					<div class="col-sm-4">
						<p><strong> <?php the_title(); ?></strong></p>
						<p><?php get_the_author_meta('ID'); ?></p>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<div class="col-sm-4" >
					<p><strong>Pomodoro</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2" style="text-align: right;">
						<p>projetos</p>
						<p>tipo</p>
						<p>data</p>
						<p>anotações</p>
					</div>
					<div class="col-sm-4">
						<p> <?php the_tags(''); ?> &nbsp; </p>
						<p> <?php the_category(); ?> &nbsp; </p>
						<p> <?php the_date("l, j \d\e F \d\e Y g:i "); ?> &nbsp; </p>
						<p> <?php the_content(); ?> &nbsp; </p>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<div class="col-sm-4" >
					<p><strong>Tarefa</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2" style="text-align: right;">
						<p>duração</p>
						<p>pomodoros</p>
					</div>
					<div class="col-sm-4">
						<?php
						global $wpdb;

						$title = get_the_title();
						$posts_ids = array();
						$posts;
						$posts = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND     post_type='projectimer_focus'", $title), OBJECT );
						foreach ($posts as $post) {
						     $posts_ids[] = $post->ID;
						}
						?>

						<p> <?php echo count($posts_ids)/2; ?>h &nbsp;</p>
						<p> <?php echo count($posts_ids); ?> &nbsp;</p>
						<p> Tarefas relaciondas </p>
					</div>
				</div>
				<!--div class="row">
					<div class="col-sm-2 col-md-offset-2">
						<button onclick="javascript:alert('desculpe, em construcao');">Carregar tarefa</button>
					</div>
				</div-->
			<br />
			<?php endwhile; // end of the loop. ?>
	<?php #} ?>
	</div>
	</div>
<?php } ?>
<?php get_footer("condensed");

