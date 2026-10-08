<div id="menu" class="container-fluid">
	<div class="row justify-content-between">
		<div class="contem-logo">
			<a title="<?php _e("Go to Pomodoros Blog", "sis-foca-js"); ?>" href="<?php bloginfo('url'); echo is_user_logged_in() ? '/focus' : '/'; ?>">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" alt="Pomodoros">
			</a>
		</div>
		<div class="c">
			<?php if ( !is_user_logged_in() ) { ?> 
				<a class="abrir_login btn-black" title="<?php _e("Login", "sis-foca-js"); ?>" tabindex="1">
					<span><?php _e("Login", "sis-foca-js"); ?></span>
				</a>
				<a href="/register" class="btn-success" role="button" aria-pressed="true" title="<?php _e("Create your free pomodoros.com.br account", "sis-foca-js"); ?>">
					<span><?php _e("Sign Up", "sis-foca-js"); ?></span>
				</a>
			<?php } else { ?>
				<a class="" style="background:#9d3f72" title="<?php _e("Start Focus", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus/">
					<span class="fas fa-stopwatch" aria-hidden="true"></span>
					<?php _e("Focus", "sis-foca-js"); ?>
				</a>
			<?php } ?>
		</div>
	</div>
</div>

<div id="fullpagesss">
	
	<div class="section" id="section0">
		<?php
		$user_active_count = count_users(); //METHOD 1, only active
		$user_count = $wpdb->get_var("SELECT COUNT(`ID`) FROM $wpdb->users;");
		$projectimer_tags = get_terms( array(
			'taxonomy' => 'post_tag',
			'hide_empty' => false,
		) );
		$count_posts = wp_count_posts( 'projectimer_focus' );
		$total_posts = $count_posts->publish+$count_posts->private;
		//
		$cities_count = get_meta_values( "post_location_city", "projectimer_focus" );
		?>

		<h2 class="f-font-title"><i class="fas fa-people-group"></i> <?php _e("Stats from Community", "sis-foca-js"); ?></h2>
		<div class="row" style="padding:40px;">
			<ul class="list-group stats-group col-sm-6">
				<li class="list-group-item active">
					<span class="badge"><?php echo /*$user_count." / ".*/$user_active_count["total_users"]; ?></span>
					<i class="fas fa-users" aria-hidden="true"></i> &nbsp; <?php _e("Active Users", "sis-foca-js"); ?>
				</li>
				<li class="list-group-item active">
					<span class="badge"><?php echo $total_posts; ?></span>
					<i class="fas fa-check"></i> &nbsp; <?php _e("Pomodoros done", "sis-foca-js"); ?>
				</li>
				<li class="list-group-item active">
					<span class="badge"><?php echo round($total_posts/2); ?> h</span>
					<i class="fas fa-clock"></i> &nbsp; <?php _e("Time tracked", "sis-foca-js"); ?>
				</li>
			</ul>
			<ul class="list-group stats-group col-sm-6">
				<li class="list-group-item active">
					<span class="badge"><?php echo count($projectimer_tags); ?></span>
					<i class="fas fa-tags" aria-hidden="true"></i> &nbsp; <?php _e("Projects tags", "sis-foca-js"); ?>
				</li>
				<li class="list-group-item active">
					<span class="badge"><?php echo count($cities_count); ?></span>
					<i class="fas fa-city"></i> &nbsp; <?php _e("Cities ranked", "sis-foca-js"); ?>
				</li>
				<li class="list-group-item active">
					<span class="badge">5</span>
					<i class="fas fa-language"></i> &nbsp; <?php _e("Translations", "sis-foca-js"); ?>
				</li>
			</ul>
		</div>
		<script>
			jQuery(document).ready(function() {
				jQuery(".stats-group li").mouseover(function() {
					jQuery(this).removeClass( "active" );
				}).mouseout(function() {
					jQuery(this).addClass( "active " );
				});
				jQuery("[data-toggle=popover]").popover();
			});
		</script>
	</div>

	
	<div class="section" id="section1">  

		<div class="slide" id="slide0">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-calendar"></i> <?php _e("Google Calendar", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("amazing integration", "sis-foca-js"); ?></p> 
			</div>
		</div>

	    <div class="slide" id="slide1">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-time"></i> <?php _e("Work & Rest", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("with Pomodoro Technique", "sis-foca-js"); ?></p> 
			</div>
		</div>

	    <div class="slide" id="slide2">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-calendar"></i> <?php _e("Perfomance Calendar", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("shows tasks you done", "sis-foca-js"); ?></p> 
			</div>
		</div>

		<div class="slide" id="slide3">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-list"></i> <?php _e("Grow in Ranking", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("and get more productive", "sis-foca-js"); ?></p> 
			</div>
		</div>

		<div class="slide" id="slide4">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-tags"></i> &nbsp;<?php _e("Mind blown reports", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("to check time usage", "sis-foca-js"); ?></p> 
			</div>
		</div>

		<div class="slide" id="slide5">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-question-sign"></i> <?php _e("Open a ticket", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("and get help", "sis-foca-js"); ?></p> 
			</div>
		</div>

		<div class="slide" id="slide6">
			<a title="<?php _e("Focus Training", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus-training">
			<div class="thumb-display thumb-display-black">
				<p><i class="fas fa-question-sign"></i> <?php _e("Focus Training", "sis-foca-js"); ?></p>
				<p class="hidden-xs"><?php _e("Be more productive", "sis-foca-js"); ?></p> 
			</div>
			</a>
		</div>

	</div>

	<div class="section " id="section2">
		<div class="header-desc">
			<h1 class="f-font-title"><?php _e("Relax and Work", "sis-foca-js"); ?></h1>
			<p style=""><?php _e("The key to success is to invest well your most valuable asset", "sis-foca-js"); ?>:</p>
			<p style=""><?php _e("your time", "sis-foca-js"); ?>!</p>
			
			<!--p style="font-weight: 600; font-size: 18px;"><?php _e("Relax and Focus: Online social time tracker for task and projects", "sis-foca-js"); ?>, 
			<br><?php _e("get you and your team more productive than ever", "sis-foca-js"); ?></p-->
			<a class="btn btn-success" href="/register" style="font-weight: 600; padding: 10px 30px"><i class="fas fa-star"></i> <?php _e("Get started for Free", "sis-foca-js"); ?></a>
		</div>
	</div>
	

	<div class="section " id="section3">
		<h2 class="f-font-title"><i class="fas fa-bullhorn"></i> <?php _e("Testimonials", "sis-foca-js"); ?></h2>
		<div class="col-xs-6 col-sm-6 col-md-3 testimonials-container">
			<div class="thumbnail">
				<p><?php _e("I will be the first in the ranking", "sis-foca-js"); ?>.</p>
				<div class="caption">
					<?php #echo bp_core_fetch_avatar( array( 'item_id' => 1304, 'type' => 'full' ) ) ); ?>
					<h3><a href="#">Sérgio Rodrigues Amorin</a><?php #if(function_exists("bp_core_get_userlink")) echo bp_core_get_userlink( array('user_id' => 1304 )); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 testimonials-container">
			<div class="thumbnail">
				<p><?php _e("Learning is an ongoing process. We should study daily, analyze the results regularly and apply methods to improve our previous results", "sis-foca-js"); ?>.</p>
				<div class="caption">
					<?php  #echo bp_activity_avatar( 'user_id=' . 828 ); ?>
					<h3><?php  echo bp_core_get_userlink(  828 ); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 testimonials-container">
			<div class="thumbnail">
				<p><?php _e("With Pomodoros.com.br I can have more control over my time, be more productive and perform my tasks better", "sis-foca-js"); ?>.</p>
				<div class="caption">
					<?php  #echo bp_activity_avatar( 'user_id=' . 2 ); ?>
					<h3><?php  echo bp_core_get_userlink(  2 ); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-6 col-md-3 testimonials-container">
			<div class="thumbnail">
				<p><?php _e("I used Pomodoros.com.br a few years ago, every day. I was happy to know that the website came back, I hope people use it again, I'll try to get into the habit too because 'super' helped me", "sis-foca-js"); ?>! </p>
				<div class="caption">
					<?php  #echo bp_activity_avatar( 'user_id=' . 974 ); ?>
					<h3><?php  echo bp_core_get_userlink(  974 ); ?></h3>
				</div>
			</div>
		</div>
	</div>

	<div class="section " id="section4">
		<div class="brief-history">
			<h2 class="f-font-title"><i class="fas fa-road"></i> <?php _e("Brief History", "sis-foca-js"); ?></h2>
			<span>...
			<a tabindex="0" class="btn btn-lg btn-default" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Initial Plans", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Francisco, CEO and founder, tried a lot of pomodoros softwares and decided to build it's own", "sis-foca-js"); ?>">2010</a>
			...
			<a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="Pomodoros Red" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-red.jpg' class='hidden-xs'><?php _e("First version, already online, social and async JavaScript timer, based in WordPress and BuddyPress", "sis-foca-js"); ?>">2011</a>
			...
			<a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("First Growth", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-red.jpg' class='hidden-xs'><?php _e("Very promissor period, users growth based in spontaneous reviews, in blogs, no single penny expensed in marketing", "sis-foca-js"); ?>">2012</a>
			...
			<a tabindex="0" class="btn btn-lg btn-success" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="Pomodoros Green" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-green.jpg' class='hidden-xs'><?php _e("A lot of updates to join in a brazilian startup contest, no investors became interested", "sis-foca-js"); ?>">2013</a>
			...
			<a tabindex="0" class="btn btn-lg btn-success" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Second Growth", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-green.jpg' class='hidden-xs'><?php _e("Another promissor period, mouth-to-mouth and organic growth, but founder needed to stop developing system due Master course and it started became out of date", "sis-foca-js"); ?>" >2014</a>
			...
			<a tabindex="0" class="btn btn-lg btn-success" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Turbulency", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-green.jpg' class='hidden-xs'><?php _e("High maintenance costs, founder have no time for coding, service was still online, with growth in users, but the server was poor configured and unable to update regularly", "sis-foca-js"); ?>">2015</a>
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Offline", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Service went offline because founder needed to work in other activities and trying to finish Master course, lost all regular users", "sis-foca-js"); ?>">2016</a>
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Laboratory", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Founder quited Master course and start full-time operations. New server configuration, focused on scalability and shared users information, lot of tools created to speedup development and maintance, a base for future growth. The most important year, a lot of experiences was made, since there was no users, the service constantly ended up broken untill it get on track again", "sis-foca-js"); ?>">2017</a>
			...
			<a tabindex="0" class="btn btn-lg btn-black" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="Pomodoros Black" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-black.jpg' class='hidden-xs'><?php _e("After years offline, finally Pomodoros.com.br are back online in a new 'mobile first' version, with app for Android in Google Play Store", "sis-foca-js"); ?>">2018</a>
			...
			<a tabindex="0" class="btn btn-lg btn-black" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Global", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-black.jpg' class='hidden-xs'><?php _e("We expect that all translations are 100% ready and people all over the world join the community, first paid ads and gifts sellings in its own built-in donation store", "sis-foca-js"); ?>">2019</a>
			...
			<a tabindex="0" class="btn btn-lg btn-black" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Clear Real Valuation", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-black.jpg' class='hidden-xs'><?php _e("For good or for worst, the valuation of the system are clear, investors can join or leave for a just price in options", "sis-foca-js"); ?>">2020</a>
			<!-- <a tabindex="0" class="btn btn-lg btn-default" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Societal Plan", "sis-foca-js"); ?>" data-content="<?php _e("Plans for multiple single investors to joining, options are become more valuable, at this time is expected that founder have about 15% of stock", "sis-foca-js"); ?>">2021</a> -->
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Offline", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Offline", "sis-foca-js"); ?>">2020</a>
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Offline", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Offline", "sis-foca-js"); ?>">2021</a>
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Offline", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Offline", "sis-foca-js"); ?>">2022</a>
			...
			<a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<?php _e("Pomodoros Offline", "sis-foca-js"); ?>" data-content="<img src='<?php bloginfo('stylesheet_directory');?>/images/pomo-versions/pomodoros-offline.jpg' class='hidden-xs'><?php _e("Offline", "sis-foca-js"); ?>">2023</a>
			</span>
		</div>
	</div>

	<? /*
	<div class="section" id="section5">
		<center><h2 class="f-font-title"><i class="fas fa-comment"></i> Blog</h2></center>
				<?php 
				if(function_exists('set_shared_database_schema')) {
				    set_shared_database_schema();
				}
				global $wp_query;
				$original_query = $wp_query;
				$wp_query = null;
				global $user_prefered_language;
				$user_prefered_language_prefix = substr($user_prefered_language, 0,2);
				$args = array(
					"posts_per_page" => 3,
					"post_type" => "post",
					'tag' => "lang-".$user_prefered_language_prefix,
				);
				#var_dump("lang-".$user_prefered_language_prefix);die;
				$wp_query = new WP_Query( $args );
				#var_dump($wp_query);die;
				if ( have_posts() ) : ?>

					<?php while (have_posts()) : the_post(); ?>
						<?php #if(has_tag("english")){ ?>
						<?php do_action( 'bp_before_blog_post' ) ?>

						<div class="post col-sm-4" id="post-<?php the_ID(); ?>">

								<div class="contem-thumb">
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

								<p class="date"><?php the_time("Y-m-d") ?></p>

								<div class="entry">
									<?php 
									if(!is_single())
									the_excerpt();
									else
									the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								</div>

								<p class="postmetadata"><span class="tags"><?php #the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>
							</div>

						</div>

						<?php do_action( 'bp_after_blog_post' ) ?>
						<?php #} ?>
					<?php endwhile; ?>
					<?php #the_posts_pagination(); ?>
					<?php 
					#plugin: f5sites-shared-posts-tables-and-uploads-folder
					#if(function_exists("print_blog_nav_links") && !is_home()) print_blog_nav_links($post, "lang-".$user_prefered_language_prefix); ?>

				<?php else : ?>

					<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
					<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

					<?php locate_template( array( 'searchform.php' ), true ) ?>

				<?php endif; ?>
	</div>
	*/ ?>
</div>

<center><?php if(function_exists("show_lang_options")) show_lang_options(false); ?></center>
	
<?php if(function_exists("show_welcome_message")) show_welcome_message(true); ?>

<script type="text/javascript">
	jQuery( document ).ready(function() {
		jQuery( "#loginlogbox" ).show("fast");
		
		var myFullpage = new fullpage('#fullpage', {
			afterLoad: function(anchorLink, index){
				
			},
			onLeave: function(index, nextIndex, direction){
				jQuery( "#loginlogbox" ).hide("slow");

			},
			//sectionsColor: ['#000', '#4BBFC3', '#7BAABE', 'whitesmoke', '#000', '#000'],
			anchors: ['home', 'Funcionalidades', 'estatisticas', 'depoimentos', 'historia', 'blog'],
			menu: '#menu',
			navigation: true,
			navigationPosition: 'right',
			navigationTooltips: ['home', 'Funcionalidades', 'estatisticas', 'depoimentos', 'historia', 'blog'],
			continuousVertical: true,
		});
 	
		jQuery( ".abrir_login" ).click(function() {
			jQuery( "#loginlogbox" ).toggle("slow");
		});
		jQuery( "#fullpage" ).click(function() {
			jQuery( "#loginlogbox" ).toggle("slow");
		});
	});
</script>
