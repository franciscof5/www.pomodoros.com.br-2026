<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$args = array(
		'search'       => $_POST['search_keywords'],
		'orderby'      => 'display_name',
		'number'       => '5'
);

$wpspUsers=get_users( $args );
?>
<div class="table-responsive" style="margin-top: 5px;">
	<table class="table table-striped table-hover">
		<tr>
		  <th><?php _e('Name','wp-support-plus-responsive');?></th>
		  <th><?php _e('Username','wp-support-plus-responsive');?></th>
		  <th><?php _e('Email','wp-support-plus-responsive');?></th>
		</tr>
		<?php foreach ($wpspUsers as $wpspUser){?>
		<tr style="cursor: pointer;" onclick="wpspChangeUserFromSearchTable(<?php echo $wpspUser->ID;?>,'<?php echo $wpspUser->display_name;?>');">
			<td><?php echo $wpspUser->display_name;?></td>
			<td><?php echo $wpspUser->user_login;?></td>
			<td><?php echo $wpspUser->user_email;?></td>
		</tr>
		<?php }?>
	</table>
</div>
<?php if(!$wpspUsers){?>
<div style="text-align: center;"><?php _e('No Results Found','wp-support-plus-responsive');?></div>
<hr>
<?php }?>