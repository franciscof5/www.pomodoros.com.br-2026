<?php 
$emailSettings=get_option( 'wpsp_email_notification_settings' );
?>
<br>
<span class="label label-info wpsp_title_label"><?php _e('Mail Settings','wp-support-plus-responsive');?></span><br><br>
<table id="tblEmailFrom">
  <tr>
    <td><?php _e('From Email:','wp-support-plus-responsive');?></td>
    <td><input type="text" id="txtFromEmail" value="<?php echo $emailSettings['default_from_email'];?>" /></td>
  </tr>
  <tr>
    <td><?php _e('From Name:','wp-support-plus-responsive');?></td>
    <td><input type="text" id="txtFromName" value="<?php echo $emailSettings['default_from_name'];?>"/></td>
  </tr>
</table>

<br>
<span class="label label-info wpsp_title_label"><?php _e('Notification Settings','wp-support-plus-responsive');?></span><br><br>
<table>
  <tr>
    <td id="cmbEmail_admin_new_ticket"><input <?php echo ($emailSettings['admin_new_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="email_admin_new_ticket" /></td>
    <td id="cmbEmail_admin_new_ticket_label"><?php _e('New Ticket Created','wp-support-plus-responsive');?></td>
  </tr>
</table>
<small><code>*</code><?php _e('This will send email notification to Administrator when new ticket has been created','wp-support-plus-responsive');?></small><br><br>
<table>
  <tr>
    <td id="cmbEmail_admin_reply_ticket"><input <?php echo ($emailSettings['admin_reply_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="email_admin_reply_ticket" /></td>
    <td id="cmbEmail_admin_reply_ticket"><?php _e('Ticket Reply','wp-support-plus-responsive');?></td>
  </tr>
</table>
<small><code>*</code><?php _e('This will send email notification to all Agent when any ticket has been updated','wp-support-plus-responsive');?></small><br><br>

<button class="btn btn-success" onclick="setEmailSettings();"><?php _e('Save Settings','wp-support-plus-responsive');?></button>