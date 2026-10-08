<form id="frmCreateNewTicketGeuest">
	<span class="label label-info" style="font-size: 13px;"><?php _e('Your Name','wp-support-plus-responsive');?></span><code>*</code><br>
	<input type="text" id="create_ticket_guest_name" name="guest_name" maxlength="20" style="width: 95%; margin-top: 10px;" /><br><br>
	<span class="label label-info" style="font-size: 13px;"><?php _e('Your Email','wp-support-plus-responsive');?></span><code>*</code><br>
	<input type="text" id="create_ticket_guest_email" name="guest_email" maxlength="50" style="width: 95%; margin-top: 10px;" /><br><br>
	<span class="label label-info" style="font-size: 13px;"><?php _e('Subject','wp-support-plus-responsive');?></span><code>*</code><br>
	<input type="text" id="create_ticket_subject" name="create_ticket_subject" maxlength="80" style="width: 95%; margin-top: 10px;"/><br><br>
	<span class="label label-info" style="font-size: 13px;"><?php _e('Description','wp-support-plus-responsive');?></span><code>*</code><br>
	<textarea id="create_ticket_body_guest" name="create_ticket_body" style="margin-top: 10px; width: 95%;" ></textarea><br><br>
	<div id="replyFloatedContainer" style="">
		<div class="replyFloatLeft">
			<span class="label label-info" style="font-size: 13px;"><?php _e('Category','wp-support-plus-responsive');?></span><br>
			<select id="create_ticket_category" name="create_ticket_category" style="margin-top: 10px;">
				<?php 
				foreach ($categories as $category){
					echo '<option value="'.$category->id.'">'.$category->name.'</option>';
				}
				?>
			</select><br><br>
		</div>
		<div class="replyFloatLeft">
			<span class="label label-info" style="font-size: 13px;"><?php _e('Priority','wp-support-plus-responsive');?></span><br>
			<select id="create_ticket_priority" name="create_ticket_priority" style="margin-top: 10px;">
				<option value="normal"><?php _e('Normal','wp-support-plus-responsive');?></option>
				<option value="high"><?php _e('High','wp-support-plus-responsive');?></option>
				<option value="medium"><?php _e('Medium','wp-support-plus-responsive');?></option>
				<option value="low"><?php _e('Low','wp-support-plus-responsive');?></option>
			</select>
		</div>
	</div>
	<br>
	<input type="hidden" name="action" value="createNewTicket">
	<input type="hidden" name="user_id" value="0">
	<input type="hidden" name="type" value="guest">
	<input type="submit" class="btn btn-success" value="<?php _e('Submit Ticket','wp-support-plus-responsive');?>">
	<input type="button" class="btn btn-success" value="<?php _e('Reset Form','wp-support-plus-responsive');?>" onClick="this.form.reset()" />
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	new nicEditor({fullPanel : true,maxHeight : 500}).panelInstance('create_ticket_body_guest');
});
</script>