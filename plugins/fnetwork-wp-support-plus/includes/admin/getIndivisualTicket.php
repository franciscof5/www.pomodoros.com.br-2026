<?php 
global $wpdb;
global $current_user;
get_currentuserinfo();

if(!is_numeric($_POST['ticket_id'])) die(); //sql injection

$sql="select subject,type,status,cat_id,priority,created_by,guest_name
		FROM {$wpdb->prefix}wpsp_ticket WHERE id=".$_POST['ticket_id'];
$ticket = $wpdb->get_row( $sql );

$sql="select id,body,attachment_ids,created_by,guest_name,guest_email,
		TIMESTAMPDIFF(MONTH,create_time,UTC_TIMESTAMP()) as date_modified_month,
		TIMESTAMPDIFF(DAY,create_time,UTC_TIMESTAMP()) as date_modified_day,
		TIMESTAMPDIFF(HOUR,create_time,UTC_TIMESTAMP()) as date_modified_hour,
 		TIMESTAMPDIFF(MINUTE,create_time,UTC_TIMESTAMP()) as date_modified_min,
 		TIMESTAMPDIFF(SECOND,create_time,UTC_TIMESTAMP()) as date_modified_sec
		FROM {$wpdb->prefix}wpsp_ticket_thread WHERE ticket_id=".$_POST['ticket_id'].' ORDER BY create_time DESC' ;
$threads= $wpdb->get_results( $sql );
$categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_catagories" );
?>

<button class="btn btn-primary wpsp_ticket_nav_btn" onclick="backToTicketFromIndisual();">«<?php _e(' Back To Tickets','wp-support-plus-responsive');?></button>
<button class="btn btn-primary wpsp_ticket_nav_btn" onclick="getChangeTicketStatus(<?php echo $_POST['ticket_id'];?>);"><?php _e('Change Status','wp-support-plus-responsive');?></button>
<?php if($current_user->has_cap('manage_support_plus_agent')){?>
<button class="btn btn-primary wpsp_ticket_nav_btn"onclick="assignAgent(<?php echo $_POST['ticket_id'];?>);"><?php _e('Assign Agent','wp-support-plus-responsive');?></button>
<button class="btn btn-danger wpsp_ticket_nav_btn" onclick="deleteTicket(<?php echo $_POST['ticket_id'];?>);"><?php _e('Delete Ticket','wp-support-plus-responsive');?></button>
<?php }?>
<br>
<h3><?php _e('[Ticket #'.$_POST['ticket_id'].'] '.stripcslashes(htmlspecialchars_decode($ticket->subject,ENT_QUOTES)),'wp-support-plus-responsive');?></h3>

<form id="frmThreadReply" onsubmit="replyTicket(event,this);">
	<div id="theadReplyContainer">
		<textarea id="replyBody" name="replyBody"></textarea>
		<div id="replyFloatedContainer">
			<div class="replyFloatLeft">
				<span class="label label-info wpsp_title_label"><?php _e('Status','wp-support-plus-responsive');?></span><br>
				<select id="reply_ticket_status" name="reply_ticket_status">
					<option value="open" <?php echo ($ticket->status=='open')?'selected="selected"':'';?>><?php _e('Open','wp-support-plus-responsive');?></option>
					<?php if($ticket->type!='guest'){?>
					<option value="pending" <?php echo ($ticket->status=='pending')?'selected="selected"':'';?>><?php _e('Pending','wp-support-plus-responsive');?></option>
					<?php }?>
					<option value="closed" <?php echo ($ticket->status=='closed')?'selected="selected"':'';?>><?php _e('Closed','wp-support-plus-responsive');?></option>
				</select>
			</div>
			<div class="replyFloatLeft">
				<span class="label label-info wpsp_title_label"><?php _e('Category','wp-support-plus-responsive');?></span><br>
				<select id="reply_ticket_category" name="reply_ticket_category">
					<?php 
					foreach ($categories as $category){
						$selected=($category->id==$ticket->cat_id)?'selected="selected"':'';
						echo '<option value="'.$category->id.'" '.$selected.'>'.$category->name.'</option>';
					}
					?>
				</select>
			</div>
			<div class="replyFloatLeft">
				<span class="label label-info wpsp_title_label">Priority</span><br>
				<select id="reply_ticket_priority" name="reply_ticket_priority">
					<option value="normal" <?php echo ($ticket->priority=='normal')?'selected="selected"':'';?>><?php _e('Normal','wp-support-plus-responsive');?></option>
					<option value="high" <?php echo ($ticket->priority=='high')?'selected="selected"':'';?>><?php _e('High','wp-support-plus-responsive');?></option>
					<option value="medium" <?php echo ($ticket->priority=='medium')?'selected="selected"':'';?>><?php _e('Medium','wp-support-plus-responsive');?></option>
					<option value="low" <?php echo ($ticket->priority=='low')?'selected="selected"':'';?>><?php _e('Low','wp-support-plus-responsive');?></option>
				</select>
			</div>
			<?php if($ticket->type!='guest'){?>
			<div class="replyFloatLeft">
				<span class="label label-info wpsp_title_label"><?php _e('Attach File(s)','wp-support-plus-responsive');?></span><br>
				<input id="wpsp_reply_attachment" type="file" name="attachment[]" multiple>
			</div>
			<?php }?>
			<input type="hidden" name="action" value="replyTicket">
			<input type="hidden" name="ticket_id" value="<?php echo $_POST['ticket_id'];?>">
			<input type="hidden" name="user_id" value="<?php echo $current_user->ID;?>">
			<input type="hidden" name="type" value="user">
			<input type="hidden" name="guest_name" value="">
			<input type="hidden" name="guest_email" value="">
			<input type="submit" class="btn btn-success replyFloatRight" value="Submit Reply">
			<input type="button" class="btn btn-success replyFloatRight" value="Reset" onClick="this.form.reset()" />
		</div>
	</div>
</form>

<?php foreach ($threads as $thread){?>
<div class="threadContainer">
		<?php 
			$user_name='';
			$user_email='';
			$signature='';
			if($thread->created_by){
				$user=get_userdata( $thread->created_by );
				$user_name=$user->display_name;
				$user_email=$user->user_email;
				
				$userSignature = $wpdb->get_row( "select signature FROM {$wpdb->prefix}wpsp_agent_settings WHERE agent_id=".$thread->created_by );
				if($wpdb->num_rows){
					$signature='---<br>'.stripcslashes($userSignature->signature);
					$signature=preg_replace("/(\r\n|\n|\r)/", '<br>', $signature);
				}
			}
			else{
				$user_name=$thread->guest_name;
				$user_email=$thread->guest_email;
			}
			$modified='';
			if ($thread->date_modified_month) $modified=$thread->date_modified_month.' months ago';
			else if ($thread->date_modified_day) $modified=$thread->date_modified_day.' days ago';
			else if ($thread->date_modified_hour) $modified=$thread->date_modified_hour.' hours ago';
			else if ($thread->date_modified_min) $modified=$thread->date_modified_min.' minutes ago';
			else $modified=$thread->date_modified_sec.' seconds ago';
			
			$attachments=array();
			if($thread->attachment_ids){
				$attachments=explode(',', $thread->attachment_ids);
			}
			
			$body=stripcslashes(htmlspecialchars_decode($thread->body,ENT_QUOTES));
			$body.=$signature;
			?>
			<div class="gravtar_container">
				<img src="<?php echo get_gravatar($user_email,60);?>">
			</div>
			<div class="threadInfo">
				<span class="threadUserName"><?php echo $user_name;?></span><br>
				<small class="threadUserType"><?php echo $user_email;?></small><br>
				<small class="threadCreateTime"><?php echo $modified;?></small>
			</div><br><br><br>
			<div class="threadBody"><?php echo $body;?></div>
			<?php if(count($attachments)){?>
			<div class="threadAttachment">
				<span id="wpsp_reply_attach_label"><?php _e('Attachment: ','wp-support-plus-responsive');?></span>
				<?php 
				$attachCount=0;
				foreach ($attachments as $attachment){
					$attach=$wpdb->get_row( "select * from {$wpdb->prefix}wpsp_attachments where id=".$attachment );
					$attachCount++;
				?>
				<a class="attachment_link" title="Download" target="_blank" href="<?php echo $attach->fileurl;?>" ><?php echo ($attachCount>1)?', ':'';echo $attach->filename;?></a>
				<?php }?>
			</div>
			<?php }?>
</div>
<?php }?>



<?php 
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = '//gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}
?>