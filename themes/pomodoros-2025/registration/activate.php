<?php get_header( 'buddypress' ); ?>

	<div id="center_layout" class="col-md-8 col-md-offset-2">
		<div class="padder">

		<?php do_action( 'bp_before_activation_page' ); ?>

		<div class="page" id="activate-page">

			<h2 class="forte"><?php if ( bp_account_was_activated() ) :
				_e( 'Account Activated', 'buddypress' );
			else :
				_e( 'Activate your Account', 'buddypress' );
			endif; ?></h2>

			<?php do_action( 'template_notices' ); ?>

			<?php do_action( 'bp_before_activate_content' ); ?>

			<?php if ( bp_account_was_activated() ) : ?>

				<?php if ( isset( $_GET['e'] ) ) : ?>
					<p><?php _e( 'Your account was activated successfully! Your account details have been sent to you in a separate email.', 'buddypress' ); ?></p>
				<?php else : ?>
					<p><?php printf( __( 'Your account was activated successfully! You can now <a href="%s">log in</a> with the username and password you provided when you signed up.', 'buddypress' ), wp_login_url( bp_get_root_domain() ) ); ?></p>
				<?php endif; ?>

			<?php else : ?>

				<p><?php _e( 'Please provide a valid activation key.', 'buddypress' ); ?></p>

				<form action="" method="post" class="form-horizontal" id="activation-form">
					<div class="form-group">
						<label for="key" class="col-sm-4 control-label"><?php _e( 'Activation Key:', 'buddypress' ); ?></label>
						<div class="col-sm-8">
							<input type="text" name="key" id="key" class="form-control" value="<?php echo esc_attr( bp_get_current_activation_key() ); ?>" />
						</div>
					</div>
					<div class="form-group">
    					<div class="col-sm-offset-4 col-sm-8">
					
							<input type="submit" name="submit" value="<?php esc_attr_e( 'Activate', 'buddypress' ); ?>" class="btn btn-primary " />
						</div>
					</div>

				</form>

				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/mascote_foca_quadrado_zoom_peq.png" />
				<br />
				<hr>
			<?php endif; ?>

			<?php do_action( 'bp_after_activate_content' ); ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_activation_page' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php #get_sidebar( 'buddypress' ); ?>

<?php get_footer( 'buddypress' ); ?>
