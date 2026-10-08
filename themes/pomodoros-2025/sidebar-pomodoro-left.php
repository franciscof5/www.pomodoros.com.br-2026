<?php do_action( 'bp_before_sidebar' ); ?>

<div id="sidebar-pomodoro-left" class="sidebar col col-xs-3 hidden-sm hidden-xs" role="complementary">
	<?php /*
	#Working collapse buttons, but disabled for now
	<center><button data-toggle="collapse" data-target="#sidebar22_padder"><span class="glyphicon glyphicon-resize-vertical"></span></button></center>
	<button data-toggle="collapse" data-target="#sidebar22_padder" class="collapse_button collapse_left" ><span class="glyphicon glyphicon-resize-horizontal"></span></button>
	*/ ?>
	<ul class="padder width" id="sidebar22_padder">
		<li>
			<h3 class="widget-title"><?php _e("Your Account", "sis-foca-js"); ?></h3>
			<?php do_action( 'bp_inside_before_sidebar' ); ?>

			<?php if ( is_user_logged_in() ) : ?>

				<?php do_action( 'before_sidebar' ); ?>

				<div id="sidebar-me">
					<a href="<?php echo bp_loggedin_user_domain(); ?>">
						<?php bp_loggedin_user_avatar( 'type=thumb&width=80&height=80' ); ?>
					</a>

					<p><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></p>
					<p><a class="button logout float-right" href="<?php echo wp_logout_url( wp_guess_url() ); ?>"><?php _e( 'Log Out', 'buddypress' ); ?></a></p>

					<?php do_action( 'bp_sidebar_me' ); ?>
				</div>

				<?php do_action( 'bp_after_sidebar_me' ); ?>

				<?php if ( bp_is_active( 'messages' ) ) : ?>
					<?php bp_message_get_notices(); /* Site wide notices to all users */ ?>
				<?php endif; ?>

			<?php else : ?>

				<?php do_action( 'bp_before_sidebar_login_form' ); ?>

				<?php if ( bp_get_signup_allowed() ) : ?>
				
					<p id="login-text">

						<?php printf( __( 'Please <a href="%s" title="Create an account">create an account</a> to get started.', 'buddypress' ), bp_get_signup_page() ); ?>

					</p>

				<?php endif; ?>

				<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" method="post">
					<label><?php _e( 'Username', 'buddypress' ); ?><br />
					<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

					<label><?php _e( 'Password', 'buddypress' ); ?><br />
					<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

					<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'buddypress' ); ?></label></p>

					<?php do_action( 'bp_sidebar_login_form' ); ?>
					<input type="submit" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Log In', 'buddypress' ); ?>" tabindex="100" />
					<input type="hidden" name="testcookie" value="1" />
				</form>

				<?php do_action( 'bp_after_sidebar_login_form' ); ?>

			<?php endif; ?>
		</li>

		
		<?php /* Show forum tags on the forums directory */
		if ( bp_is_active( 'forums' ) && bp_is_forums_component() && bp_is_directory() ) : ?>
			<li>
				<div id="forum-directory-tags" class="widget tags">
					<h3 class="widgettitle"><?php _e( 'Forum Topic Tags', 'buddypress' ); ?></h3>
					<div id="tag-text"><?php bp_forums_tag_heat_map(); ?></div>
				</div>
		</li>
		<?php endif; ?>
		
		<li>
			<h3 class="widget-title">Change Language</h3>
			<?php if(function_exists("smartlang_show_lang_options")) smartlang_show_lang_options(true); ?>
		</li>
		
		<?php
		/*
		<li> the_widget("cp_pointsWidget", "title=Pontuacao", 'before_title=<h3 class="widget-title">&after_title=</h3>'); ?>
		</li>*/
		?>
		
		<li>
			<?php the_widget("BP_Core_Whos_Online_Widget", "",  'before_title=<h3 class="widget-title">&after_title=</h3>'); ?>
		</li>
		<li>
			<?php the_widget("BP_Core_Recently_Active_Widget", "",  'before_title=<h3 class="widget-title">&after_title=</h3>'); ?>
		</li>
		<?php
		/*<li>
			<h3 class="widget-title">Projetos da Comunidade</h3>
			
			get_projectimer_project_tags(get_current_user_id()*-1);
			
		</li>*/?>
		<li>
			<h3 class="widget-title"><?php _e("Projects from Community", "sis-foca-js"); ?></h3>
			<?php
				$args = array(
        			'exclude' => "261,13,533", #fsites=14, itapemapa=13,mestrado=261, cttfase2=533, franciscomat=553
        		);
        		wp_tag_cloud($args);

			 ?>
		</li>

		<?php do_action( 'bp_inside_after_sidebar' ); ?>

		<?php  do_shortcode('[bc_members amount="16"]');  ?>
	</ul><!-- .padder -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>