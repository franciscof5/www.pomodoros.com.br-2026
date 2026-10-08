<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();
$emailSettings=get_option( 'wpsp_email_notification_settings' );

$values=array(
		'status'=>$_POST['status'],
		'cat_id'=>$_POST['category'],
		'priority'=>$_POST['priority'],
		'update_time'=>current_time('mysql', 1),
		'updated_by'=>$current_user->ID
);
$wpdb->update($wpdb->prefix.'wpsp_ticket',$values,array('id'=>$_POST['ticket_id']));

$sql="select name
FROM {$wpdb->prefix}wpsp_catagories WHERE id=".$_POST['category'];
$category = $wpdb->get_row( $sql );

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

$subject='[Ticket #'.$_POST['ticket_id'].']['.$_POST['status'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES));

$body='<table style="border:1px solid #000000;border-collapse: collapse;">';
$body.='<tr style="border:1px solid #000000;">
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Ticket</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Status</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Category</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Priority</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Updated By</th>
		</tr>';
$body.='<tr style="border:1px solid #000000;">
			<td style="border:1px solid #000000;padding:2px;text-align:center;">#'.$_POST['ticket_id'].'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$_POST['status'].'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$category->name.'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$_POST['priority'].'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$current_user->display_name.'</td>
		</tr>';
$body.='</table>';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

wp_mail($to,$subject,$body,$headers);
?>