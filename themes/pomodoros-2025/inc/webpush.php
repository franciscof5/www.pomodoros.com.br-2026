<?php
/**
 * Web Push (VAPID) notifications for Pomodoros.
 *
 * Delivers notifications from the server (on pomodoro completion) through the
 * system push service, so they arrive with the screen off and even when the
 * browser/app is closed. Uses minishlink/web-push with a PSR-18 client built
 * on WordPress' HTTP API (wp_remote_request), so no ext-curl is required.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'POMO_WEBPUSH_VAPID_PUBLIC' ) ) {
	define( 'POMO_WEBPUSH_VAPID_PUBLIC', 'BLRDbys7wXIWP7vJcI0VIhbCwF13iw99nrEHnneueR1rO3RpALyX4QyXyCqR3p7dylR7tO_64m6eJz47xw0X5aA' );
}
if ( ! defined( 'POMO_WEBPUSH_VAPID_PRIVATE' ) ) {
	define( 'POMO_WEBPUSH_VAPID_PRIVATE', '0X-jRZlTGwjjJSTbm2qbUIA0Ewtmm5kanay_gpicTI0' );
}
if ( ! defined( 'POMO_WEBPUSH_SUBJECT' ) ) {
	define( 'POMO_WEBPUSH_SUBJECT', 'mailto:francisco@f5sites.com' );
}

/**
 * Load the web-push library. Returns true when it is usable.
 */
function pomo_webpush_load() {
	static $ok = null;
	if ( null !== $ok ) {
		return $ok;
	}
	$autoload = get_stylesheet_directory() . '/vendor/autoload.php';
	if ( ! file_exists( $autoload ) ) {
		$ok = false;
		return $ok;
	}
	require_once $autoload;
	$ok = class_exists( 'Minishlink\\WebPush\\WebPush' ) && class_exists( 'Minishlink\\WebPush\\Subscription' );
	return $ok;
}

function pomo_webpush_subscriptions( $user_id ) {
	$subs = get_user_meta( $user_id, 'pomo_webpush', true );
	return is_array( $subs ) ? $subs : array();
}

/**
 * AJAX: store the browser push subscription for the current user.
 */
function pomo_webpush_save_subscription() {
	checkLogin();
	$user_id = get_current_user_id();
	$raw = isset( $_POST['subscription'] ) ? wp_unslash( $_POST['subscription'] ) : '';
	$sub = json_decode( $raw, true );

	if ( ! is_array( $sub ) || empty( $sub['endpoint'] ) || empty( $sub['keys']['p256dh'] ) || empty( $sub['keys']['auth'] ) ) {
		header( 'Content-type: application/json' );
		echo wp_json_encode( array( 'saved' => false ) );
		die;
	}

	$entry = array(
		'endpoint'  => esc_url_raw( $sub['endpoint'] ),
		'publicKey' => sanitize_text_field( $sub['keys']['p256dh'] ),
		'authToken' => sanitize_text_field( $sub['keys']['auth'] ),
		'created'   => time(),
	);

	$subs = pomo_webpush_subscriptions( $user_id );
	$out  = array();
	$found = false;
	foreach ( $subs as $s ) {
		if ( isset( $s['endpoint'] ) && $s['endpoint'] === $entry['endpoint'] ) {
			$out[] = $entry;
			$found = true;
		} else {
			$out[] = $s;
		}
	}
	if ( ! $found ) {
		$out[] = $entry;
	}
	update_user_meta( $user_id, 'pomo_webpush', $out );

	header( 'Content-type: application/json' );
	echo wp_json_encode( array( 'saved' => true, 'count' => count( $out ) ) );
	die;
}

/**
 * AJAX: remove a subscription (when the user disables notifications).
 */
function pomo_webpush_remove_subscription() {
	checkLogin();
	$user_id  = get_current_user_id();
	$endpoint = isset( $_POST['endpoint'] ) ? esc_url_raw( wp_unslash( $_POST['endpoint'] ) ) : '';
	$subs     = pomo_webpush_subscriptions( $user_id );
	$out      = array();
	foreach ( $subs as $s ) {
		if ( ! isset( $s['endpoint'] ) || $s['endpoint'] !== $endpoint ) {
			$out[] = $s;
		}
	}
	update_user_meta( $user_id, 'pomo_webpush', $out );
	header( 'Content-type: application/json' );
	echo wp_json_encode( array( 'removed' => true ) );
	die;
}

/**
 * Send a web push to all of a user's subscriptions.
 *
 * @param int   $user_id User id.
 * @param array $payload { title, body, url, tag, data }.
 * @return int Number of notifications accepted by the push service.
 */
function pomo_webpush_send( $user_id, $payload ) {
	if ( ! pomo_webpush_load() ) {
		return 0;
	}
	$subs = pomo_webpush_subscriptions( $user_id );
	if ( empty( $subs ) ) {
		return 0;
	}

	$auth = array(
		'VAPID' => array(
			'subject'    => POMO_WEBPUSH_SUBJECT,
			'publicKey'  => POMO_WEBPUSH_VAPID_PUBLIC,
			'privateKey' => POMO_WEBPUSH_VAPID_PRIVATE,
		),
	);

	try {
		$webPush = new \Minishlink\WebPush\WebPush( $auth, array(), 30 );
		$json    = wp_json_encode( $payload );

		foreach ( $subs as $s ) {
			if ( empty( $s['endpoint'] ) || empty( $s['publicKey'] ) || empty( $s['authToken'] ) ) {
				continue;
			}
			$subscription = \Minishlink\WebPush\Subscription::create( array(
				'endpoint'  => $s['endpoint'],
				'publicKey' => $s['publicKey'],
				'authToken' => $s['authToken'],
			) );
			$webPush->queueNotification( $subscription, $json );
		}

		$sent = 0;
		$gone = array();
		foreach ( $webPush->flush() as $report ) {
			if ( $report->isSuccess() ) {
				$sent++;
			} elseif ( $report->isSubscriptionExpired() ) {
				$gone[] = $report->getEndpoint();
			}
		}

		if ( $gone ) {
			$kept = array();
			foreach ( $subs as $s ) {
				if ( ! in_array( $s['endpoint'], $gone, true ) ) {
					$kept[] = $s;
				}
			}
			update_user_meta( $user_id, 'pomo_webpush', $kept );
		}

		return $sent;
	} catch ( \Throwable $e ) {
		error_log( 'pomo_webpush_send error: ' . $e->getMessage() );
		return 0;
	}
}

/**
 * Completion push scheduling.
 *
 * At the moment a pomodoro starts we store a "pending push" and schedule a
 * WP-Cron single event at its end time, so the notification is delivered by
 * the SERVER even if the phone screen is off or the browser/app is closed.
 */
function pomo_push_payload( $pending ) {
	$title = ! empty( $pending['title'] ) ? $pending['title'] : __( 'Pomodoro', 'sis-foca-js' );
	return array(
		'title' => __( 'Pomodoro concluído!', 'sis-foca-js' ),
		'body'  => sprintf( __( 'Você concluiu "%s". Hora do descanso!', 'sis-foca-js' ), $title ),
		'url'   => home_url( '/focus/' ),
		'tag'   => 'pomodoro',
		'data'  => array( 'type' => 'pomodoro_complete', 'url' => home_url( '/focus/' ) ),
	);
}

function pomo_push_schedule_pending( $post_id, $due_mysql, $title ) {
	$user_id = get_current_user_id();
	if ( ! $user_id ) {
		return;
	}
	$due = strtotime( $due_mysql );
	if ( ! $due ) {
		return;
	}
	update_user_meta( $user_id, 'pomo_push_pending', array(
		'post_id' => (int) $post_id,
		'due'     => (int) $due,
		'title'   => (string) $title,
	) );
	$prev = wp_next_scheduled( 'pomo_push_due', array( $user_id ) );
	if ( $prev ) {
		wp_unschedule_event( $prev, 'pomo_push_due', array( $user_id ) );
	}
	wp_schedule_single_event( $due, 'pomo_push_due', array( $user_id ) );
}

function pomo_push_cancel_pending() {
	$user_id = get_current_user_id();
	if ( ! $user_id ) {
		return;
	}
	$prev = wp_next_scheduled( 'pomo_push_due', array( $user_id ) );
	if ( $prev ) {
		wp_unschedule_event( $prev, 'pomo_push_due', array( $user_id ) );
	}
	delete_user_meta( $user_id, 'pomo_push_pending' );
}

function pomo_push_complete_now() {
	$user_id = get_current_user_id();
	if ( ! $user_id ) {
		return;
	}
	$pending = get_user_meta( $user_id, 'pomo_push_pending', true );
	$prev = wp_next_scheduled( 'pomo_push_due', array( $user_id ) );
	if ( $prev ) {
		wp_unschedule_event( $prev, 'pomo_push_due', array( $user_id ) );
	}
	delete_user_meta( $user_id, 'pomo_push_pending' );
	if ( is_array( $pending ) ) {
		pomo_webpush_send( $user_id, pomo_push_payload( $pending ) );
	}
}

add_action( 'pomo_push_due', 'pomo_push_due_handler' );
function pomo_push_due_handler( $user_id ) {
	$pending = get_user_meta( $user_id, 'pomo_push_pending', true );
	delete_user_meta( $user_id, 'pomo_push_pending' );
	if ( ! is_array( $pending ) ) {
		return;
	}
	pomo_webpush_send( $user_id, pomo_push_payload( $pending ) );
}
