<?php 
global $current_user;
get_currentuserinfo();
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#ticketContainer" id="tab_ticket_container" data-toggle="tab"><?php echo __('Tickets', 'wp-support-plus-responsive');?></a></li>
	<li><a href="#create_ticket" id="tab_create_ticket" data-toggle="tab"><span class="glyphicon glyphicon-comment" aria-hidden="true"> <?php echo __('Create New Ticket', 'wp-support-plus-responsive');?></a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
	<!-- Tickets Tab Body Start Here -->
	<div class="tab-pane active" id="ticketContainer">
		<div class="ticket_list"></div>
		<div class="ticket_indivisual"></div>
		<div class="wait"><img alt="<?php echo __('Please Wait', 'wp-support-plus-responsive');?>" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>"></div>
	</div>
	<!-- Tickets Tab Body End Here -->
	<!-- Create New Ticket Tab Body Start Here -->
	<div class="tab-pane" id="create_ticket">
		<div id="create_ticket_container"></div>
		<div class="wait"><img alt="<?php echo __('Please Wait', 'wp-support-plus-responsive');?>" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>"></div>
	</div>
	<!-- Create New Ticket Tab Body End Here -->
</div>