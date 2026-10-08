<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$generalSettings=get_option( 'wpsp_general_settings' );
$pages=get_pages( array('post_type' => 'page','post_status' => 'publish') );
$posts=get_posts( array('post_type' => 'post','post_status' => 'publish') );
?>
<br>
<span class="label label-info wpsp_title_label"><?php _e('Support Page/Post','wp-support-plus-responsive');?></span><br>
<select id="setSupportPage">
	<option value="0" <?php echo ($generalSettings['post_id']==0)?'selected="selected"':'';?>><?php _e('Select Page/Post','wp-support-plus-responsive');?></option>
	<optgroup label="Page">
		<?php 
		foreach ($pages as $page){
			$selected=($generalSettings['post_id']==$page->ID)?'selected="selected"':'';
			echo '<option '.$selected.' value="'.$page->ID.'">'.$page->post_title.'</option>';
		}
		?>
	</optgroup>
	<optgroup label="Post">
		<?php 
		foreach ($posts as $post){
			$selected=($generalSettings['post_id']==$post->ID)?'selected="selected"':'';
			echo '<option '.$selected.' value="'.$post->ID.'">'.$post->post_title.'</option>';
		}
		?>
	</optgroup>
</select><br>
<small><code>*</code><?php _e('Use shortcode','wp-support-plus-responsive');?> <code>[wp_support_plus]</code> <?php _e('in selected page/post above.','wp-support-plus-responsive');?></small>
<hr>

<span class="label label-info wpsp_title_label"><?php _e('Support Button','wp-support-plus-responsive');?></span><br><br>
<small><code>*</code><?php _e('If enabled, button will be shown on all pages of front-end which redirect to support page/post selected above on click.','wp-support-plus-responsive');?></small><br>
<table>
  <tr>
    <td class="tblGeneralStingsTdFirst"><input <?php echo ($generalSettings['enable_support_button']==1)?'checked="checked"':'';?> type="checkbox" id="setEnableSupportBtn" /></td>
    <td class="tblGeneralStingsTdSecond"><?php _e('Enable Support Button','wp-support-plus-responsive');?></td>
  </tr>
</table><br>
Button Position:<br>
<select id="setBtnPosition">
	<option value="top_left" <?php echo ($generalSettings['support_button_position']=='top_left')?'selected="selected"':'';?>><?php _e('Top Left','wp-support-plus-responsive');?></option>
	<option value="top_right" <?php echo ($generalSettings['support_button_position']=='top_right')?'selected="selected"':'';?>><?php _e('Top Right','wp-support-plus-responsive');?></option>
	<option value="bottom_left" <?php echo ($generalSettings['support_button_position']=='bottom_left')?'selected="selected"':'';?>><?php _e('Bottom Left','wp-support-plus-responsive');?></option>
	<option value="bottom_right" <?php echo ($generalSettings['support_button_position']=='bottom_right')?'selected="selected"':'';?>><?php _e('Bottom Right','wp-support-plus-responsive');?></option>
</select><br>
<hr>

<span class="label label-info wpsp_title_label"><?php _e('Guest Ticket','wp-support-plus-responsive');?></span><br><br>
<small><code>*</code><?php _e('If enabled, non logged-in user will able to raise ticket','wp-support-plus-responsive');?></small><br>
<table>
  <tr>
    <td class="tblGeneralStingsTdFirst"><input <?php echo ($generalSettings['enable_guest_ticket']==1)?'checked="checked"':'';?> type="checkbox" id="setEnableGuestTicket" /></td>
    <td class="tblGeneralStingsTdSecond"><?php _e('Enable Guest Tickets','wp-support-plus-responsive');?></td>
  </tr>
</table><br>
<hr>

<span class="label label-info wpsp_title_label"><?php _e('Facebook App Details','wp-support-plus-responsive');?></span><br><br>
<small><code>*</code><a data-toggle="modal" data-target="#wpl_facebook_modal"><?php _e('Click Here','wp-support-plus-responsive');?></a> for help to create App</small><br>
<table>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('App ID:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="text" id="fbAppID" value="<?php echo $generalSettings['fbAppID'];?>">
    </td>
  </tr>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('App Secret:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="text" id="fbAppSecret" value="<?php echo $generalSettings['fbAppSecret'];?>">
    </td>
  </tr>
</table><br>
<hr>

<span class="label label-info wpsp_title_label"><?php _e('Front End Support Panel','wp-support-plus-responsive');?></span><br><br>
<table>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('Enable:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="radio" name="rdbEnableSliderMenu" value="1" <?php echo ($generalSettings['enable_slider_menu']==1)?'checked="checked"':''; ?>> <?php _e('Yes','wp-support-plus-responsive');?> 
    	<input type="radio" name="rdbEnableSliderMenu" class="wpspRdbSecond" value="0" <?php echo ($generalSettings['enable_slider_menu']==0)?'checked="checked"':''; ?>> <?php _e('No','wp-support-plus-responsive');?>
    </td>
  </tr>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('Support Title:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="text" id="txtSupportTitle" value="<?php echo $generalSettings['support_title'];?>">
    </td>
  </tr>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('Phone Number:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="text" id="txtPhoneNumber" value="<?php echo $generalSettings['support_phone_number'];?>">
    </td>
  </tr>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('Display Skype Chat?:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="radio" name="rdbAvailableChat" value="1" <?php echo ($generalSettings['display_skype_chat']==1)?'checked="checked"':''; ?>> <?php _e('Yes','wp-support-plus-responsive');?> 
    	<input type="radio" name="rdbAvailableChat" class="wpspRdbSecond" value="0" <?php echo ($generalSettings['display_skype_chat']==0)?'checked="checked"':''; ?>> <?php _e('No','wp-support-plus-responsive');?>
    </td>
  </tr>
  <tr>
    <td class="facebookAppTdFirst"><?php _e('Display Skype Call?:','wp-support-plus-responsive');?></td>
    <td class="facebookAppTdFirst">
    	<input type="radio" name="rdbAvailableCall" value="1" <?php echo ($generalSettings['display_skype_call']==1)?'checked="checked"':''; ?>> <?php _e('Yes','wp-support-plus-responsive');?> 
    	<input type="radio" name="rdbAvailableCall" class="wpspRdbSecond" value="0" <?php echo ($generalSettings['display_skype_call']==0)?'checked="checked"':''; ?>> <?php _e('No','wp-support-plus-responsive');?>
    </td>
  </tr>
</table><br>
<hr>

<button class="btn btn-success" id="setGeneralSubBtn" onclick="setGeneralSettings();"><?php _e('Save Settings','wp-support-plus-responsive');?></button>

<div class="modal fade" id="wpl_facebook_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php _e('Facebook App Help','wp-support-plus-responsive');?></h4>
      </div>
      <div class="modal-body">
        <ol>
			<li><a href="https://developers.facebook.com/apps" target="_blank"><?php _e('Create your application','wp-support-plus-responsive');?></a></li>
			<li><?php _e('Look for Site URL field in the Website tab and enter','wp-support-plus-responsive');?> <b><?php echo get_site_url();?></b></li>
			<li><?php _e('After this, go to the','wp-support-plus-responsive');?> <a href="https://developers.facebook.com/apps" target="_blank"><?php _e('Facebook Application List','wp-support-plus-responsive');?></a> <?php _e('page and select your newly created application','wp-support-plus-responsive');?></li>
			<li><?php _e('Go to','wp-support-plus-responsive');?> <b><?php _e('Settings','wp-support-plus-responsive');?></b> <?php _e('and enter','wp-support-plus-responsive');?> <b><?php _e('Contact Email','wp-support-plus-responsive');?></b></li>
			<li><?php _e('Go to','wp-support-plus-responsive');?> <b><?php _e('Settings','wp-support-plus-responsive');?></b> --> <b><?php _e('+Add Platform','wp-support-plus-responsive');?></b> <?php _e('select','wp-support-plus-responsive');?> <b><?php _e('Website','wp-support-plus-responsive');?></b> <?php _e('and enter','wp-support-plus-responsive');?> <b><?php echo get_site_url();?></b></li>
			<li><?php _e('Go to','wp-support-plus-responsive');?> <b><?php _e('Status and Review','wp-support-plus-responsive');?></b><?php _e(' and','wp-support-plus-responsive');?> <b><?php _e('ON','wp-support-plus-responsive');?></b> <?php _e('available to the general public','wp-support-plus-responsive');?></li>
			<li><?php _e('Go to','wp-support-plus-responsive');?> <b><?php _e('Dashboard','wp-support-plus-responsive');?></b><?php _e(' and Copy the values from these fields:','wp-support-plus-responsive');?> <b><?php _e('App ID/API key','wp-support-plus-responsive');?></b><?php _e(' and','wp-support-plus-responsive');?> <b><?php _e('Application Secret','wp-support-plus-responsive');?></b><?php _e(', and enter in <b>Facebook App Settings','wp-support-plus-responsive');?></b></li>
		</ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','wp-support-plus-responsive');?></button>
      </div>
    </div>
  </div>
</div>