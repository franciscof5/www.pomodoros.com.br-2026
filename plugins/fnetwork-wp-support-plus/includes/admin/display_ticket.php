<!-- Nav tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#ticketContainer" id="tab_ticket_container" data-toggle="tab"><?php _e('Tickets','wp-support-plus-responsive');?></a></li>
	<li><span class="glyphicon glyphicon-comment" aria-hidden="true"><a href="#create_ticket" id="tab_create_ticket" data-toggle="tab"> <?php _e('Create New Ticket','wp-support-plus-responsive');?></a></li>
	<li><a href="#agent_settings" id="tab_agent_settings" data-toggle="tab"><?php _e('Agent Settings','wp-support-plus-responsive');?></a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
	<!-- Tickets Tab Body Start Here -->
	<div class="tab-pane active" id="ticketContainer">
		<div class="ticket_filter">
			<?php include_once( WCE_PLUGIN_DIR.'includes/admin/ticket_filter.php' );?>
		</div>
		<div class="ticket_list"></div>
		<div class="ticket_indivisual"></div>
		<div class="ticket_assignment"></div>
		<div class="wait"><img alt="Please Wait" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>"></div>
	</div>
	<!-- Tickets Tab Body End Here -->
	<!-- Create New Ticket Tab Body Start Here -->
	<div class="tab-pane" id="create_ticket">
		<div id="create_ticket_container"></div>
		<div class="wait"><img alt="Please Wait" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>"></div>
	</div>
	<!-- Create New Ticket Tab Body End Here -->
	<!-- Agent Settings Tab Body Start Here -->
	<div class="tab-pane" id="agent_settings">
		<div id="agent_settings_area"></div>
		<div class="wait"><img alt="Please Wait" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>"></div>
	</div>
	<!-- Agent Settings Tab Body End Here -->
</div>