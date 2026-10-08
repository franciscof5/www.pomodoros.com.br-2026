<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class SupportPlusAjax {
	function createNewTicket(){
		
		//catch JS injection
		if(stristr($_POST['create_ticket_body'],"<script>")){
			die("Javascript Injection not allowed!");
		}
		
		global $wpdb;
		
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
				
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
				}
				$upload = wp_handle_upload($daFile , array('test_form' => FALSE));
				//var_dump( $upload);
				$attachments[]=array(
					'name'=>$_FILES['attachment']['name'][$i],
					'file_path'=>$upload['file'],
					'file_url'=>$upload['url'],
					'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		$emailAttachments=array();
		foreach ($attachments as $attachment){
			$values=array(
				'filename'=>$attachment['name'],
				'filetype'=>$attachment['type'],
				'filepath'=>$attachment['file_path'],
				'fileurl'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'wpsp_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
			
			$emailAttachments[]=$attachment['file_path'];
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
		
		//create ticket
		$values=array(
				'subject'=>htmlspecialchars($_POST['create_ticket_subject'],ENT_QUOTES),
				'created_by'=>$_POST['user_id'],
				'guest_name'=>$_POST['guest_name'],
				'guest_email'=>$_POST['guest_email'],
				'type'=>$_POST['type'],
				'status'=>'open',
				'cat_id'=>$_POST['create_ticket_category'],
				'create_time'=>current_time('mysql', 1),
				'update_time'=>current_time('mysql', 1),
				'priority'=>$_POST['create_ticket_priority']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket',$values);
		$ticket_id=$wpdb->insert_id;
		
		//create thread
		$values=array(
				'ticket_id'=>$ticket_id,
				'body'=>htmlspecialchars($_POST['create_ticket_body'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
				'create_time'=>current_time('mysql', 1),
				'created_by'=>$_POST['user_id'],
				'guest_name'=>$_POST['guest_name'],
				'guest_email'=>$_POST['guest_email']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket_thread',$values);
		//check mail settings
		include_once( WCE_PLUGIN_DIR.'includes/admin/sendTicketCreateMail.php' );
		//end
		echo "1";die();
	}
	
	function replyTicket(){
	
		//catch JS injection
		if(stristr($_POST['replyBody'],"<script>")){
			die(__("Javascript Injection Not Allowed!",'wp-support-plus-responsive'));
		}
		
		global $wpdb;
	
		//CODE FOR ATTACHMENT START
		$attachments=array();
		if(isset($_FILES['attachment']) && $_FILES['attachment']['name'][0]!=''){
			//echo count($_FILES['attachment']['name']);
			for($i=0;$i<count($_FILES['attachment']['name']);$i++){
	
				$daFile = $_FILES['attachment'];
				foreach ($_FILES['attachment'] as $key => $value) {
					$daFile[$key] = $value[$i];
				}
				$upload = wp_handle_upload($daFile , array('test_form' => FALSE));
				//var_dump( $upload);
				$attachments[]=array(
						'name'=>$_FILES['attachment']['name'][$i],
						'file_path'=>$upload['file'],
						'file_url'=>$upload['url'],
						'type'=>$upload['type']
				);
			}
		}
		$attachment_ids=array();
		$emailAttachments=array();
		foreach ($attachments as $attachment){
			$values=array(
					'filename'=>$attachment['name'],
					'filetype'=>$attachment['type'],
					'filepath'=>$attachment['file_path'],
					'fileurl'=>$attachment['file_url']
			);
			$wpdb->insert($wpdb->prefix.'wpsp_attachments',$values);
			$attachment_ids[]= $wpdb->insert_id;
			
			$emailAttachments[]=$attachment['file_path'];
		}
		$attachment_ids=implode(',', $attachment_ids);
		//CODE FOR ATTACHMENT END
	
		//create ticket
		$values=array(
				'status'=>$_POST['reply_ticket_status'],
				'cat_id'=>$_POST['reply_ticket_category'],
				'update_time'=>current_time('mysql', 1),
				'priority'=>$_POST['reply_ticket_priority']
		);
		$wpdb->update($wpdb->prefix.'wpsp_ticket',$values,array('id' => $_POST['ticket_id']));
	
		//create thread
		$values=array(
				'ticket_id'=>$_POST['ticket_id'],
				'body'=>htmlspecialchars($_POST['replyBody'],ENT_QUOTES),
				'attachment_ids'=>$attachment_ids,
				'create_time'=>current_time('mysql', 1),
				'created_by'=>$_POST['user_id']
		);
		$wpdb->insert($wpdb->prefix.'wpsp_ticket_thread',$values);
		
		//check mail settings
		include_once( WCE_PLUGIN_DIR.'includes/admin/sendTicketReplyMail.php' );
		//end
		echo "1";die();
	}
	
	function getTickets(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getTicketsByFilter.php' );
		die();
	}
	
	function getFrontEndTickets(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getFrontEndTicket.php' );
		die();
	}
	
	function openTicket(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getIndivisualTicket.php' );
		die();
	}
	
	function openTicketFront(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getIndivisualTicketFront.php' );
		die();
	}
	
	function getAgentSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getAgentSettings.php' );
		die();
	}
	
	function setAgentSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setAgentSettings.php' );
		die();
	}
	
	function getGeneralSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getGeneralSettings.php' );
		die();
	}
	
	function setGeneralSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setGeneralSettings.php' );
		die();
	}
	
	function getCategories(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getCategories.php' );
		die();
	}
	
	function createNewCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/createNewCategory.php' );
		die();
	}
	
	function updateCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/updateCategory.php' );
		die();
	}
	
	function deleteCategory(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/deleteCategory.php' );
		die();
	}
	
	function getEmailNotificationSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getEmailNotificationSettings.php' );
		die();
	}
	
	function setEmailSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setEmailSettings.php' );
		die();
	}
	
	//version 2.0
	function getTicketAssignment(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getTicketAssignment.php' );
		die();
	}
	
	//version 2.0
	function setTicketAssignment(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setTicketAssignment.php' );
		die();
	}
	
	//Version 3.0
	function deleteTicket(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/deleteTicket.php' );
		die();
	}
	
	//Version 3.0
	function getChangeTicketStatus(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getChangeTicketStatus.php' );
		die();
	}
	
	//Version 3.0
	function setChangeTicketStatus(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setChangeTicketStatus.php' );
		die();
	}
	
	//Version 3.1
	function loginGuestFacebook(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/loginGuestFacebook.php' );
		die();
	}
	
	//Version 3.2
	function getChatOnlineAgents(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getChatOnlineAgents.php' );
		die();
	}
	
	//Version 3.2
	function getCallOnlineAgents(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getCallOnlineAgents.php' );
		die();
	}
	
	//version 3.9
	function getCreateTicketForm(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/create_new_ticket.php' );
		die();
	}
	
	//version 3.9
	function getCustomSliderMenus(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getCustomSliderMenus.php' );
		die();
	}
	
	//version 3.9
	function addCustomSliderMenu(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/addCustomSliderMenu.php' );
		die();
	}
	
	//version 3.9
	function deleteCustomSliderMenu(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/deleteCustomSliderMenu.php' );
		die();
	}
	
	//version 4.0
	function searchRegisteredUsaers(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/searchRegisteredUsaers.php' );
		die();
	}
	
	//version 4.3
	function getRollManagementSettings(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/getRollManagementSettings.php' );
		die();
	}
	
	function setRoleManagement(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/setRoleManagement.php' );
		die();
	}
}
?>