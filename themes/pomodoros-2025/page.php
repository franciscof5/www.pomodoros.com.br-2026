<?php get_header() ?>
<?php
die('das');
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
#var_dump(dirname($uri_parts[0]));die;
if(dirname($uri_parts[0])!="/") {
	$page = explode("/", dirname($uri_parts[0]));
	$page = $page[1];
} else {
	$page = basename($uri_parts[0]);
}

?>

	<!--div id="content" class="content_default"-->

	<div class="content_nosidebar col-xs-12">
	<?php #if (is_user_logged_in() || $page=="plugins-br" || $page=="product") { ?>

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h2 class="pagetitle lobster"><?php the_title(); ?></h2>

				<div class="post" id="post-<?php the_ID(); ?>">

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => __( '<p><strong>Pages:</strong> ', 'buddypress' ), 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link( __( 'Edit this entry.', 'buddypress' ), '<p>', '</p>'); ?>

					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ) ?>

		<?php #} else { 
			#locate_template( "part-closed.php", true );
		 #} ?>
	</div><!-- #content -->
	
	<?php #locate_template( array( 'sidebar-pomodoro-left.php' ), true ) ?>

<?php get_footer("condensed"); ?>
