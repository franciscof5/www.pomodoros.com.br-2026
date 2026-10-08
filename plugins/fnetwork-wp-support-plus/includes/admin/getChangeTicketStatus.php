<?php 
global $wpdb;

$sql="select subject,type,status,cat_id,priority,created_by,guest_name,updated_by,assigned_to
FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>

<h3><?php _e('[Ticket #'.$_POST['ticket_id'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES)),'wp-support-plus-responsive');?></h3><br>

<table id="tblChangeStatusContainer">
  <tr>
    <td><?php _e('Status','wp-support-plus-responsive');?></td>
    <td>:</td>
    <td>
    	<select id="change_status_ticket_status">
			<option value="open" <?php echo ($ticket->status=='open')?'selected="selected"':'';?>><?php _e('Open','wp-support-plus-responsive');?></option>
			<?php if($ticket->type!='guest'){?>
			<option value="pending" <?php echo ($ticket->status=='pending')?'selected="selected"':'';?>><?php _e('Pending','wp-support-plus-responsive');?></option>
			<?php }?>
			<option value="closed" <?php echo ($ticket->status=='closed')?'selected="selected"':'';?>><?php _e('Closed','wp-support-plus-responsive');?></option>
		</select>
    </td>
  </tr>
  <tr>
    <td><?php _e('Category','wp-support-plus-responsive');?></td>
    <td>:</td>
    <td>
    	<select id="change_status_category">
			<?php 
			foreach ($categories as $category){
				$selected=($category->id==$ticket->cat_id)?'selected="selected"':'';
				echo '<option value="'.$category->id.'" '.$selected.'>'.__($category->name,'wp-support-plus-responsive').'</option>';
			}
			?>
		</select>
    </td>
  </tr>
  <tr>
    <td><?php _e('Priority','wp-support-plus-responsive');?></td>
    <td>:</td>
    <td>
    	<select id="change_status_priority">
			<option value="normal" <?php echo ($ticket->priority=='normal')?'selected="selected"':'';?>><?php _e('Normal','wp-support-plus-responsive');?></option>
			<option value="high" <?php echo ($ticket->priority=='high')?'selected="selected"':'';?>><?php _e('High','wp-support-plus-responsive');?></option>
			<option value="medium" <?php echo ($ticket->priority=='medium')?'selected="selected"':'';?>><?php _e('Medium','wp-support-plus-responsive');?></option>
			<option value="low" <?php echo ($ticket->priority=='low')?'selected="selected"':'';?>><?php _e('Low','wp-support-plus-responsive');?></option>
		</select>
    </td>
  </tr>
</table>

<button class="btn btn-success changeTicketSubBtn" onclick="backToTicketFromIndisual();"><?php _e('Cancel','wp-support-plus-responsive');?></button>
<button class="btn btn-success changeTicketSubBtn" onclick="setChangeTicketStatus(<?php echo $_POST['ticket_id'];?>);"><?php _e('Save Changes','wp-support-plus-responsive');?></button>