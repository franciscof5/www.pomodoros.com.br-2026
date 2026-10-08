	<div id="content" class="content_default col col-xs-12">

		<div class="page" id="blog-latest">
			<?php 
			#global $wp_query;
			#var_dump($wp_query);
			#global $wpdb;
			#var_dump($wpdb);
			#global $reverter_filtro_de_categoria_pra_forcar_funcionamento;
			#$reverter_filtro_de_categoria_pra_forcar_funcionamento = true;
			#force_database_aditional_tables_share(true);
			#die;
			if ( have_posts() ) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action( 'bp_before_blog_post' ) ?>

					<div class="post" id="post-<?php the_ID(); ?>">

							<div style="background: #222;width: 100%;">
							<center>
						    <a style="margin:0 auto;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						       <?php 

						       if ( has_post_thumbnail() ) {
						       		
									the_post_thumbnail( array(500,200) );
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
								else
								the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							</div>

							<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
						</div>

					</div>

					<?php do_action( 'bp_after_blog_post' ) ?>

				<?php endwhile; ?>

				<?php 
				#plugin: f5sites-shared-posts-tables-and-uploads-folder
				#if(function_exists("print_blog_nav_links")) print_blog_nav_links($post); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?>!</h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>
				<p class="center"> Navegue </p>
				<?php locate_template( array( 'searchform.php' ), true ) ?>

			<?php endif; ?>
		</div>

		<?php do_action( 'bp_after_blog_home' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->
