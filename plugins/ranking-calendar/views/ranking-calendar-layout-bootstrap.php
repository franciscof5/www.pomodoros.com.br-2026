<?php
$query_string  = explode('calendar_year=', $_SERVER['REQUEST_URI']);

if(isset($query_string[1])) {
	$year_selected = "&calendar_year=".$query_string[1];
}
/*
$query_string_t2  = explode('&', $query_string_t[1]);
echo $query_string_t2 = $query_string_t2[0];die;
if(isset($query_string_t2)) {
    $year_selected = "&calendar_year=".$query_string_t2;
}
*/
//total post in a month
$tot = 0;

//warning division por 0
if(isset($postsPerDay[$month])) {
if(count($postsPerDay[$month])>0) {
	foreach ($postsPerDay[$month] as $key) {
		//each key is a day that have posts
		foreach ($key as $value) {
			//total post in a month
			$tot++;
		}
	}
}
}
?>

<?php
/*<select id="tipo_calendario">
	<option value="<?php echo get_current_user_id() ?>">Pessoal</option>
	<option value="0">Comunidade</option>
</select>*/
?>

<div class="calendar-container container">
<h1 class="month-year-caption forte col-md-12"><?php echo date('F', $timeForFirstDayOfMonth); ?> <?php echo $year; ?> </h1>
	
<?php if($tot==0) { ?>
		<p class="calendar-p hidden-sm hidden-xs">Sem atividade</p>
	<?php } else { ?>
		<p class="calendar-p hidden-sm hidden-xs"><?php echo $tot; ?> pomodoros no total, <?php echo $dias = count($postsPerDay[$month]); ?> dias produtivos, produtividade media <?php echo round($tot/$dias, 2) ?></p>
	<?php } ?>    
	<ul class="weekdays row seven-cols">
<?php
	// Loop for seven times to output weekday names
$day_number = date('N', strtotime($date))+1;
$day_current = date('d');
	for ($counter = 0, $i = $firstDayOfWeek; 7 > $counter; $counter++, $i++)
	{
?>
		<li class="col col <?php echo ($counter==$day_number ? '' : 'hidden-sm hidden-xs'); ?>"><?php echo $weekdays[$i]; ?></li>
<?php
		// If counter reached to 6, set it to -1
		if (6 == $i)
		{
			$i = -1;
		}
	}
?>
	</ul><br class="clear" />
	<ul class="calendar row  seven-cols hidden-sm hidden-xs">
<?php
	// Total number of days in current month/year
	$totalDaysInMonth = date('t', $timeForFirstDayOfMonth);

	// Weekday for first day of current month/year
	$weekdayForFirstDayOfMonth = date('w', $timeForFirstDayOfMonth);

	// If 'first day of week' is not equal to weekday for first day of month then proceed further to output empty TDs
	if ($firstDayOfWeek != $weekdayForFirstDayOfMonth)
	{
		// Calculate total empty days
		$totalEmptyDays = ($weekdayForFirstDayOfMonth - $firstDayOfWeek);

		// If first day of week is greater than weekday for first day of month then add 7 days to total empty days
		if ($firstDayOfWeek > $weekdayForFirstDayOfMonth)
		{
			$totalEmptyDays += 7;
		}

		// Loop for 'total empty days' to output empty LIs if first day of current month/year doesn't start on 'first day of week'
		for ($i = 0; $i < $totalEmptyDays; $i++)
		{
?>
		<li class="col empty col hidden-sm hidden-xs">&nbsp;</li>
<?php
		}
	}

	// Loop for total number of days in current month/year to output calendar with posts
	for ($day = 1; $day <= $totalDaysInMonth; $day++)
	{
		// If new week started then close current UL and start new one
		if (1 < $day && $firstDayOfWeek == date('w', mktime(0, 0, 0, $month, $day, $year)))
		{
?>
	</ul><br class="clear" />
	<ul class="calendar row seven-cols">
<?php
		}

		// Initialize variable used to store background image
		$backgroundImage = false;

		// If background image set for current day in current month/year then use it
		if (isset($backgroundImages[$month][$day]) && false !== $backgroundImages[$month][$day])
		{
			$backgroundImage = $backgroundImages[$month][$day];
		}
		#if($day==21)
		#	echo 'background-color:#434;';
?>
		<li class="col col day <?php echo ($backgroundImage ? ' style="background-image: url(' . $this->getImageUrl($backgroundImage, $boxDimension) . ');"' : ''); echo ($day==$day_current ? 'day_current_expand' : 'hidden-sm hidden-xs'); ?>" style="<?php #echo ($day==$day_current ? 'background-color:#AAA !important;' : ''); ?>">
<?php
		// If background image set for current day in current month/year then display that day in black/white
		if ($backgroundImage)
		{
?>
			<div class="blackDay"><?php echo $day; ?></div>
			<div class="whiteDay"><?php echo $day; ?></div><br class="clear" />
<?php
		}
		// If background image is not set for current day in current month/year then display that day simply
		$array_usuarios_dos_posts = array();
		
		?>
		<div class="day-header">
			<div class="day-caption">
				<?php echo $day; ?>
				<?php if (isset($postsPerDay[$month][$day])) { ?>
			   
					<?php 
					foreach ($postsPerDay[$month][$day] as $key => $index) {
						//echo $posts[$index]->post_author;
						$authorname = get_the_author_meta('display_name', $posts[$index]->post_author);
						//array_push($array_usuarios_dos_posts, $authorname);
						$array_usuarios_dos_posts[]=$authorname;
					}
					$authors_sum_of_posts = array_count_values($array_usuarios_dos_posts);
					arsort($authors_sum_of_posts);
					#echo $authors_sum_of_posts."<hr />";die;
					$top_author = array_shift(array_keys($authors_sum_of_posts));
					$top_author_value = (array_shift(array_values($authors_sum_of_posts))/2);
					//var_dump($top_author_value);
					//var_dump(($top_author));
					if($top_author=="") 
					$top_author = "anônimo"; 
					else
					$top_author = substr($top_author, 0,10);
					//var_dump(count($postsPerDay[$month][$day]));
					$total_hours_of_day = (count($postsPerDay[$month][$day])/2);
					//echo " top:";

					//echo $day;
					echo ' <a style="text-align:center">'.$top_author."</a> ";
					echo "<span class='show-hour'>";
					
					//echo $top_author_value."h ";
					//echo " |";
					echo $total_hours_of_day."h";
					echo "</span>";
					?>

					
				
				<?php } ?>
			</div>
			<div class="author-ranking">
					<ul>
						<?php
						$index=0;
						//if no pomodors (posts) oon the day display custom message						
						if(isset($authors_sum_of_posts)){
						if(count($authors_sum_of_posts)>0){
							foreach ($authors_sum_of_posts as $key => $value) {
								if($index==0)
								$valuemax = $value;
								#console_log();
	
								$index++;
								if($key=="") 
								$key = "anônimo"; 
								?>
								<li width="100%">
									<span class="aut_pos">
										<?php echo $index; ?>
									</span>
									<span class="aut_nome">
										<?php echo substr($key,0,9); ?>
									</span>
									<span class="aut_barra">
										<div style="
										width:<?php echo (($value/$valuemax)*100); ?>%;
										border-radius:3px;
										background-color: #DDD;
										height:10px;
										margin-top:5px;
										float:none;
										">&nbsp;
										</div>
										<?php #echo (($value/$valuemax)*40);#echo $value; ?>
									</span>
									<span class="aut_total">
										<?php echo ($value/2); ?>h
									</span>
								</li>
							<?php } 
						} else {
							echo "";
						}} 
						//To stop propagate the last activity to day with no acitivities
						unset($authors_sum_of_posts);
						?>
					</ul>
		</div>

		<?php
		// If any post(s) for current day in current month/year then display it/them
		if (isset($postsPerDay[$month][$day])) {  ?>
			<div class="day-footer2">
				<ul<?php echo ($backgroundImage ? ' class="invisible"' : ''); ?>>
				<?php
				// Loop through post(s) for current day in current month/year to display it/them
				//var_dump($postsPerDay[$month][$day]);die;
				$morning_time = false;
				$launch_time = false;
				$night_time = false;
				$index_foreach = 0;
				foreach ($postsPerDay[$month][$day] as $key => $index) { ?>
					<?php
						//ESCREVE MANHA, ALMOCO, NOITE
						// $hour_only = (int)(substr($posts[$index]->post_date, 11,2));
						// //echo "almoco<br />";
						// $index_foreach++;
						// if($morning_time==false) {
						// 	if($hour_only>=7) {
						// 		echo "<li style='text-align:center;'> ----- manhã ----- </li>";
						// 		$morning_time = true;
						// 	}
						// }
						// if($launch_time==false) {
						// 	if($hour_only>=12) {
						// 		echo "<li style='text-align:center;'> ----- almoço ----- </li>";
						// 		$launch_time = true;
						// 	}
						// }
						// if($night_time==false) {
						// 	if($hour_only>=18) {
						// 		echo "<li style='text-align:center;'> ----- noite ----- </li>";
						// 		$night_time = true;
						// 	}
						// }
						?>
					<li>
						<span style="color: #337ab7; letter-spacing: -1px;"><?php echo $ddd = substr($posts[$index]->post_date, 11,5); ?> </span>
						<?php 
						#$echo the_time( "G:i",$posts[$index]->ID); 
						#date_default_timezone_set('Pacific/Midway'); 
						
						#$dt = date( "G:i",strtotime("$ddd -3 hours"));

						#echo $dt = strtotime("-5 hours", $dt);
						#echo $dt = strtotime("-5 hours", $dt);
						#var_dump($dt);die;
						#echo $cut = strtotime($ddd - "-3 hours");
						//var_dump($posts[$index]);die;
						#echo $dt;
						?>
						
						<a href="<?php echo get_permalink($posts[$index]->ID); ?>" style="color:#000;">
							<?php echo $posts[$index]->post_title; ?>
							<?php #the_author(); ?>

						</a>

						<!--a href="<?php echo bp_core_get_userlink($posts[$index]->post_author); ?>"-->
							<?php  
							
							//echo $posts[$index]->post_author;
							//echo $posts[$index]->post_author;
							if(get_the_author_meta('display_name', $posts[$index]->post_author)=="")
								echo "anônimo";
							else
								echo bp_core_get_userlink($posts[$index]->post_author);
								//echo get_the_author_meta('display_name', $posts[$index]->post_author);
							//$post = get_post( $posts[$index]->ID) ); 
							// echo $post->post_author; ); 
							?> 
						<!--/a-->

						
					</li>
					<?php
					// var_dump($index_foreach);
					// if ($index_foreach>=(int)count($postsPerDay[$month][$day])) {
					// 	if(!$morning_time) {
					// 		echo "<li style='text-align:center;'> ----- manhã ----- </li>";
					// 		$morning_time = true;
					// 	} else {
					// 		if(!$launch_time) {
					// 			echo "<li style='text-align:center;'> ----- almoço ----- </li>";
					// 			$launch_time = true;
					// 		} else {
					// 			if(!$night_time) {
					// 				echo "<li style='text-align:center;'> ----- noite ----- </li>";
					// 				$night_time = true;
					// 			}
					// 		}
					// 	}
					// }
					?>
				<?php } ?>
				</ul>
			</div>
<?php
		 }
?>
		</li>
<?php
	}

	// Weekday for last day of current month/year
	$weekdayForLastDayOfMonth = date('w', mktime(0, 0, 0, $month, $totalDaysInMonth, $year));

	// Calculate total empty days
	$totalEmptyDays = ($firstDayOfWeek - $weekdayForLastDayOfMonth - 1);

	// If first day of week is less than or equals to weekday for last day of month then add 7 days to total empty days
	if ($firstDayOfWeek <= $weekdayForLastDayOfMonth)
	{
		$totalEmptyDays += 7;
	}

	// Loop for 'total empty days' to output empty TDs if last day of current month/year doesn't end on 'first day of week'
	for ($i = 0; $i < $totalEmptyDays; $i++)
	{
?>
		<li class="col empty col DDDhidden-sm DDDhidden-xs">&nbsp;</li>
<?php
	}
?>
	</ul><br class="clear" /><br class="clear" />
</div>

<?php /*
<script>
jQuery( document ).ready(function() {
	jQuery(".author-ranking").mouseenter(function(){
		jQuery(this).css('height', "auto");
	})
	jQuery(".author-ranking").mouseleave(function(){
		jQuery(this).css('height', "32px");
	})
	jQuery(".author-ranking").mouseleave(function(){
		jQuery(this).css('height', "32px");
	})
	/*
		jQuery("ul.calendar li.day").find('.day-caption').mouseenter(function(){
                //jQuery(this).find('.author-ranking').show();
                //if(jQuery(this).find('.author-ranking').css('display') == 'none') {
                    
                    jQuery(this).parent().find('.author-ranking').css('height', "auto");
                //}
                //console.log("mouseenter day caption");
            })
            jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
                //jQuery(this).hide();
                jQuery(this).css('height', "30px");
                //console.log("saiu author ranking");
            })
            jQuery("ul.calendar li.day").mouseleave(function(){
                //jQuery(this).find('.author-ranking').show();
                jQuery(this).find('.author-ranking').css('height', "30px");
            })*
	jQuery(".author-ranking").each(function(i) {
                if(jQuery(this).find("ul").length) {
                    //Gold
                    jQuery(this).find("li:nth-child(1)").find(".aut_barra div").css('background-color', "#FFD700");
                    //Silver
                    jQuery(this).find("li:nth-child(2)").find(".aut_barra div").css('background-color', "#A8A8A8");
                    //Bronze
                    jQuery(this).find("li:nth-child(3)").find(".aut_barra div").css('background-color', "#965A38");
                }
                //jQuery.each(".aut_barra").css('background-color', "#964");
            });
});
</script>
<?php #} ?> */
?>