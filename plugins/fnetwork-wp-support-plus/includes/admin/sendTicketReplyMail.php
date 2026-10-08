<?php 
$generalSettings=get_option( 'wpsp_general_settings' );
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$support_permalink=get_permalink($generalSettings['post_id']);

$sql="select subject,status,created_by,guest_email
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$subject='[Ticket #'.$_POST['ticket_id'].']['.$_POST['reply_ticket_status'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES));

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

$user_name='';
$signature='';
if($_POST['user_id']){
	$user=get_userdata($_POST['user_id']);
	$user_name=$user->display_name;

	$userSignature = $wpdb->get_row( "select signature FROM {$wpdb->prefix}wpsp_agent_settings WHERE agent_id=".$_POST['user_id'] );
	if($wpdb->num_rows){
		$signature='<br>---<br>'.stripcslashes($userSignature->signature);
		$signature=preg_replace("/(\r\n|\n|\r)/", '<br>', $signature);
	}
}
else{
	$user_name=$thread->guest_name;
}

$body='<b>'.$user_name.'</b> wrote:<br><br>';
$body.=stripcslashes($_POST['replyBody']);
$body.=$signature;
$body.='<br><br><a href="'.$support_permalink.'">'.$support_permalink.'</a>';

$emailToSend='';
if($ticket->created_by){
	$user=get_userdata( $ticket->created_by );
	$emailToSend=$user->user_email;
}
else {
	$emailToSend=$ticket->guest_email;
}
$to=array();
$to[]=$emailToSend;

$args=array('role'=>'wp_support_plus_supervisor');
$supervisors=get_users( $args );
foreach ($supervisors as $supervisor){
	if($supervisor->ID!=$current_user->ID){
		$to[]=$supervisor->user_email;
	}
}

if($emailSettings['admin_reply_ticket']){
	$to[]=get_bloginfo('admin_email');
}

wp_mail($to,$subject,$body,$headers,$emailAttachments);
?>
