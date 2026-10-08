<?php global $user_prefered_language_prefix; ?>
<!DOCTYPE html>
	<head lang="<?php echo $user_prefered_language; ?>">
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

		<style type="text/css">
			.row-container {
				display: none;
			}
			.navbar-f5sites-bar {
				position: absolute;
				margin-left: 250px;
			}
		</style>
		
	</head>


<body <?php #body_class()  id="bp-default22" ?>>

<!--div id="audio"></div-->

<?php do_action( 'bp_before_header' ) ?>
<!--span id='linha-fundo'></span-->
	<?php if(!is_user_logged_in()) { ?>
		<div id="loginlogbox">
			<?php wp_login_form(); ?>
			<div style="margin-top:-10px;">
				<?php do_action( 'wordpress_social_login' ); ?> 
				<?php do_action( 'bp_after_sidebar_login_form' ); ?>
			</div>
		</div>
	<?php } ?>
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
