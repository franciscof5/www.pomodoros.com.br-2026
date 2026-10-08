<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

$sql="select t.id,t.type,t.subject,t.status,c.name as category,t.priority,t.created_by,t.guest_name,
		TIMESTAMPDIFF(MONTH,t.update_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,t.update_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,t.update_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,t.update_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,t.update_time,UTC_TIMESTAMP()) as date_modified_sec
		FROM {$wpdb->prefix}wpsp_ticket t 
		INNER JOIN {$wpdb->prefix}wpsp_catagories c ON t.cat_id=c.id ";
#$where="WHERE t.created_by=".$current_user->ID.' ';
$order_by='ORDER BY t.update_time DESC ';
$limit_start=$_POST['page_no']*10;
$limit="LIMIT ".$limit_start.",10 ";

$sql.=$where;
$sql.=$order_by;
$tickets = $wpdb->get_results( $sql );
$current_page=$_POST['page_no']+1;
$total_pages=ceil($wpdb->num_rows/10);

$sql.=$limit;
$tickets = $wpdb->get_results( $sql );
?>
<div class="table-responsive">
	<table id="tblFontEndTickets" class="table table-striped table-hover">
	  <tr>
		  <th>#</th>
		  <th>Author</th>
		  <th><?php _e('Status','wp-support-plus-responsive');?></th>
		  <th><?php _e('Subject','wp-support-plus-responsive');?></th>
		  <th class="category"><?php _e('Category','wp-support-plus-responsive');?></th>
		  <th class='priority'><?php _e('Priority','wp-support-plus-responsive');?></th>
		  <th><?php _e('Updated','wp-support-plus-responsive');?></th>
	  </tr>
	  <?php 
	  foreach ($tickets as $ticket){
		
		$raised_by='';
		if($ticket->type=='user'){
			$user=get_userdata( $ticket->created_by );
			$raised_by=$user->display_name;
		}
		else{
			$raised_by=$ticket->guest_name;
		}
		
		$modified='';
		if ($ticket->date_modified_month) $modified=$ticket->date_modified_month.' months ago';
		else if ($ticket->date_modified_day) $modified=$ticket->date_modified_day.' days ago';
		else if ($ticket->date_modified_hour) $modified=$ticket->date_modified_hour.' hours ago';
		else if ($ticket->date_modified_min) $modified=$ticket->date_modified_min.' minutes ago';
		else $modified=$ticket->date_modified_sec.' seconds ago';
		
		$status_color='';
		switch ($ticket->status){
			case 'open': $status_color='danger';break;
			case 'pending': $status_color='warning';break;
			case 'closed': $status_color='success';break;
		}
		$priority_color='';
		switch ($ticket->priority){
			case 'high': $priority_color='danger';break;
			case 'medium': $priority_color='warning';break;
			case 'normal': $priority_color='success';break;
			case 'low': $priority_color='info';break;
		}
		
		echo "<tr class='".$status_color."' style='cursor:pointer;' onclick='openTicket(".$ticket->id.");'>";


		echo "<td>".__($ticket->id,'wp-support-plus-responsive')."</td>";

		$user_info = get_userdata($ticket->created_by);
		echo "<td>".$user_info->user_login."</td>";
		echo "<td><span class='label label-".$status_color."' style='font-size: 13px;'>".__(ucfirst($ticket->status),'wp-support-plus-responsive')."<span></td>";
		echo "<td>".__(stripcslashes(htmlspecialchars_decode(substr($ticket->subject, 0,40),ENT_QUOTES)),'wp-support-plus-responsive')."...</td>";
		echo "<td class='category'>".__($ticket->category,'wp-support-plus-responsive')."</td>";
		echo "<td class='priority'><span class='label label-".$priority_color."' style='font-size: 13px;'>".__(ucfirst($ticket->priority),'wp-support-plus-responsive')."</span></td>";
		echo "<td>".__($modified,'wp-support-plus-responsive')."</td>";
		echo "</tr>";
	  }
	  ?>
	</table>
	<?php 
	$prev_page_no=$current_page-1;
	$prev_class=(!$prev_page_no)?'disabled':'';
	$next_page_no=($total_pages==$current_page)?$current_page-1:$current_page;
	$next_class=($total_pages==$current_page)?'disabled':'';
	?>
	<ul class="pager" style="<?php echo ($total_pages==0)? 'display: none;':'';?>">
	  <li class="previous <?php echo $prev_class;?>"><a href="javascript:load_prev_page(<?php echo $prev_page_no;?>);">&larr; <?php _e('Newer','wp-support-plus-responsive');?></a></li>
	  <li><?php echo $current_page;?> of <?php echo $total_pages;?> Pages</li>
	  <li class="next <?php echo $next_class;?>"><a href="javascript:load_next_page(<?php echo $next_page_no;?>);"><?php _e('Older','wp-support-plus-responsive');?> &rarr;</a></li>
	</ul>
	<div style="text-align: center;<?php echo ($total_pages==0)? '':'display: none;';?>"><?php _e('No Tickets Found','wp-support-plus-responsive');?></div>
	<hr style="<?php echo ($total_pages==0)? '':'display: none;';?>">
</div>