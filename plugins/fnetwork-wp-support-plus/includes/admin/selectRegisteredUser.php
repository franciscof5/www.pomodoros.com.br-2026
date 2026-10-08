<form id="frmSearchRegisteredUser" onsubmit="searchRegisteredUserByKeyword();return false;">
	<input id="txtSearchRegUser" type="text" placeholder="<?php _e('Username or Email','wp-support-plus-responsive');?>"/>
	<button type="submit" class="btn btn-primary"><?php _e('Search','wp-support-plus-responsive');?></button>
</form>

<div id="wpsp_registered_user_container">
	
</div>

<div id="wpsp_search_reg_user_wait" style="text-align: center;height: 250px;">
	<img alt="Please Wait" style="margin-top: 120px;" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>">
</div>

<script type="text/javascript">
	function forceOpenFnetwork() {
		jQuery('#txtSearchRegUser').val('');
		jQuery('#wsp_change_user_modal').toggle(100);
	}
	jQuery('#wsp_change_user_modal .modal-footer button').click(function(){
		jQuery('#wsp_change_user_modal').toggle(100);
	})
	/**/
	function getSearchUserForm(){
		jQuery('#txtSearchRegUser').val('');
		searchRegisteredUserByKeyword();
		forceOpenFnetwork();
	}

	function searchRegisteredUserByKeyword(){
		jQuery('#wpsp_registered_user_container').hide();
		jQuery('#wpsp_search_reg_user_wait').show();
		
		var data = {
			'action': 'wpspSearchRegisteredUser',
			'search_keywords':jQuery('#txtSearchRegUser').val().trim()
		};

		jQuery.post('<?php echo admin_url( 'admin-ajax.php' );?>', data, function(response) {
			jQuery('#wpsp_search_reg_user_wait').hide();
			jQuery('#wpsp_registered_user_container').html(response);
			jQuery('#wpsp_registered_user_container').show();
		});
	}

	function wpspChangeUserFromSearchTable(user_id,user_name){
		jQuery('#create_ticket_as_user').val(user_name);
		jQuery('#create_ticket_as_user_id').val(user_id);
		jQuery('#wsp_change_user_modal').modal('hide');
	}
	
</script>