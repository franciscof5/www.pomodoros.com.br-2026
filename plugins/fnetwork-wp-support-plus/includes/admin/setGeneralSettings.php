<?php
$cu = wp_get_current_user();
if ($cu->has_cap('manage_options')) { 
	$generalSettings=array(
			'post_id'=>$_POST['post_id'],
			'enable_support_button'=>$_POST['enable_support_button'],
			'support_button_position'=>$_POST['support_button_position'],
			'enable_guest_ticket'=>$_POST['enable_guest_ticket'],
			'fbAppID'=>$_POST['fbAppID'],
			'fbAppSecret'=>$_POST['fbAppSecret'],
			'enable_slider_menu'=>$_POST['enable_slider_menu'],
			'support_title'=>$_POST['support_title'],
			'support_phone_number'=>$_POST['support_phone_number'],
			'display_skype_chat'=>$_POST['display_skype_chat'],
			'display_skype_call'=>$_POST['display_skype_call']
	);
	update_option('wpsp_general_settings',$generalSettings);
}
?>