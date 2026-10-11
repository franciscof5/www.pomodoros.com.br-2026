<?php
/**
 * Server-side Web Push for completed pomodoros.
 *
 * When a `projectimer_focus` post transitions from `future` to `publish`
 * (i.e. a running focus timer finished, either because WordPress published
 * the scheduled post or because the client called save_progress("publish")),
 * we send a OneSignal notification to the post author only.
 *
 * This keeps working while the phone screen is locked or the app/browser is
 * closed. It relies on the OneSignal plugin settings (`OneSignalWPSetting`)
 * and on the client registering the WordPress user id as the OneSignal
 * external id (see pomodoro/focus-ui.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'pomodoro_push_credentials' ) ) {
	/**
	 * Read the OneSignal credentials configured by the OneSignal plugin.
	 *
	 * @return array|null { app_id, api_key } or null when not configured.
	 */
	function pomodoro_push_credentials() {
		$settings = get_option( 'OneSignalWPSetting' );

		if ( ! is_array( $settings ) ) {
			return null;
		}

		$app_id  = isset( $settings['app_id'] ) ? trim( (string) $settings['app_id'] ) : '';
		$api_key = isset( $settings['app_rest_api_key'] ) ? trim( (string) $settings['app_rest_api_key'] ) : '';

		if ( '' === $app_id || '' === $api_key ) {
			return null;
		}

		return array(
			'app_id'  => $app_id,
			'api_key' => $api_key,
		);
	}
}

if ( ! function_exists( 'pomodoro_push_post' ) ) {
	/**
	 * Send a notification payload to the OneSignal REST API.
	 *
	 * @param array $payload Notification payload.
	 * @param array $creds   Credentials from pomodoro_push_credentials().
	 * @return int HTTP status code (0 on WP_Error).
	 */
	function pomodoro_push_post( $payload, $creds ) {
		$response = wp_remote_post(
			'https://onesignal.com/api/v1/notifications',
			array(
				'headers' => array(
					'Content-Type'  => 'application/json; charset=utf-8',
					'Authorization' => 'Basic ' . $creds['api_key'],
				),
				'body'    => wp_json_encode( $payload ),
				'timeout' => 5,
			)
		);

		if ( is_wp_error( $response ) ) {
			return 0;
		}

		return (int) wp_remote_retrieve_response_code( $response );
	}
}

if ( ! function_exists( 'pomodoro_push_send_completion' ) ) {
	/**
	 * Send the "pomodoro completed" push to the author of the finished post.
	 *
	 * @param WP_Post $post The post that reached the publish status.
	 */
	function pomodoro_push_send_completion( $post ) {
		if ( ! $post instanceof WP_Post || 'projectimer_focus' !== $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post->ID, '_pomodoro_push_sent', true ) ) {
			return;
		}

		$author_id = (int) $post->post_author;
		if ( $author_id <= 0 ) {
			return;
		}

		$creds = pomodoro_push_credentials();
		if ( null === $creds ) {
			return;
		}

		update_post_meta( $post->ID, '_pomodoro_push_sent', 1 );

		$task = '' !== trim( (string) $post->post_title ) ? $post->post_title : __( 'Pomodoro', 'sis-foca-js' );

		$payload = array(
			'app_id'          => $creds['app_id'],
			'include_aliases' => array(
				'external_id' => array( (string) $author_id ),
			),
			'target_channel'  => 'push',
			'isAnyWeb'        => true,
			'headings'        => array(
				'en' => __( 'Pomodoro completed!', 'sis-foca-js' ),
				'pt' => __( 'Pomodoro concluído!', 'sis-foca-js' ),
			),
			'contents'        => array(
				'en' => sprintf( __( 'You finished "%s". Time to rest!', 'sis-foca-js' ), $task ),
				'pt' => sprintf( __( 'Você concluiu "%s". Hora do descanso!', 'sis-foca-js' ), $task ),
			),
			'url'             => home_url( '/focus/' ),
			'data'            => array(
				'type'       => 'pomodoro_complete',
				'post_id'    => (int) $post->ID,
				'focus_url'  => home_url( '/focus/' ),
			),
		);

		/**
		 * Filter the OneSignal payload before it is sent.
		 *
		 * @param array   $payload Notification payload.
		 * @param WP_Post $post    The completed pomodoro post.
		 */
		$payload = apply_filters( 'pomodoro_push_payload', $payload, $post );

		$status = pomodoro_push_post( $payload, $creds );

		if ( $status >= 400 ) {
			// Fall back to the legacy external-id targeting fields used by
			// older OneSignal apps / SDK v1.
			unset( $payload['include_aliases'], $payload['target_channel'] );
			$payload['include_external_user_ids']         = array( (string) $author_id );
			$payload['channel_for_external_user_ids']     = 'push';

			pomodoro_push_post( $payload, $creds );
		}
	}
}

if ( ! function_exists( 'pomodoro_push_on_transition' ) ) {
	/**
	 * React to a completed (scheduled) pomodoro being published.
	 *
	 * @param string  $new_status New post status.
	 * @param string  $old_status Previous post status.
	 * @param WP_Post $post       Post object.
	 */
	function pomodoro_push_on_transition( $new_status, $old_status, $post ) {
		if ( 'publish' !== $new_status || 'future' !== $old_status ) {
			return;
		}

		pomodoro_push_send_completion( $post );
	}
}

add_action( 'transition_post_status', 'pomodoro_push_on_transition', 20, 3 );
