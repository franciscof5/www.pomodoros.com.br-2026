<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Ranking', 'sis-foca-js'); ?>";
</script>
<div id="page-ranking" class="content_nosidebar col-12">
	<?php 
	#style="width: 104%;left: -2%;"
	$instance = array(
		"title" => "Ranking (top 100) 2025",
		"count" => "100",
		"exclude_roles" => array("administrator"),#
		"include_post_types" => array("projectimer_focus"),
		"preset" => "custom",
		#"template" => "%gravatar_32% %firstname% %lastname% (%nrofposts%)",
		"template" => '<li><a href="/colegas/%username%">%gravatar_32%  %firstname% %lastname% (%nrofposts%) </a>  </li>',
		"before_list" => "<ul class='ul-ranking-page ul-ranking-li ta-gravatar-list-count'>",
		"after_list" => "</ul>",
		"custom_id" => "",
		"archive_specific" => false); 
	the_widget("Top_Authors_Widget", $instance, "");
	$current_user = wp_get_current_user();
	echo "<p style='color: #999;'>Ranking gerado em: ".get_the_time('j \d\e F \d\e Y').", via www.pomodoros.com.br/ranking. Usuário: ".$current_user->display_name.", ".$current_user->user_email. "</p>";
	?>
<script>
jQuery( document ).ready(function() {
	var regExpGetValueInParentisi = /\(([^)]+)\)/;
	var min_width_percentage = 50;
	var min_width_percentage_negative = 100 - min_width_percentage;
	//if(jQuery( ".ul-ranking-page li").length) {
	primeiro = jQuery(".ul-ranking-page li:nth-child(1)").text();
	//var matches = parseInt(regExpGetValueInParentisi.exec());
	var matches = regExpGetValueInParentisi.exec(primeiro);
	var ranking_page_first_qtddpomo = parseInt(matches[1]);
	jQuery( ".ul-ranking-page li").each(function(i, b) {
		//alert(b);
		//jQuery( "li" ).each(function(i) {
		/*alert( jQuery(this).find('span').text() );
		jQuery( this ).width( jQuery(this).find('span').text() );/
		*/
		//alert(i);

		jQuery(this).prepend("<span class=pos>"+(i+1)+"</span>");
		qtddpomo_parentisis = (jQuery(this).text());
		//alert(qtddpomo_parentisis);
		//var patt = /\((\d)\)/;
		
		//var qtddpomo = qtddpomo_parentisis.match(patt)[0].replace("(", "").replace(")","");
		var matches = regExpGetValueInParentisi.exec(qtddpomo_parentisis);
		//matches[1] contains the value between the parentheses
		//console.log(matches[1]);
		qtddpomo= parseInt(matches[1]);
		percentage_in_relation_to_first = (qtddpomo/ranking_page_first_qtddpomo);
		resizing = min_width_percentage + (percentage_in_relation_to_first*min_width_percentage_negative);
		//alert(res);
		jQuery( this ).width( (resizing) + "%" );
		jQuery( this ).find('a').width( (resizing-15) + "%" );
		//jQuery( this ).css('backgroundColor', "CCC");
		/*if(i>0) {
			jQuery( this ).before( '<span style="float: left;font-family: Lilita One, cursive;width: 30px;font-size: 20px;line-height: 30px;text-align: center;background: #009933;color: #FFF;border-radius: 50px;padding: 0;margin: 20px 10px;">'+i+"</span" );
		}*/
	});
	jQuery(".ul-ranking-page li:nth-child(1)").css({
			"background":"#FFF379",
			"color": "#9B7529",
	});
	jQuery(".ul-ranking-page li:nth-child(1) .pos").css({
		"color": "#9B7529",
		"font-size": "30px"
	});
	jQuery(".ul-ranking-page li:nth-child(1) a").css("color", "#9B7529");


	jQuery(".ul-ranking-page li:nth-child(2)").css({
			"background":"#98969B",
			"color": "#D0D8D7"
	});
	jQuery(".ul-ranking-page li:nth-child(2) .pos").css({
		"color": "#D0D8D7",
		"font-size": "26px"
	});
	jQuery(".ul-ranking-page li:nth-child(2) a").css("color", "#D0D8D7");


	jQuery(".ul-ranking-page li:nth-child(3)").css({
			"background":"#F1AB66",
			"color": "#50352F"
	});
	jQuery(".ul-ranking-page li:nth-child(3) .pos").css({
		"color": "#50352F",
		"font-size": "22px"
	});
	jQuery(".ul-ranking-page li:nth-child(3) a").css("color", "#50352F");
	//}
});		
</script>
</div><!-- #content -->