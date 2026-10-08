var page_no=0;
jQuery(document).ready(function(){
	getTickets();
	
	jQuery('#tab_ticket_container').click(function(){
		jQuery('#filter_by_type').val('all');
		jQuery('#filter_by_status').val('all');
		jQuery('#filter_by_category').val('all');
		jQuery('#filter_by_assigned_to').val('all');
		jQuery('#filter_by_priority').val('all');
		jQuery('#filter_by_no_of_ticket').val('10');
		jQuery('#filter_by_search').val('');
		page_no=0;
		getTickets();
	});
	
	jQuery('#tab_create_ticket').click(function(){
		jQuery('#create_ticket_container').hide();
		jQuery('#create_ticket .wait').show();
		var data = {
			'action': 'getCreateTicketForm',
			'backend': 1
		};
		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			jQuery('#create_ticket_container').html(response);
			jQuery('#create_ticket .wait').hide();
			jQuery('#create_ticket_container').show(function(){
				new nicEditor({fullPanel : true,maxHeight : 500}).panelInstance('create_ticket_body');
				jQuery( '#frmCreateNewTicket' ).unbind('submit');
				jQuery( '#frmCreateNewTicket' ).submit( function( e ) {
					if(validateTicketSubmit()){
						jQuery('#create_ticket_container').hide();
						jQuery('#create_ticket .wait').show();
						jQuery.ajax( {
					      url: display_ticket_data.wpsp_ajax_url,
					      type: 'POST',
					      data: new FormData( this ),
					      processData: false,
					      contentType: false
					    }) 
					    .done(function( msg ) {
					    	if(msg==1){
					    		jQuery('#tab_ticket_container').trigger('click');
					    	}
					    });
					}
					e.preventDefault();
				});
			});
		});
	});
	
	jQuery('#tab_agent_settings').click(function(){
		jQuery('#agent_settings #agent_settings_area').hide();
		jQuery('#agent_settings .wait').show();
		
		var data = {
			'action': 'getAgentSettings'
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			jQuery('#agent_settings .wait').hide();
			jQuery('#agent_settings #agent_settings_area').html(response);
			jQuery('#agent_settings #agent_settings_area').show();
		});
	});
	
	jQuery("#filter_by_type,#filter_by_status,#filter_by_category,#filter_by_priority,#filter_by_no_of_ticket,#filter_by_assigned_to").change(function(){
		page_no=0;
		getTickets();
	});
	
	jQuery('#filter_by_search').keyup(function(){
		page_no=0;
		getTickets();
	});
		
});

function replyTicket(e,obj){
	jQuery('#replyBody').val(jQuery('.nicEdit-main').html());
	if(validateReplyTicketSubmit()){
		jQuery('#ticketContainer .ticket_indivisual').hide();
		jQuery('#ticketContainer .wait').show();
		
		jQuery.ajax( {
	      url: display_ticket_data.wpsp_ajax_url,
	      type: 'POST',
	      data: new FormData( obj ),
	      processData: false,
	      contentType: false
	    }) 
	    .done(function( msg ) {
	    	if(msg==1){
	    		jQuery('#tab_ticket_container').trigger('click');
	    	}
	    });
	}
	e.preventDefault();
}

function getTickets(){
	jQuery('#ticketContainer .ticket_list,#ticketContainer .ticket_indivisual,#ticketContainer .ticket_assignment').hide();
	jQuery('#ticketContainer .ticket_filter,#ticketContainer .wait').show();
	
	var data = {
		'action': 'getTickets',
		'type': jQuery('#filter_by_type').val(),
		'status': jQuery('#filter_by_status').val(),
		'category': jQuery('#filter_by_category').val(),
		'assign_to': jQuery('#filter_by_assigned_to').val(),
		'priority': jQuery('#filter_by_priority').val(),
		'no_of_ticket': jQuery('#filter_by_no_of_ticket').val(),
		'search': jQuery('#filter_by_search').val(),
		'page_no': page_no
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_list').html(response);
		jQuery('#ticketContainer .ticket_list').show();
	});
}

function openTicket(ticket_id){
	jQuery('#ticketContainer .ticket_filter,#ticketContainer .ticket_list,#ticketContainer .ticket_indivisual,#ticketContainer .ticket_assignment').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'openTicket',
		'ticket_id': ticket_id
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_indivisual').html(response);
		jQuery('#ticketContainer .ticket_indivisual').show(function(){
			new nicEditor({fullPanel : true,maxHeight : 500}).panelInstance('replyBody');
		});
	});
}

function load_prev_page(prev_page_no){
	if(prev_page_no!=0){
		page_no=prev_page_no-1;
		getTickets();
	}
}

function load_next_page(next_page_no){
	if(next_page_no!=page_no){
		page_no=next_page_no;
		getTickets();
	}
}

function validateTicketSubmit(){
	if(jQuery('#create_ticket_subject').val().trim()==''){
		alert("Subject not set");
		jQuery('#create_ticket_subject').focus();
		return false;
	}
	if(jQuery('#create_ticket_body').val().trim()=='<br>'){
		alert("Description not set");
		return false;
	}
	return true;
}

function validateReplyTicketSubmit(){
	if(jQuery('#replyBody').val().trim()=='<br>'){
		alert("Reply can not be empty!");
		return false;
	}
	return true;
}

function backToTicketFromIndisual(){
	getTickets();
}

function setSignature(id){
	jQuery('#agent_settings #agent_settings_area').hide();
	jQuery('#agent_settings .wait').show();
	
	var data = {
		'action': 'setAgentSettings',
		'id':id,
		'signature':jQuery('#agentSignature').val(),
		'skype_id':jQuery('#txtAgentSkypeId').val(),
		'chat_availability':jQuery('input[name=rdbAvailableChat]:checked').val(),
		'call_availability':jQuery('input[name=rdbAvailableCall]:checked').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#tab_agent_settings').trigger('click');
	});
}

function assignAgent(ticket_id){
	jQuery('#ticketContainer .ticket_indivisual').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'getTicketAssignment',
		'ticket_id':ticket_id
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_assignment').html(response);
		jQuery('#ticketContainer .ticket_assignment').show();
	});
}

function setTicketAssignment(ticket_id){
	jQuery('#ticketContainer .ticket_assignment').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'setTicketAssignment',
		'ticket_id':ticket_id,
		'agent_id': jQuery('#assignTicketAgentId').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getTickets();
	});
}

function deleteTicket(ticket_id){
	if(confirm("Are you sure to delete this ticket?\n(Can not be undone)"))
	{
		jQuery('#ticketContainer .ticket_indivisual').hide();
		jQuery('#ticketContainer .wait').show();
		
		var data = {
			'action': 'deleteTicket',
			'ticket_id':ticket_id
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getTickets();
		});
	}
}

function getChangeTicketStatus(ticket_id){
	jQuery('#ticketContainer .ticket_indivisual').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'getChangeTicketStatus',
		'ticket_id':ticket_id
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_assignment').html(response);
		jQuery('#ticketContainer .ticket_assignment').show();
	});
}

function setChangeTicketStatus(ticket_id){
	jQuery('#ticketContainer .ticket_assignment').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'setChangeTicketStatus',
		'ticket_id':ticket_id,
		'status': jQuery('#change_status_ticket_status').val(),
		'category': jQuery('#change_status_category').val(),
		'priority': jQuery('#change_status_priority').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getTickets();
	});
}
