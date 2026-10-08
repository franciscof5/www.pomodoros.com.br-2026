			<div class="sidebar col-md-4">
				
				<ul>

				<li>
				<h3><?php _e("Sponsored by", "sis-foca-js"); ?></h3>
				<?php 
				echo show_sponsor("excerpt");
				?>
				</li>

				<li>
				<h3><?php _e("Buy to support our free services", "sis-foca-js"); ?></h3>
				<?php 
				echo do_shortcode('[product id="5912"]'); 
				?>
				</li>

				<li>
				<h3><?php _e("Our blog", "sis-foca-js"); ?></h3>
				<?php 
				if(function_exists("show_recent_posts_georefer"))
				show_recent_posts_georefer(); ?>
				</li>

				<li>
				<h3 class="widget-title">Change Language</h3>
				<?php 
				if(function_exists("show_lang_options"))
				show_lang_options(true); ?>
				</li>
				
				<li>
				<h3 class="widget-title"><?php _e("Most recent task", "sis-foca-js"); ?></h3>
				<?php 
				if(function_exists("show_welcome_message"))
				show_welcome_message(); ?>
				</li>

				<?php #echo do_shortcode('[rpwe limit="100" tag="579" ]'); ?>
				<?php #echo do_shortcode('[rpwe limit="10" thumb="true" ]'); ?>

				<?php /*the_widget('Recent_Posts_Widget_Extended', array(
					"title" => "Recent Posts",
					"tag" => "english"))*/ ?>
				<?php #echo do_shortcode('[product id="5432"]'); ?>
				<?php #echo do_shortcode('[product id="5434"]'); ?>
				<?php #echo do_shortcode('[product id="5157"]'); ?>
				</ul>
			</div>
