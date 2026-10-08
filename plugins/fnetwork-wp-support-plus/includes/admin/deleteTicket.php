<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();
$emailSettings=get_option( 'wpsp_email_notification_settings' );

if(!$current_user->has_cap('manage_support_plus_agent')){
	die();
}

$to=array();
if(get_bloginfo('admin_email')!=$current_user->ID){
	$to[]=get_bloginfo('admin_email');
}

$args=array('role'=>'wp_support_plus_supervisor');
$supervisors=get_users( $args );
foreach ($supervisors as $supervisor){
	if($supervisor->ID!=$current_user->ID){
		$to[]=$supervisor->user_email;
	}
}

$sql="select subject,created_by,guest_email
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );
if($ticket->created_by){
	if($ticket->created_by != $current_user->ID){
		$created_by=get_userdata($ticket->created_by);
		$to[]=$created_by->user_email;
	}
}
else {
	$to[]=$ticket->guest_email;
}

$subject='[Ticket #'.$_POST['ticket_id'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES));

$body='<table style="border:1px solid #000000;border-collapse: collapse;">';
$body.='<tr style="border:1px solid #000000;">
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Ticket</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Action</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Updated By</th>
		</tr>';
$body.='<tr style="border:1px solid #000000;">
			<td style="border:1px solid #000000;padding:2px;text-align:center;">#'.$_POST['ticket_id'].'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">Deleted</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$current_user->display_name.'</td>
		</tr>';
$body.='</table>';

$wpdb->delete( $wpdb->prefix.'wpsp_ticket_thread', array( 'ticket_id' => $_POST['ticket_id'] ) );
$wpdb->delete( $wpdb->prefix.'wpsp_ticket', array( 'id' => $_POST['ticket_id'] ) );

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

wp_mail($to,$subject,$body,$headers);
?>