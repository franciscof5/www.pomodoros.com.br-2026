<?php get_header(); ?>
<?php

$slug = wp_title( false, false );

$args = array(
    'post_type' => 'projectimer_focus',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    
	'tax_query' => array(
        array(
            'taxonomy' => 'post_tag',
            'field' => 'slug',
            'terms' => array($slug)
        )
    )
);
$Query = new WP_Query($args);
$i = 1+$Query->found_posts;
if($Query -> have_posts()):

    while($Query -> have_posts()):
		$i--;
        $Query -> the_post();
        ?>
        <div class="row justify-content-md-center">
            <div class="col-md-auto col-sm-12 col-md-6">
				<span class="badge badge-dark" style="min-width: 22px;"><?php echo $i; ?> </span>	
				<?php the_time('j F Y G:i'); ?>
				<a href="<?php the_permalink(); ?>"><?php the_title();?></a><br />
				<!-- <p><?php the_time('j F Y G:i'); ?><?php printf( __( '<span> - %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p> -->
				<!-- <p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Projetos: ', 'buddypress' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'Sem comentários &#187;', 'buddypress' ), __( '1 Comentário &#187;', 'buddypress' ), __( '% Comentários &#187;', 'buddypress' ) ); ?></span></p> -->
				<?php #the_excerpt();?>
			</div>
        </div>
        <?php
    endwhile;

else:
    "No Administrative Offices Found. Try again later";
endif;
wp_reset_postdata();
?>


<?php get_footer("condensed"); ?>

<?php 
/* ?>

	<div id="content" class="content_default  col-xs-12 col-sm-9">
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

			<h3 class="pagetitle"><?php _e("You are browsing the archive for", "buddypress"); printf( __( '%1$s', 'buddypress' ), wp_title( false, false ) ); ?></h3>
			<?php
			#global $wp_query;
			#var_dump($wp_query);
			
			?>
			<?php if ( have_posts() ) : ?>

				<?php #bp_dtheme_content_nav( 'nav-above' ); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="author-box">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
							<p><?php printf( _x( '%s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ); ?></p>
						</div>

						<div class="post-content">
							<h2 class="posttitle"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<p class="date"><?php the_time('j F Y G:i'); ?><?php printf( __( '<span> - %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>

							<div class="entry">
								<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							</div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Projetos: ', 'buddypress' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'Sem comentários &#187;', 'buddypress' ), __( '1 Comentário &#187;', 'buddypress' ), __( '% Comentários &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ); ?>

				<?php endwhile; ?>

				<?php #bp_dtheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ); ?></h2>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->
*/