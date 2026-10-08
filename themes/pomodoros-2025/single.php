<?php 
get_header(); 
global $user_prefered_language;
$user_prefered_language_prefix = substr($user_prefered_language,0,2);
#echo "lang-".$user_prefered_language_prefix;

# echo do_shortcode('[rev_slider alias="pomo1"]'); 
?>
<?php if(function_exists("show_welcome_message")) show_welcome_message(true); ?>

	<!--style>
		.navbar {margin-bottom: 0px;}
	</style-->
	<div id="content" class="content_default col col-xs-12 ">
		<div class="row">
				<div class="padder col-md-8">
				<?php if(function_exists("show_lang_options"))
			show_lang_options(false); ?>
			<?php #show_lang_options(false); ?>

			<?php do_action( 'bp_before_blog_home' ) ?>

			<div class="page" id="blog-single">

				<?php 
				if(function_exists('set_shared_database_schema')) {
				       			set_shared_database_schema();
				       		}

					 while (have_posts()) : the_post(); ?>
					 	<?php if(function_exists("check_language_user_and_content"))check_language_user_and_content(get_the_tags()); ?>
						<?php #if(!has_tag("english")){ ?>
						<?php do_action( 'bp_before_blog_post' ) ?>

						<div class="post" id="post-<?php the_ID(); ?>">

								<div style="/*background: #222;*/width: 100%;">
								<center>
							    <a style="margin:0 auto;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							       <?php 

							       if ( has_post_thumbnail() ) {
							       		if(!has_tag("video"))
										the_post_thumbnail( /*array(500,200)*/ );
									}

							       ?>
							    </a>
							    </center>
							    </div>
							<?php #endif;  ?>
							<div class="author-box">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), '60' ); ?>
							</div>

							<div class="post-content">
								<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

								<p class="date"><?php the_time("j \d\\e F \d\\e Y") ?></p>

								<div class="entry">
									<?php 
									if(!is_single())
									the_excerpt("... continuar lendo.");
									else{
										echo show_sponsor("box-float-left");
										the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) );
									} ?>
								</div>

								<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
							</div>

						</div>

						<?php do_action( 'bp_after_blog_post' ) ?>
						<?php edit_post_link( __( 'Edit this entry.', 'buddypress' ), '<p>', '</p>'); ?>
						<?php #} ?>
					<?php endwhile; ?>

					<?php 

					#plugin: f5sites-shared-posts-tables-and-uploads-folder
					if(function_exists("print_blog_nav_links") && !is_home()) print_blog_nav_links($post, "lang-".$user_prefered_language_prefix); ?>
					<?php
					?>
			</div>

			<?php do_action( 'bp_after_blog_home' ); ?>

			</div><!-- .padder -->
			<?php locate_template( array( 'sidebar-index.php' ), true ); ?>
			
		</div>
	</div><!-- #content -->

<?php get_footer("condensed"); ?>

