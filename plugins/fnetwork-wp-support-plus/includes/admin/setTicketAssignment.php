<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();
$emailSettings=get_option( 'wpsp_email_notification_settings' );

if(!$current_user->has_cap('manage_support_plus_agent')){
	die();
}

$values=array(
		'assigned_to'=>$_POST['agent_id'],
		'update_time'=>current_time('mysql', 1),
		'updated_by'=>$current_user->ID
);
$wpdb->update($wpdb->prefix.'wpsp_ticket',$values,array('id'=>$_POST['ticket_id']));

if($_POST['agent_id']==0){ die(); }

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

$agent=get_userdata( $_POST['agent_id'] );
$to[]=$agent->user_email;

$subject='[Ticket #'.$_POST['ticket_id'].'] assigned to '.$agent->display_name.' by '.$current_user->display_name;

$body='<table style="border:1px solid #000000;border-collapse: collapse;">';
$body.='<tr style="border:1px solid #000000;">
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Ticket</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Assigned to</th>
			<th style="border:1px solid #000000;padding:2px;text-align:center;">Updated By</th>
		</tr>';
$body.='<tr style="border:1px solid #000000;">
			<td style="border:1px solid #000000;padding:2px;text-align:center;">#'.$_POST['ticket_id'].'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$agent->display_name.'</td>
			<td style="border:1px solid #000000;padding:2px;text-align:center;">'.$current_user->display_name.'</td>
		</tr>';
$body.='</table>';

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= 'From: '.$emailSettings['default_from_name'].' <'.$emailSettings['default_from_email'].'>' . "\r\n";

wp_mail($to,$subject,$body,$headers);
?>