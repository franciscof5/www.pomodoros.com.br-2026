<?php 
$generalSettings=get_option( 'wpsp_general_settings' );
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$support_permalink=get_permalink($generalSettings['post_id']);

$subject='[Ticket #'.$ticket_id.'][open] '.stripcslashes($_POST['create_ticket_subject']);

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
$body.=stripcslashes($_POST['create_ticket_body']);
$body.=$signature;
$body.='<br><br><a href="'.$support_permalink.'">'.$support_permalink.'</a>';

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

if($emailSettings['admin_new_ticket']){
	wp_mail($to,$subject,$body,$headers,$emailAttachments);
}
?>
