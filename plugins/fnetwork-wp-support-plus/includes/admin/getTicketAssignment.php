<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

if(!$current_user->has_cap('manage_support_plus_agent')){
	echo "Sorry You don't have permission to access this!!!";
	die();
}

$sql="select subject,type,status,cat_id,priority,created_by,guest_name,updated_by,assigned_to
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$allUsers=get_users(array('orderby'=>'display_name'));
$agents=array();
foreach($allUsers as $user){

	if($user->has_cap('manage_support_plus_ticket')){
		$agents[] = $user;
	}

}
?>

<h3><?php _e('[Ticket #'.$_POST['ticket_id'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES)),'wp-support-plus-responsive');?></h3><br>

<span class="label label-info wpsp_title_label"><?php _e('Assign to','wp-support-plus-responsive');?></span><br><br>

<select id="assignTicketAgentId">
	<option <?php echo ($ticket->assigned_to==0)?'selected="selected"':'';?> value="0"><?php _e('None','wp-support-plus-responsive');?></option>
	<?php 
	foreach ($agents as $agent){
		?>
		<option <?php echo ($ticket->assigned_to==$agent->ID)?'selected="selected"':'';?> value="<?php echo $agent->ID;?>"><?php echo $agent->display_name;?></option>
		<?php 
	}
	?>
</select><br><br>
<button class="btn btn-success changeTicketSubBtn" onclick="backToTicketFromIndisual();"><?php _e('Cancel','wp-support-plus-responsive');?></button>
<button class="btn btn-success changeTicketSubBtn" onclick="setTicketAssignment(<?php echo $_POST['ticket_id'];?>);"><?php _e('Save Changes','wp-support-plus-responsive');?></button>