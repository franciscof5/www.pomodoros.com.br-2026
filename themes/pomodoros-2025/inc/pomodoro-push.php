<?php
/**
 * Server-side "pomodoro completed" push.
 *
 * Fired when a `projectimer_focus` post reaches `publish` (future -> publish)
 * or is sent directly by the completion trigger. Delegates to the Web Push
 * (VAPID) sender in inc/webpush.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

		update_post_meta( $post->ID, '_pomodoro_push_sent', 1 );

		$task = '' !== trim( (string) $post->post_title ) ? $post->post_title : __( 'Pomodoro', 'sis-foca-js' );

		$payload = array(
			'title' => __( 'Pomodoro concluído!', 'sis-foca-js' ),
			'body'  => sprintf( __( 'Você concluiu "%s". Hora do descanso!', 'sis-foca-js' ), $task ),
			'url'   => home_url( '/focus/' ),
			'tag'   => 'pomodoro-' . (int) $post->ID,
			'data'  => array(
				'type'    => 'pomodoro_complete',
				'post_id' => (int) $post->ID,
				'url'     => home_url( '/focus/' ),
			),
		);

		/**
		 * Filter the web push payload before it is sent.
		 *
		 * @param array   $payload Notification payload.
		 * @param WP_Post $post    The completed pomodoro post.
		 */
		$payload = apply_filters( 'pomodoro_push_payload', $payload, $post );

		pomo_webpush_send( $author_id, $payload );
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
