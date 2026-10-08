<?php 
/**
 * Plugin Name: WP Support Plus - kingtheme.net
 * Plugin URI: http://pradeepmakone.com/wpsupportplus/
 * Description: Easy to use Customer Support System in Wordpress itself!
 * License: GPL v3
 * Version: 4.3
 * Author: pradeepmakone
 * Author URI: http://profiles.wordpress.org/pradeepmakone07/
 * Text Domain: wp-support-plus-responsive
 * Domain Path: /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlus{
	public function __construct() {
		$this->define_constants();
		
		add_action( 'plugins_loaded', array($this,'load_textdomain') );
		
		register_activation_hook( __FILE__, array($this,'installation') );
		$this->installation();
		$this->include_files();
		
		//mail filters
		add_filter('wp_mail_from',array($this,'setMailFrom'));
		add_filter('wp_mail_from_name',array($this,'setMailFromName'));
	}
	
	function load_textdomain(){
		load_plugin_textdomain( 'wp-support-plus-responsive',plugin_dir_path( __FILE__ ).'/lang' , 'wp-support-plus/lang' );
	}
	
	function setMailFrom($content_type){
		$emailSettings=get_option( 'wpsp_email_notification_settings' );
		return $emailSettings['default_from_email'];
	}
	
	function setMailFromName($name){
		$emailSettings=get_option( 'wpsp_email_notification_settings' );
		return $emailSettings['default_from_name'];
	}
	
	private function define_constants() {
		define( 'WCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'WCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WCE_VERSION', '2.0' );
	}
	
	private function include_files(){
		if (is_admin()) {
			include_once( WCE_PLUGIN_DIR.'includes/admin/admin.php' );
			include_once( WCE_PLUGIN_DIR.'includes/admin/ajax.php' );
			$ajax=new SupportPlusAjax();
			add_action( 'wp_ajax_createNewTicket', array( $ajax, 'createNewTicket' ) );
			add_action( 'wp_ajax_nopriv_createNewTicket', array( $ajax, 'createNewTicket' ) );
			add_action( 'wp_ajax_getTickets', array( $ajax, 'getTickets' ) );
			#add_action( 'wp_ajax_getFrontEndTickets', array( $ajax, 'getTickets' ) );
			add_action( 'wp_ajax_getFrontEndTickets', array( $ajax, 'getFrontEndTickets' ) );
			add_action( 'wp_ajax_openTicket', array( $ajax, 'openTicket' ) );
			add_action( 'wp_ajax_openTicketFront', array( $ajax, 'openTicketFront' ) );
			add_action( 'wp_ajax_replyTicket', array( $ajax, 'replyTicket' ) );
			add_action( 'wp_ajax_getAgentSettings', array( $ajax, 'getAgentSettings' ) );
			add_action( 'wp_ajax_setAgentSettings', array( $ajax, 'setAgentSettings' ) );
			add_action( 'wp_ajax_getGeneralSettings', array( $ajax, 'getGeneralSettings' ) );
			add_action( 'wp_ajax_setGeneralSettings', array( $ajax, 'setGeneralSettings' ) );
			add_action( 'wp_ajax_getCategories', array( $ajax, 'getCategories' ) );
			add_action( 'wp_ajax_createNewCategory', array( $ajax, 'createNewCategory' ) );
			add_action( 'wp_ajax_updateCategory', array( $ajax, 'updateCategory' ) );
			add_action( 'wp_ajax_deleteCategory', array( $ajax, 'deleteCategory' ) );
			add_action( 'wp_ajax_getEmailNotificationSettings', array( $ajax, 'getEmailNotificationSettings' ) );
			add_action( 'wp_ajax_setEmailSettings', array( $ajax, 'setEmailSettings' ) );
			//version 2.0
			add_action( 'wp_ajax_getTicketAssignment', array( $ajax, 'getTicketAssignment' ) );
			add_action( 'wp_ajax_setTicketAssignment', array( $ajax, 'setTicketAssignment' ) );
			//version 3.0
			add_action( 'wp_ajax_deleteTicket', array( $ajax, 'deleteTicket' ) );
			add_action( 'wp_ajax_getChangeTicketStatus', array( $ajax, 'getChangeTicketStatus' ) );
			add_action( 'wp_ajax_setChangeTicketStatus', array( $ajax, 'setChangeTicketStatus' ) );
			//version 3.1
			add_action( 'wp_ajax_nopriv_loginGuestFacebook', array( $ajax, 'loginGuestFacebook' ) );
			//version 3.2
			add_action( 'wp_ajax_nopriv_getChatOnlineAgents', array( $ajax, 'getChatOnlineAgents' ) );
			add_action( 'wp_ajax_getChatOnlineAgents', array( $ajax, 'getChatOnlineAgents' ) );
			add_action( 'wp_ajax_nopriv_getCallOnlineAgents', array( $ajax, 'getCallOnlineAgents' ) );
			add_action( 'wp_ajax_getCallOnlineAgents', array( $ajax, 'getCallOnlineAgents' ) );
			//version 3.9
			add_action( 'wp_ajax_getCreateTicketForm', array( $ajax, 'getCreateTicketForm' ) );
			add_action( 'wp_ajax_getCustomSliderMenus', array( $ajax, 'getCustomSliderMenus' ) );
			add_action( 'wp_ajax_addCustomSliderMenu', array( $ajax, 'addCustomSliderMenu' ) );
			add_action( 'wp_ajax_deleteCustomSliderMenu', array( $ajax, 'deleteCustomSliderMenu' ) );
			add_action( 'wp_ajax_nopriv_createNewTicket', array( $ajax, 'createNewTicket' ) );
			//version 4.0
			add_action( 'wp_ajax_wpspSearchRegisteredUser', array( $ajax, 'searchRegisteredUsaers' ) );
			//version 4.3
			add_action( 'wp_ajax_getRollManagementSettings', array( $ajax, 'getRollManagementSettings' ) );
			add_action( 'wp_ajax_setRoleManagement', array( $ajax, 'setRoleManagement' ) );
		}
		else {
 			include_once( WCE_PLUGIN_DIR.'includes/shortcode.php' );
 			#include_once( WCE_PLUGIN_DIR.'includes/support_button.php' );
		}
	}
	
	function installation(){
		include( WCE_PLUGIN_DIR.'includes/admin/installation.php' );
	}
}

$GLOBALS['WPSupportPlus'] =new WPSupportPlus();
?>
