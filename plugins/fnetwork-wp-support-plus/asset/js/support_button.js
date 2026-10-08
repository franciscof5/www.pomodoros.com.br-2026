jQuery(document).ready(function(){
	jQuery('#support_skype_chat').click(function(){
		jQuery.fancybox({
	        href: '#support_skype_chat_body',
	        width: 300,
	        height: 300,
	        autoSize : false,
	        fitToView : false,
	        transitionIn:	'elastic',
			transitionOut: 'elastic',
			speedIn: 600, 
			speedOut: 200,
			overlayShow: true,
			afterLoad: function() {
				
				jQuery('#support_skype_chat_body #supportChatContainer').hide();
				jQuery('#support_skype_chat_body .wait').show();
				
				var data = {
					'action': 'getChatOnlineAgents'
				};

				jQuery.post(display_button_data.wpsp_ajax_url, data, function(response) {
					jQuery('#support_skype_chat_body .wait').hide();
					jQuery('#support_skype_chat_body #supportChatContainer').html(response);
					jQuery('#support_skype_chat_body #supportChatContainer').show();
				});
			}
	    });
	});
	
	jQuery('#support_skype_call').click(function(){
		jQuery.fancybox({
	        href: '#support_skype_call_body',
	        width: 300,
	        height: 300,
	        autoSize : false,
	        fitToView : false,
	        transitionIn:	'elastic',
			transitionOut: 'elastic',
			speedIn: 600, 
			speedOut: 200,
			overlayShow: true,
			afterLoad: function() {
				
				jQuery('#support_skype_call_body #supportCallContainer').hide();
				jQuery('#support_skype_call_body .wait').show();
				
				var data = {
					'action': 'getCallOnlineAgents'
				};

				jQuery.post(display_button_data.wpsp_ajax_url, data, function(response) {
					jQuery('#support_skype_call_body .wait').hide();
					jQuery('#support_skype_call_body #supportCallContainer').html(response);
					jQuery('#support_skype_call_body #supportCallContainer').show();
				});
			}
	    });
	});
});