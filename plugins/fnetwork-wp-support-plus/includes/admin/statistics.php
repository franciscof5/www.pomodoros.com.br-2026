<?php 
global $wpdb;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='open'";
$tickets = $wpdb->get_results( $sql );
$total_open_ticket=$wpdb->num_rows;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='pending'";
$tickets = $wpdb->get_results( $sql );
$total_pending_ticket=$wpdb->num_rows;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='closed'";
$tickets = $wpdb->get_results( $sql );
$total_closed_ticket=$wpdb->num_rows;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='open' and assigned_to=0";
$tickets = $wpdb->get_results( $sql );
$total_none_open_ticket=$wpdb->num_rows;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='pending' and assigned_to=0";
$tickets = $wpdb->get_results( $sql );
$total_none_pending_ticket=$wpdb->num_rows;

$sql="select id from {$wpdb->prefix}wpsp_ticket where status='closed' and assigned_to=0";
$tickets = $wpdb->get_results( $sql );
$total_none_closed_ticket=$wpdb->num_rows;
?>
<style>
@-moz-document url-prefix() {
  fieldset { display: table-cell; }
}
</style>
<span class="label label-danger stat_heading"><?php _e('Open Tickets: '.$total_open_ticket,'wp-support-plus-responsive');?></span>
<span class="label label-warning stat_heading"><?php _e('Pending Tickets: '.$total_pending_ticket,'wp-support-plus-responsive');?></span>
<span class="label label-success stat_heading"><?php _e('Closed Tickets: '.$total_closed_ticket,'wp-support-plus-responsive');?></span><br><br>

<div class="table-responsive">
	<table class="table table-striped">
		<tr>
			<th><?php _e('Assigned to','wp-support-plus-responsive');?></th>
			<th><?php _e('Open Tickets','wp-support-plus-responsive');?></th>
			<th><?php _e('Pending Tickets','wp-support-plus-responsive');?></th>
			<th><?php _e('Closed Tickets','wp-support-plus-responsive');?></th>
		</tr>
		<tr>
			<td><?php _e('None','wp-support-plus-responsive');?></td>
			<td><span class="label label-danger stat_coloumn_lable"><?php _e($total_none_open_ticket,'wp-support-plus-responsive');?></span></td>
			<td><span class="label label-warning stat_coloumn_lable"><?php _e($total_none_pending_ticket,'wp-support-plus-responsive');?></span></td>
			<td><span class="label label-success stat_coloumn_lable"><?php _e($total_none_closed_ticket,'wp-support-plus-responsive');?></span></td>
		</tr>
		<?php 
		$allUsers=get_users(array('orderby'=>'display_name'));
		$agents=array();
		foreach($allUsers as $user){
		
			if($user->has_cap('manage_support_plus_ticket')){
				$agents[] = $user;
			}
		
		}
		
		foreach ($agents as $agent){
			$sql="select id from {$wpdb->prefix}wpsp_ticket where status='open' and assigned_to=".$agent->ID;
			$tickets = $wpdb->get_results( $sql );
			$total_agent_open_ticket=$wpdb->num_rows;
			
			$sql="select id from {$wpdb->prefix}wpsp_ticket where status='pending' and assigned_to=".$agent->ID;
			$tickets = $wpdb->get_results( $sql );
			$total_agent_pending_ticket=$wpdb->num_rows;
			
			$sql="select id from {$wpdb->prefix}wpsp_ticket where status='closed' and assigned_to=".$agent->ID;
			$tickets = $wpdb->get_results( $sql );
			$total_agent_closed_ticket=$wpdb->num_rows;
			
			echo '<tr>
						<td>'.$agent->display_name.'</td>
						<td><span class="label label-danger stat_coloumn_lable">'.__($total_agent_open_ticket,'wp-support-plus-responsive').'</span></td>
						<td><span class="label label-warning stat_coloumn_lable">'.__($total_agent_pending_ticket,'wp-support-plus-responsive').'</span></td>
						<td><span class="label label-success stat_coloumn_lable">'.__($total_agent_closed_ticket,'wp-support-plus-responsive').'</span></td>
				   </tr>';
		}
		?>
	</table>
</div>