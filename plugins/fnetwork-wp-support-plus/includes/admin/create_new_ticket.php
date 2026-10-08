<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
global $wpdb;
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );

global $current_user;
get_currentuserinfo();

?>
<h3><?php _e('Create New Ticket','wp-support-plus-responsive');?></h3>
<form id="frmCreateNewTicket">
	<?php if ($_POST['backend']){?>
	<span class="label label-info wpsp_title_label"><?php _e('Create Ticket As','wp-support-plus-responsive');?></span><br>
	<input style="margin-top: 5px;" type="text" id="create_ticket_as_user" name="create_ticket_as_user" disabled="disabled" value="<?php echo $current_user->display_name;?>" maxlength="80"/>
	<a data-toggle="modal" id="searchUserModal" data-target="#wsp_change_user_modal">
		<button class="btn btn-primary" onclick="getSearchUserForm();"><?php _e('Change User','wp-support-plus-responsive');?></button>
	</a>
	<button onclick="forceOpenFnetwork();" style="float: right;">FORCE OPEN CHANGE USER</button>
	<br><br>
	<?php }?>
	
	<span class="label label-info wpsp_title_label"><?php _e('Subject','wp-support-plus-responsive');?></span><br>
	<input type="text" id="create_ticket_subject" name="create_ticket_subject" maxlength="80"/><br><br>
	<span class="label label-info wpsp_title_label"><?php _e('Description','wp-support-plus-responsive');?></span><br>
	<textarea id="create_ticket_body" name="create_ticket_body" 	></textarea><br><br>
	<div>
		<span class="label label-info wpsp_title_label"><?php _e('Category','wp-support-plus-responsive');?></span><br>
		<select id="create_ticket_category" name="create_ticket_category">
			<?php 
			foreach ($categories as $category){
				echo '<option value="'.$category->id.'">'.__($category->name,'wp-support-plus-responsive').'</option>';
			}
			?>
		</select><br><br>
	</div>
	<div>
		<span class="label label-info wpsp_title_label"><?php _e('Priority','wp-support-plus-responsive');?></span><br>
		<select id="create_ticket_priority" name="create_ticket_priority">
			<option value="normal"><?php _e('Normal','wp-support-plus-responsive');?></option>
			<option value="high"><?php _e('High','wp-support-plus-responsive');?></option>
			<option value="medium"><?php _e('Medium','wp-support-plus-responsive');?></option>
			<option value="low"><?php _e('Low','wp-support-plus-responsive');?></option>
		</select>
	</div><br>
	<div>
		<span class="label label-info wpsp_title_label"><?php _e('Attach File(s)','wp-support-plus-responsive');?></span><br>
		<input class="create_ticket_attachment" type="file" name="attachment[]" multiple>
	</div><br>
	<input type="hidden" name="action" value="createNewTicket">
	<input type="hidden" id="create_ticket_as_user_id" name="user_id" value="<?php echo $current_user->ID;?>">
	<input type="hidden" name="type" value="user">
	<input type="hidden" name="guest_name" value="">
	<input type="hidden" name="guest_email" value="">
	<input type="submit" class="btn btn-success" value="<?php _e('Submit Ticket','wp-support-plus-responsive');?>">
	<input type="button" class="btn btn-success" value="<?php _e('Reset Form','wp-support-plus-responsive');?>" onClick="this.form.reset()" />
</form>

<?php if ($_POST['backend']){?>
<div class="modal fade" id="wsp_change_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php _e('Select User','wp-support-plus-responsive');?></h4>
      </div>
      <div class="modal-body">
        <?php include_once( WCE_PLUGIN_DIR.'includes/admin/selectRegisteredUser.php' );?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','wp-support-plus-responsive');?></button>
      </div>
    </div>
  </div>
</div>
<?php }?>