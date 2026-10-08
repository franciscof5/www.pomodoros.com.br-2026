<?php 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
$allUsers=get_users(array('orderby'=>'display_name'));
$agents=array();
foreach($allUsers as $user){

	if($user->has_cap('manage_support_plus_ticket')){
		$agents[] = $user;
	}

}
?>
<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('Status:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_status">
					<option value="all"><?php _e('All','wp-support-plus-responsive');?></option>
					<option value="open"><?php _e('Open','wp-support-plus-responsive');?></option>
					<option value="pending"><?php _e('Pending','wp-support-plus-responsive');?></option>
					<option value="closed"><?php _e('Closed','wp-support-plus-responsive');?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('Type:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_type">
					<option value="all"><?php _e('All','wp-support-plus-responsive');?></option>
					<option value="user"><?php _e('User','wp-support-plus-responsive');?></option>
					<option value="guest"><?php _e('Guest','wp-support-plus-responsive');?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('Category:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_category">
					<option value="all"><?php _e('All','wp-support-plus-responsive');?></option>
					<?php 
					foreach ($categories as $category){
						echo '<option value="'.$category->id.'">'.$category->name.'</option>';
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('Assigned to:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_assigned_to">
					<option value="all"><?php _e('All','wp-support-plus-responsive');?></option>
					<option value="0"><?php _e('None','wp-support-plus-responsive');?></option>
					<?php 
					foreach ($agents as $agent){
						?>
						<option value="<?php echo $agent->ID;?>"><?php echo $agent->display_name;?></option>
						<?php 
					}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('Priority:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_priority">
					<option value="all"><?php _e('All','wp-support-plus-responsive');?></option>
					<option value="normal"><?php _e('Normal','wp-support-plus-responsive');?></option>
					<option value="high"><?php _e('High','wp-support-plus-responsive');?></option>
					<option value="medium"><?php _e('Medium','wp-support-plus-responsive');?></option>
					<option value="low"><?php _e('Low','wp-support-plus-responsive');?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_item">
	<table>
		<tr>
			<td><?php _e('No of Tickets:','wp-support-plus-responsive');?></td>
			<td>
				<select id="filter_by_no_of_ticket">
					<option value="10"><?php _e('10','wp-support-plus-responsive');?></option>
					<option value="20"><?php _e('20','wp-support-plus-responsive');?></option>
					<option value="30"><?php _e('30','wp-support-plus-responsive');?></option>
					<option value="40"><?php _e('40','wp-support-plus-responsive');?></option>
					<option value="50"><?php _e('50','wp-support-plus-responsive');?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="filter_search">
	<table>
		<tr>
			<td><input type="text" id="filter_by_search" placeholder="<?php _e('Search Tickets...','wp-support-plus-responsive');?>" /></td>
		</tr>
	</table>
</div>