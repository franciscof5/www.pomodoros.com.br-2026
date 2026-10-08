<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;

//Roll & Capability
if(!get_role('wp_support_plus_agent')){
	add_role( 'wp_support_plus_agent', 'Support Agent' );
	$role = get_role( 'wp_support_plus_agent' );
	$role->add_cap( 'manage_support_plus_ticket' );
	$role->add_cap( 'read' );
	$role = get_role( 'administrator' );
	$role->add_cap( 'manage_support_plus_ticket' );
}

//supervisor roll- added in 2.0
if(!get_role('wp_support_plus_supervisor')){
	add_role( 'wp_support_plus_supervisor', 'Support Supervisor' );
	$role = get_role( 'wp_support_plus_supervisor' );
	$role->add_cap( 'manage_support_plus_ticket' );
	$role->add_cap( 'manage_support_plus_agent' );
	$role->add_cap( 'read' );
	$role = get_role( 'administrator' );
	$role->add_cap( 'manage_support_plus_agent' );
}

//Database
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_ticket'") != $wpdb->prefix . 'wpsp_ticket'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_ticket (
	id integer not null auto_increment,
	subject TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	created_by integer,
	guest_name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	guest_email TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	type TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	status TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	cat_id integer,
	create_time datetime,
	update_time datetime,
	priority TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
//added in version 2.0
$sql = "SHOW COLUMNS FROM {$wpdb->prefix}wpsp_ticket LIKE 'assigned_to'";
if(!$wpdb->get_var($sql) )
{
	$sql = "alter table {$wpdb->prefix}wpsp_ticket ADD assigned_to INT NOT NULL DEFAULT '0' after created_by";
	$wpdb->query($sql);
}
//added in version 2.0
$sql = "SHOW COLUMNS FROM {$wpdb->prefix}wpsp_ticket LIKE 'updated_by'";
if(!$wpdb->get_var($sql) )
{
	$sql = "alter table {$wpdb->prefix}wpsp_ticket ADD updated_by INT NOT NULL DEFAULT '0' after created_by";
	$wpdb->query($sql);
}

if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_ticket_thread'") != $wpdb->prefix . 'wpsp_ticket_thread'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_ticket_thread (
	id integer not null auto_increment,
	ticket_id integer,
	body LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	attachment_ids TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	create_time datetime,
	created_by integer,
	guest_name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	guest_email TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_attachments'") != $wpdb->prefix . 'wpsp_attachments'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_attachments (
	id integer not null auto_increment,
	filename TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	filetype TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	filepath TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	fileurl TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
	
	PRIMARY KEY (id)
	);");
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_catagories'") != $wpdb->prefix . 'wpsp_catagories'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_catagories (
	id integer not null auto_increment,
	name TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

	PRIMARY KEY (id)
	);");
	
	$wpdb->insert($wpdb->prefix.'wpsp_catagories',array('name'=>'General'));
}
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_agent_settings'") != $wpdb->prefix . 'wpsp_agent_settings'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_agent_settings (
	id integer not null auto_increment,
	agent_id integer NULL DEFAULT NULL,
	signature LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

	PRIMARY KEY (id)
	);");
}
//added in version 4.0
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wpsp_panel_custom_menu'") != $wpdb->prefix . 'wpsp_panel_custom_menu'){
	$wpdb->query("CREATE TABLE {$wpdb->prefix}wpsp_panel_custom_menu (
	id integer not null auto_increment,
	menu_text varchar(50),
	menu_icon varchar(200),
	redirect_url varchar(200),
	
	PRIMARY KEY (id)
	);");
}
//added in version 3.2
$sql = "SHOW COLUMNS FROM {$wpdb->prefix}wpsp_agent_settings LIKE 'skype_id'";
if(!$wpdb->get_var($sql) )
{
	$sql = "alter table {$wpdb->prefix}wpsp_agent_settings ADD skype_id TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL after signature";
	$wpdb->query($sql);
}
//added in version 3.2
$sql = "SHOW COLUMNS FROM {$wpdb->prefix}wpsp_agent_settings LIKE 'skype_chat_availability'";
if(!$wpdb->get_var($sql) )
{
	$sql = "alter table {$wpdb->prefix}wpsp_agent_settings ADD skype_chat_availability INT NOT NULL DEFAULT '0' after skype_id";
	$wpdb->query($sql);
}
//added in version 3.2
$sql = "SHOW COLUMNS FROM {$wpdb->prefix}wpsp_agent_settings LIKE 'skype_call_availability'";
if(!$wpdb->get_var($sql) )
{
	$sql = "alter table {$wpdb->prefix}wpsp_agent_settings ADD skype_call_availability INT NOT NULL DEFAULT '0' after skype_chat_availability";
	$wpdb->query($sql);
}

//default settings
if( get_option( 'wpsp_general_settings' ) === false ) {
	$generalSettings=array(
		'post_id'=>0,
		'enable_support_button'=>1,
		'support_button_position'=>'bottom_left',
		'enable_guest_ticket'=>0
	);
	update_option('wpsp_general_settings',$generalSettings);
}
if( get_option( 'wpsp_email_notification_settings' ) === false ) {
	$emailSettings=array(
			'admin_new_ticket'=>1,
			'admin_reply_ticket'=>1
	);
	update_option('wpsp_email_notification_settings',$emailSettings);
}

//default email change in 2.1
$emailSettings=get_option( 'wpsp_email_notification_settings' );
if(!isset($emailSettings['default_from_email'])){
	$from_name = "WordPress";
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
		$sitename = substr( $sitename, 4 );
	}
	$default_from_email = 'wordpress@' . $sitename;

	$emailSettings['default_from_email']=$default_from_email;
	$emailSettings['default_from_name']=$from_name;

	update_option('wpsp_email_notification_settings',$emailSettings);
}

//version 3.1
$generalSettings=get_option( 'wpsp_general_settings' );
if(!isset($generalSettings['fbAppID'])){
	$generalSettings['fbAppID']='';
	$generalSettings['fbAppSecret']='';
	update_option('wpsp_general_settings',$generalSettings);
}
//version 3.2
if(!isset($generalSettings['support_title'])){
	$generalSettings['support_title']='Need Help?';
	$generalSettings['support_phone_number']='';
	$generalSettings['display_skype_chat']=1;
	$generalSettings['display_skype_call']=1;
	update_option('wpsp_general_settings',$generalSettings);
}
//version 4.0
if(!isset($generalSettings['enable_slider_menu'])){
	$generalSettings['enable_slider_menu']=1;
	update_option('wpsp_general_settings',$generalSettings);
}
//version 4.3
$roleManage=get_option( 'wpsp_role_management' );
if(!isset($roleManage['agents'])){
	$agents = array();
	$supervisors=array();
	
	$roleManage['agents']=$agents;
	$roleManage['supervisors']=$supervisors;
	
	update_option('wpsp_role_management',$roleManage);
}
?>