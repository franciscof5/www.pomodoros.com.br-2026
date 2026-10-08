jQuery(document).ready(function(){
	getGeneralSettings();
	jQuery('#tab_general_container').click(function(){
		getGeneralSettings();
	});
	jQuery('#tab_category_container').click(function(){
		getCategorySettings();
	});
	jQuery('#tab_mail_container').click(function(){
		getMailSettings();
	});
	jQuery('#tab_slider_menu_container').click(function(){
		getCustomSliderMenus();
	});
	jQuery('#tab_role_manege_menu_container').click(function(){
		getRollManagementSettings();
	});
});

function getGeneralSettings(){
	jQuery('#settingsGeneral .settingsGeneralContainer').hide();
	jQuery('#settingsGeneral .wait').show();
	
	var data = {
		'action': 'getGeneralSettings'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsGeneral .wait').hide();
		jQuery('#settingsGeneral .settingsGeneralContainer').html(response);
		jQuery('#settingsGeneral .settingsGeneralContainer').show();
	});
}

function setGeneralSettings(){
	jQuery('#settingsGeneral .settingsGeneralContainer').hide();
	jQuery('#settingsGeneral .wait').show();
	var enable_btn=0;
	if(jQuery('#setEnableSupportBtn').is(':checked')){
		enable_btn=1;
	}
	var enable_guest_ticket=0;
	if(jQuery('#setEnableGuestTicket').is(':checked')){
		enable_guest_ticket=1;
	}
	var data = {
		'action': 'setGeneralSettings',
		'post_id': jQuery('#setSupportPage').val(),
		'enable_support_button':enable_btn,
		'support_button_position':jQuery('#setBtnPosition').val(),
		'enable_guest_ticket':enable_guest_ticket,
		'fbAppID': jQuery('#fbAppID').val(),
		'fbAppSecret': jQuery('#fbAppSecret').val(),
		'enable_slider_menu':jQuery('input[name=rdbEnableSliderMenu]:checked').val(),
		'support_title': jQuery('#txtSupportTitle').val(),
		'support_phone_number': jQuery('#txtPhoneNumber').val(),
		'display_skype_chat': jQuery('input[name=rdbAvailableChat]:checked').val(),
		'display_skype_call': jQuery('input[name=rdbAvailableCall]:checked').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getGeneralSettings();
	});
}

function getCategorySettings(){
	jQuery('#settingsCategories .wait').show();
	jQuery('#settingsCategories .settingsCategoriesContainer').hide();
	
	var data = {
		'action': 'getCategories'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsCategories .wait').hide();
		jQuery('#settingsCategories .settingsCategoriesContainer').html(response);
		jQuery('#settingsCategories .settingsCategoriesContainer').show();
	});
}

function getMailSettings(){
	jQuery('#settingsMail .wait').show();
	jQuery('#settingsMail .settingsMailContainer').hide();
	
	var data = {
		'action': 'getEmailNotificationSettings'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsMail .wait').hide();
		jQuery('#settingsMail .settingsMailContainer').html(response);
		jQuery('#settingsMail .settingsMailContainer').show();
	});
}

function createNewCategory(){
	if(jQuery('#newCatName').val().trim()!=''){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'createNewCategory',
			'cat_name':jQuery('#newCatName').val()
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
	else{
		alert('Please insert category name!');
		jQuery('#newCatName').val('');
		jQuery('#newCatName').focus();
	}
}

function editCategory(id,name){
	jQuery('#editCategoryContainer').show();
	jQuery('#editCatID').val(id);
	jQuery('#editCatName').val(name);
	window.location.href='#editCategoryContainer';
	jQuery('#editCatName').focus();
}

function updateCategory(){
	if(jQuery('#editCatName').val().trim()!=''){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'updateCategory',
			'cat_id': jQuery('#editCatID').val(),
			'cat_name':jQuery('#editCatName').val()
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
	else{
		alert('Please insert category name!');
		jQuery('#editCatName').val('');
		jQuery('#editCatName').focus();
	}
}

function deleteCategory(id,name){
	var str="All Tickets in this category will be moved to General.\nAre you sure to delete '"+name+"'?";
	if(confirm(str)){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'deleteCategory',
			'cat_id': id
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
}

function setEmailSettings(){
	jQuery('#settingsMail .wait').show();
	jQuery('#settingsMail .settingsMailContainer').hide();
	var admin_new_ticket=0;
	if(jQuery('#email_admin_new_ticket').is(':checked')){
		admin_new_ticket=1;
	}
	var admin_reply_ticket=0;
	if(jQuery('#email_admin_reply_ticket').is(':checked')){
		admin_reply_ticket=1;
	}
	var data = {
		'action': 'setEmailSettings',
		'admin_new_ticket': admin_new_ticket,
		'admin_reply_ticket':admin_reply_ticket,
		'default_from_email': jQuery('#txtFromEmail').val(),
		'default_from_name': jQuery('#txtFromName').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getMailSettings();
	});
}

function getCustomSliderMenus(){
	jQuery('#settingsCustomSliderMenu .wait').show();
	jQuery('#settingsCustomSliderMenu .settingsSliderMenuContainer').hide();
	
	var data = {
		'action': 'getCustomSliderMenus'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsCustomSliderMenu .wait').hide();
		jQuery('#settingsCustomSliderMenu .settingsSliderMenuContainer').html(response);
		jQuery('#settingsCustomSliderMenu .settingsSliderMenuContainer').show();
	});
}

function change_default_menu_icon(){
	tb_show('', 'media-upload.php?type=image&amp;amp;amp;TB_iframe=true');
		
	/* temporarily redefine send_to_editor() */
	window.send_to_editor = function(html)
	{
		imgurl = jQuery('img',html).attr('src');
		jQuery("#custom_menu_icon").val(imgurl); /*assign the value of the image src to the input*/
		jQuery("#cusom_slider_menu_icon").attr('src',imgurl);
		tb_remove();
	};
	return false;
}

function create_custom_panel_menu(){
	if(jQuery('#custom_menu_text').val().trim()==''){
		alert('Please insert menu text');
		jQuery('#custom_menu_text').focus();
		return;
	}
	if(jQuery('#custom_menu_url').val().trim()==''){
		alert('Please insert Redirect URL');
		jQuery('#custom_menu_url').focus();
		return;
	}
	jQuery('#settingsCustomSliderMenu .wait').show();
	jQuery('#settingsCustomSliderMenu .settingsSliderMenuContainer').hide();
	
	var data = {
		'action': 'addCustomSliderMenu',
		'custom_menu_text': jQuery('#custom_menu_text').val().trim(),
		'custom_menu_url': jQuery('#custom_menu_url').val().trim(),
		'custom_menu_icon': jQuery('#custom_menu_icon').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getCustomSliderMenus();
	});
}

function delete_custom_menu(menu_id){
	if(confirm('Are you sure?')){
		jQuery('#settingsCustomSliderMenu .wait').show();
		jQuery('#settingsCustomSliderMenu .settingsSliderMenuContainer').hide();
		
		var data = {
			'action': 'deleteCustomSliderMenu',
			'menu_id': menu_id
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCustomSliderMenus();
		});
	}
}

function getRollManagementSettings(){
	jQuery('#settingsRoleManegementMenu .wait').show();
	jQuery('#settingsRoleManegementMenu .settingsRoleManegementMenuContainer').hide();
	
	var data = {
		'action': 'getRollManagementSettings'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsRoleManegementMenu .wait').hide();
		jQuery('#settingsRoleManegementMenu .settingsRoleManegementMenuContainer').html(response);
		jQuery('#settingsRoleManegementMenu .settingsRoleManegementMenuContainer').show();
	});
}

function setRoleManagement(){
	jQuery('#settingsRoleManegementMenu .wait').show();
	jQuery('#settingsRoleManegementMenu .settingsRoleManegementMenuContainer').hide();
	
	var agent_role = jQuery("input[name='agentRole\\[\\]']:checked")
    .map(function(){return jQuery(this).val();}).get();
	
	var supervisor_role = jQuery("input[name='supervisorRole\\[\\]']:checked")
    .map(function(){return jQuery(this).val();}).get();
	
	var data = {
		'action': 'setRoleManagement',
		'agent_role': agent_role,
		'supervisor_role':supervisor_role
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getRollManagementSettings();
	});
}