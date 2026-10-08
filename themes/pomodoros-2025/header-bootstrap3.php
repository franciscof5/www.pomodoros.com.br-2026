<?php global $user_prefered_language_prefix; ?>
<!DOCTYPE html>
	<head lang="<?php echo isset($user_prefered_language) ? $user_prefered_language: $user_prefered_language_prefix; ?>">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

		<?php
		/*global $user_prefered_language;
		if($user_prefered_language=="pt_BR" || $user_prefered_language=="pt")
			$apendix = "Brasil";
		else
			$apendix = "Global";*/
		global $title_apendix;
		?>
		<title>Pomodoros <?php echo $title_apendix;wp_title(); 
		#bp_page_title() ?></title>
		
		<?php do_action( 'bp_head' ) ?>
		
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
		
		<!--link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" /-->

		<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_user() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
		<?php endif; ?>
		
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
		
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />
		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<!--link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet'-->
		<?php wp_head(); ?>

		<meta name="viewport" content="width=device-width, user-scalable=no">
	</head>


<body <?php #body_class()  id="bp-default22" ?>>

<!--div id="audio"></div-->

<?php do_action( 'bp_before_header' ) ?>
<!--span id='linha-fundo'></span-->
<div id="main-cotainer" class="container-fluid content">
	<nav class="navbar navbar-inverse navbar-pomodoros">
		<!--div class="DDDcontainer-fluid"-->
			<div class="navbar-header" style="margin-top: 5px; width: 100%;">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapsePommoNabar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				
				<a class="" title="<?php _e("Go to Pomodoros Blog", "sis-foca-js"); ?>" href="<?php bloginfo('url'); echo is_user_logged_in() ? '/focus' : '/'; ?>">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" id="pomodoros-topo" alt="Pomodoros">
				</a>
			</div>

			<ul class="collapse navbar-collapse pomoNavbar" id="collapsePommoNabar" style="margin: 5px 0 0">
				<?php if ( is_user_logged_in() ) { ?> 
				<!--li>
					<a title="<?php _e("Start Focus", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus/" class="btn btn-transparent-blue btn-xs btn-expand">
						<div id="icone-foc"></div>
						<span class="hidden-sm hidden-md icon-leg"><?php _e("Focus", "sis-foca-js"); ?></span>
					</a>
				</li-->
				
			    <?php } ?>
			    
			    <!--ul class="nav navbar-nav navbar-right pomoNavbar" style="padding-top: 5;"-->
			    <span style="float:right;" class="pomoNavbar-right icones-celular">
					<?php if ( !is_user_logged_in() ) { ?> 
					<li>
						<a title="<?php _e("Login", "sis-foca-js"); ?>" class="btn btn-transparent-dark btn-xs btn-expand abrir_login" id="login_login" tabindex="1">
							<!--i class="glyphicon glyphicon-log-in"></i--> 
							<span class="icon-leg"><?php _e("Login", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
						<a href="/register" class="btn btn-success btn-xs btn-expand " role="button" aria-pressed="true" title="<?php _e("Create your free pomodoros.com.br account", "sis-foca-js"); ?>">
							<!--i class="glyphicon glyphicon-star"></i--> 
							<span class="icon-leg"><?php _e("Sign Up", "sis-foca-js"); ?></span>
						</a>
					</li>
					<?php } else { ?> 
					<!--li>
						<a title="Ver Blog" class="btn btn-link" href="/blog" style="padding-top: 10px;">Blog</a>
						</li-->
					<li class="dropdown hidden-xs icon-leg btn btn-xs">
						<a href="#" class="btn btn-transparent-red btn-xs btn-expand dropdown-toggle dropdown-toggle-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-menu-hamburger"></i> <span class="glyphicon caret"> </span></a>
						<ul class="dropdown-menu" style="right: 0;left: inherit;">
							<li>
								<a title="<?php _e("Start Focus", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus/">
								<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
								<?php _e("Focus", "sis-foca-js"); ?>
								</a>
							</li>
							
							<li>
								<a title="<?php _e("View Productivity", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/members/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>">
									<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
									<?php _e("Productivity", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("Colleagues list", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/members/" alt="Amigos">
							  		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							  		<?php _e("Colleagues", "sis-foca-js"); ?>
							  	</a>
							</li>

							<li>
								<a title="<?php _e("View the most productive users Ranking", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/ranking/">
								<span class="glyphicon glyphicon-signal" aria-hidden="true" style="transform: rotate(90deg) scaleX(-1);"></span>
								<?php _e("Ranking", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("Perfomance Calendar", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/calendar/">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
									<?php _e("Calendar", "sis-foca-js"); ?>
							  	</a>
					  		</li>
							<li role="separator" class="divider"></li>
							<li>
								<a title="<?php _e("Settings", "sis-foca-js"); ?>" class="abrir_settings" href="#">
									<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> <?php _e("Settings", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("View your account", "sis-foca-js"); ?>"  href="<?php bloginfo('url'); ?>/my-account">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								<?php _e("My Acount", "sis-foca-js"); ?>
							</a>
							</li>
							<li role="separator" class="divider"></li>

							<li>
								<a title="<?php _e("Pomodoros Blog", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/news">
									<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 
									<?php _e("Pomodoros Blog", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("Open support ticket", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/help">
									<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> 
									<?php _e("Support", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("Focus Training", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus-training">
									<span class="glyphicon glyphicon-education" aria-hidden="true"></span> 
									<?php _e("Focus Training", "sis-foca-js"); ?>
								</a>
							</li>

							<li>
								<a title="<?php _e("Logout", "sis-foca-js"); ?>" href="<?php echo wp_logout_url(); ?>">
								<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
								 <?php _e("Logout", "sis-foca-js"); ?>
							</a>
							</li>
						</ul>
					</li>

					
					<span class="hidden-sm hidden-md hidden-lg icones-celular">
					<li>
						<a title="<?php _e("Start Focus", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/focus/" class="btn btn-transparent-blue btn-xs btn-expand">
							<div id="icone-foc"></div>
							<span class="hidden-sm hidden-md icon-leg"><?php _e("Focus", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
						<a title="<?php _e("View Productivity", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/members/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>" class="btn btn-transparent-blue btn-xs btn-expand">
							<div id="icone-gauge"></div>
							<span class="hidden-sm hidden-md icon-leg"><?php _e("Productivity", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
					  	<a title="<?php _e("Colleagues list", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/members/" alt="Amigos" class="btn btn-transparent-blue btn-xs btn-expand">
					  		<div id="icone-amigo"></div>
					  		<span class="hidden-sm hidden-md icon-leg"><?php _e("Colleagues", "sis-foca-js"); ?></span>
					  	</a>
					</li>
					<li>
						<a title="<?php _e("View the most productive users Ranking", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/ranking/" class="btn btn-transparent-blue btn-xs btn-expand">
							<div id="icone-rank"></div>
							<span class="hidden-sm hidden-md icon-leg"><?php _e("Ranking", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
						<a title="<?php _e("Perfomance Calendar", "sis-foca-js"); ?>" href="<?php bloginfo('url'); ?>/calendar/" class="btn btn-transparent-blue btn-xs btn-expand">
							<div id="icone-calend"></div>
							<span class="hidden-sm hidden-md icon-leg"><?php _e("Calendar", "sis-foca-js"); ?></span>
					  	</a>
					</li>
					<li>
						<a title="<?php _e("View your account", "sis-foca-js"); ?>"  class="btn btn-transparent-red btn-xs btn-expand" href="<?php bloginfo('url'); ?>/my-account">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							<span class="hidden-sm hidden-md icon-leg"> <?php _e("My Acount", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
						<a title="<?php _e("Open support ticket", "sis-foca-js"); ?>" class="btn btn-transparent-red btn-xs btn-expand" href="<?php bloginfo('url'); ?>/help">
							<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> 
							<span class="hidden-sm hidden-md icon-leg"> <?php _e("Support", "sis-foca-js"); ?></span>
						</a>
					</li>
					<li>
						<a title="<?php _e("Settings", "sis-foca-js"); ?>" class="btn btn-transparent-red btn-xs btn-expand abrir_settings" href="#">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span><span class="hidden-sm hidden-md icon-leg"> <?php _e("Settings", "sis-foca-js"); ?> </span>
						</a>
					</li>

					<li>
						<a title="<?php _e("Focus Training", "sis-foca-js"); ?>" class="btn btn-transparent-red btn-xs btn-expand" href="<?php bloginfo('url'); ?>/focus-training">
							<span class="glyphicon glyphicon-education" aria-hidden="true"></span><span class="hidden-sm hidden-md icon-leg"> <?php _e("Focus Training", "sis-foca-js"); ?> </span>
							</a>
						</li>
					<li>
						<a title="<?php _e("Logout", "sis-foca-js"); ?>" class="btn btn-transparent-red btn-xs btn-expand" href="<?php echo wp_logout_url(); ?>">
							<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
							<span class="hidden-sm hidden-md icon-leg"> <?php _e("Logout", "sis-foca-js"); ?></span>
						</a>
					</li>
					</span>
					<?php } ?>
				</span>
			    <!--/ul-->
			    
			</ul>
		<!--/div-->
	</nav>
	<?php /**/ ?>

	<div id="loginlogbox">
		<?php wp_login_form(); ?>
		<div style="margin-top:-10px;">
			<?php do_action( 'wordpress_social_login' ); ?> 
			<div style="margin-top: -40px;">
				<?php do_action( 'bp_after_sidebar_login_form' ); ?>
			</div>
		</div>
	</div>

	<div id="settingsbox">
		<h2 class="forte" style="margin-top: -10px;"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> <?php _e("Settings", "sis-foca-js"); ?> </h2>
		<p>Change main volume level</p>
		<div class="row">
			<div class="col-xs-4">
				<label><span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> <?php _e("Volume", "sis-foca-js"); ?></label><br />
			</div>
			
		</div>

		<div class="row">
			<div class="col-xs-1">
				<span class="glyphicon glyphicon-volume-off" aria-hidden="true"></span>
			</div>
			<div class="col-xs-9">
				<input type="range" id="rangeVolume">
			</div>
			<div class="col-xs-1">
				<span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
			</div>
		</div>
		<br>
		<p>Click to enable/disable sound FX and voice</p>
			<div class="row">
				<div class="col-xs-8">
					<h3><strong>Sound FX</strong></h3>
				</div>
				<div class="col-xs-4">
					 <input id="soundfx_enabled" name="someSwitchOption001" type="checkbox" checked="checked">
	                <!--div class="material-switch pull-right" style="float: right;">
	                    <input id="soundfx_enabled" name="someSwitchOption001" type="checkbox" checked="checked" />
	                    <label for="sound-switcher" class="label-success"></label>
	                </div-->
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-8">
					 <h3><strong><?php _e("Voice", "sis-foca-js"); ?></strong></h3>
				</div>
				<div class="col-xs-4">
					<input id="voice_enabled" name="someSwitchOption002" type="checkbox" checked="checked">
	                <!--div class="material-switch pull-right" style="float: right;">
	                    <input id="voice_enabled" name="someSwitchOption002" type="checkbox" checked="checked" />
	                    <label for="voice-switcher" class="label-success"></label>
	                </div-->
				</div>
			</div>
		
	</div>
	<?php 
	#var_dump(get_locale());
	#_e('Hello test', 'sis-foca-js'); ?>
	<?php do_action( 'bp_header' ) ?>


	<?php do_action( 'bp_after_header' ) ?>
	<?php do_action( 'bp_before_container' ) ?>



	<div class="container-fluid">