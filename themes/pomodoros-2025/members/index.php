<?php

/**
 * BuddyPress - Members Directory
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

get_header( 'buddypress' ); ?>

	<?php do_action( 'bp_before_directory_members_page' ); ?>

	<div class="pomo-page">
		<header class="pomo-page__head">
			<h1 class="pomo-page__title"><span class="fas fa-users" aria-hidden="true"></span> <?php _e( 'Colleagues', 'sis-foca-js' ); ?></h1>
			<p class="pomo-page__subtitle"><?php _e( 'Meet the pomodorers', 'sis-foca-js' ); ?></p>
		</header>

		<div id="content_members">

		<?php if ( is_user_logged_in() ) { ?>

		<?php do_action( 'bp_before_directory_members' ); ?>

		<form action="" method="post" id="members-directory-form" class="dir-form">

			<?php do_action( 'bp_before_directory_members_content' ); ?>

			<div class="pomo-dir-toolbar">
				<div class="item-list-tabs" role="navigation">
					<ul>
						<li class="selected" id="members-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_members_root_slug() ); ?>"><?php printf( __( 'All Members <span>%s</span>', 'buddypress' ), bp_get_total_member_count() ); ?></a></li>

						<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
							<li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ?>"><?php printf( __( 'My Friends <span>%s</span>', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>
						<?php endif; ?>

						<?php do_action( 'bp_members_directory_member_types' ); ?>
					</ul>
				</div><!-- .item-list-tabs -->

				<div id="members-dir-search" class="dir-search" role="search">
					<?php bp_directory_members_search_form(); ?>
				</div><!-- #members-dir-search -->

				<div class="item-list-tabs pomo-dir-order" id="subnav" role="navigation">
					<ul>
						<?php do_action( 'bp_members_directory_member_sub_types' ); ?>

						<li id="members-order-select" class="last filter">
							<label for="members-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
							<select id="members-order-by">
								<option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
								<option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>

								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
								<?php endif; ?>

								<?php do_action( 'bp_members_directory_order_options' ); ?>
							</select>
						</li>
					</ul>
				</div>
			</div><!-- .pomo-dir-toolbar -->

			<div id="members-dir-list" class="members dir-list">
				<?php locate_template( array( 'members/members-loop.php' ), true ); ?>
			</div><!-- #members-dir-list -->

			<?php do_action( 'bp_directory_members_content' ); ?>

			<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

			<?php do_action( 'bp_after_directory_members_content' ); ?>

		</form><!-- #members-directory-form -->

		<?php do_action( 'bp_after_directory_members' ); ?>

		<?php } else { ?>

			<div class="pomo-card loginformdiv">
				<p class="pomo-page__subtitle" style="margin-bottom:16px;"><?php _e( 'Log in to see the colleagues directory.', 'sis-foca-js' ); ?></p>
				<?php wp_login_form(); ?>
				<div style="margin-top:12px;">
					<?php do_action( 'wordpress_social_login' ); ?>
					<div style="margin-top:8px;">
						<?php do_action( 'bp_after_sidebar_login_form' ); ?>
					</div>
				</div>
			</div>

		<?php } ?>

		</div><!-- #content_members -->
	</div><!-- .pomo-page -->

	<?php do_action( 'bp_after_directory_members_page' ); ?>

<?php get_footer( 'condensed' ); ?>
