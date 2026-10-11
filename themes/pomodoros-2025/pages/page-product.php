<div class="bg-gray-900 text-gray-100 min-h-screen pt-24 pb-16">
	<div class="mx-auto max-w-3xl px-4 sm:px-6">
		<div id="blog-latest">
			<?php if (have_posts()) : ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php do_action('bp_before_blog_post') ?>

					<article class="post bg-gray-800 border border-gray-700 rounded-2xl overflow-hidden mb-6"
						id="post-<?php the_ID(); ?>">
						<?php if (has_post_thumbnail()) { ?>
							<a class="block bg-black/40" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail(array(500, 200)); ?>
							</a>
						<?php } ?>

						<div class="p-6">
							<h2 class="posttitle text-xl font-bold text-white mb-2">
								<a class="hover:text-green-400 transition" href="<?php the_permalink() ?>" rel="bookmark"
									title="<?php _e('Permanent Link to', 'buddypress') ?> <?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<p class="date text-xs uppercase tracking-wide text-gray-400 mb-3"><?php the_time("j \d\\e F \d\\e Y") ?></p>

							<div class="entry prose prose-invert max-w-none text-gray-300">
								<?php
								if (!is_single())
									the_excerpt("... continuar lendo.");
								else
									the_content(__('Read the rest of this entry &rarr;', 'buddypress')); ?>
							</div>

							<div class="postmetadata mt-4 text-sm text-gray-400 flex items-center justify-between gap-4">
								<span class="tags"><?php the_tags(__('Tags: ', 'buddypress'), ', ', '<br />'); ?></span>
								<span class="comments"><?php comments_popup_link(__('No Comments &#187;', 'buddypress'), __('1 Comment &#187;', 'buddypress'), __('% Comments &#187;', 'buddypress')); ?></span>
							</div>
						</div>
					</article>

					<?php do_action('bp_after_blog_post') ?>

				<?php endwhile; ?>

			<?php else : ?>

				<div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 text-center">
					<h2 class="text-xl font-bold text-white mb-2"><?php _e('Not Found', 'buddypress') ?>!</h2>
					<p class="text-gray-400"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'buddypress') ?></p>
					<div class="mt-4"><?php locate_template(array('searchform.php'), true) ?></div>
				</div>

			<?php endif; ?>
		</div>

		<?php do_action('bp_after_blog_home'); ?>
	</div>
</div>
