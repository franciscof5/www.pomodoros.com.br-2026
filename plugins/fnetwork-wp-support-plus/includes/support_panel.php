<?php 
global $wpdb;
$sql="select * from {$wpdb->prefix}wpsp_panel_custom_menu";
$menus=$wpdb->get_results($sql);
?>

<div id="support_panel_title">
	<img class="support_panel_icon" src="<?php echo WCE_PLUGIN_URL.'asset/images/support_icon.jpg';?>" >
	<div id="support_panel_title_text"><?php echo $generalSettings['support_title'];?></div>
	<img id="support_panel_close" src="<?php echo WCE_PLUGIN_URL.'asset/images/close.gif';?>" >
</div>
<?php if($generalSettings['support_phone_number']){?>
<div id="support_call_phone_number" class="front_support_menu">
	<img class="support_panel_icon" src="<?php echo WCE_PLUGIN_URL.'asset/images/call.png';?>" >
	<div class="support_panel_menu_text"><?php echo __($generalSettings['support_phone_number'],'wp-support-plus-responsive');?></div>
</div>
<?php }?>
<?php if($generalSettings['display_skype_chat']){?>
<div id="support_skype_chat" class="front_support_menu">
	<img class="support_panel_icon" src="<?php echo WCE_PLUGIN_URL.'asset/images/Skype-icon.png';?>" >
	<div class="support_panel_menu_text"><?php _e('Skype Chat','wp-support-plus-responsive');?></div>
</div>
<?php }?>
<?php if($generalSettings['display_skype_call']){?>
<div id="support_skype_call" class="front_support_menu">
	<img class="support_panel_icon" src="<?php echo WCE_PLUGIN_URL.'asset/images/skype_phone.png';?>" >
	<div class="support_panel_menu_text"><?php _e('Skype Call','wp-support-plus-responsive');?></div>
</div>
<?php }?>
<?php foreach ($menus as $menu){?>
	<a href="<?php echo $menu->redirect_url;?>" >
		<div class="front_support_menu">
			<img class="support_panel_icon" src="<?php echo $menu->menu_icon;?>" >
			<div class="support_panel_menu_text"><?php echo $menu->menu_text;?></div>
		</div>
	</a>
<?php }?>
<div id="support_page_redirect" class="front_support_menu">
	<img class="support_panel_icon" src="<?php echo WCE_PLUGIN_URL.'asset/images/support-icon.png';?>" >
	<div class="support_panel_menu_text"><?php _e('Support Ticket','wp-support-plus-responsive');?></div>
</div>