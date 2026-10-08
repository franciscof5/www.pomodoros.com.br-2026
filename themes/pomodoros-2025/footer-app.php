			
			<!-- </div> -->
		</div> <!-- #wrapper #2D2D2D-->
		
		<?php do_action( 'bp_after_container' ); ?>

		<?php do_action( 'bp_before_footer' ) ?>

		<div id="footer" class="">
			<div id="footer-content" class="row">
				
				<div class="col-sm-3">
					<h3><a href="/ranking" alt="Check ranking"><?php _e("Top Users", "sis-foca-js"); ?></a></h3>
					<?php
					$instance = array(
						"title" => "",
						"count" => "7",
						"exclude_roles" => array("administrator"),#
						"include_post_types" => array("projectimer_focus"),
						"preset" => "custom",
						#"template" => "%gravatar_32% %firstname% %lastname% (%nrofposts%)",
						"template" => '<li><a href="/members/%username%">%gravatar_18%  %firstname% %lastname% (%nrofposts%) </a>  </li>',
						"before_list" => "<ul class='ul-ranking-footer ul-ranking-li ta-gravatar-list-count'>",
						"after_list" => "</ul>",
						"custom_id" => "",
						"archive_specific" => false); 
					the_widget("Top_Authors_Widget", $instance, "");
					?>
					<?php #<small _e("Doesn't count private pomodoros.", "sis-foca-js"); </small> ?>
					<?php
					if(function_exists("get_meta_values")) {
						$array_top_cities = get_meta_values( "post_location_city", "projectimer_focus" );
						#$array_top_cities = get_meta_values( "post_location_city", "projectimer_focus" );
						$array_top_countries = get_meta_values( "post_location_country", "projectimer_focus" );
						?>
						<h3><?php _e("Top 5 Cities", "sis-foca-js"); ?></h3>
						<?php array_to_rank($array_top_cities, 6); ?>
						<h3><?php _e("Top 3 Countries", "sis-foca-js"); ?></h3>
						<?php array_to_rank($array_top_countries, 4); ?>
					<?php } ?>
				</div>

				<div class="col-sm-3 contem_last_pomodoros">
					<h3><a href="/activity" alt="Viel all activity"><?php _e("Last pomodoros", "sis-foca-js"); ?></a></h3>
					<?php 
					if(function_exists("show_recent_pomodoros"))
					show_recent_pomodoros(); ?>
					<br style="clear: both;">
				</div>
				
				<div class="col-sm-3">
					<h3><a href="/blog" alt="Read our blog"><?php _e("Our blog", "sis-foca-js"); ?></a></h3>
					<?php 
					if(function_exists("smartlang_recent_posts_georefer_widget"))
					smartlang_recent_posts_georefer_widget(6); ?>
				</div>

				<div class="col-sm-3">
					<h3><?php _e("Get it on", "sis-foca-js"); ?></h3>
					<p><?php echo google_play_link(); ?></p>
					<h3><?php _e("Sponsored by", "sis-foca-js"); ?></h3>
					<p><?php echo show_sponsor("box-float-left", true); ?></p>
					<br style="clear: both;">
					
					<h3><a href="/help" alt="Get help"><?php _e("Support", "sis-foca-js"); ?></a></h3>
					<p><a title="<?php _e("Open support ticket", "sis-foca-js"); ?>" id="settingsbutton" class="btn  btn-white" href="<?php bloginfo('url'); ?>/help" style="padding-top: 10px;"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> <?php _e("Open support ticket", "sis-foca-js"); ?></a></p>
				</div>

				<?php /*
				JA ELVIS
				<div id="footer-contact-form" class="col-sm-3">
					<h3><?php _e("Contact Us", "sis-foca-js"); ?></h3>
					<?php if(!is_user_logged_in()) { ?>
						<p class="bg-danger">
							<a href="#" class="abrir_login"><?php _e("Login", "sis-foca-js"); ?></a> <?php _e("now to use contact form", "sis-foca-js"); ?></p>
					<?php } else { ?>
						
						<?php 
						global $locale;
						if($locale=="pt_BR" || $locale=="pt")
							echo do_shortcode( '[contact-form-7 id="1526" title="Contato"]' ); 
						else 
							echo do_shortcode( '[contact-form-7 id="3950" title="Contato"]' ); 
						?>
					<?php } ?>
				</div>
				*/ ?>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12" style="text-align: right;">
					<?php 
					if(function_exists("show_lang_options"))
					show_lang_options(false); ?>
				</div>
			</div>
			
			<?php do_action( 'bp_footer' ) ?>
		</div><!-- #footer -->

<script>
	jQuery( document ).ready(function() {
		//RANKING
		var regExpGetValueInParentisi = /\(([^)]+)\)/;
		ranking_footer_first_text = jQuery(".ul-ranking-footer li:nth-child(1)").text();
		var matches2 = regExpGetValueInParentisi.exec(ranking_footer_first_text);
		var ranking_footer_first_qtddpomo = parseInt(matches2[1]);
		var min_width_percentage = 70;
		var min_width_percentage_negative = 100 - min_width_percentage;
		//
		jQuery( ".ul-ranking-footer li").each(function(i, b) {
			jQuery(this).prepend("<span class=pos>"+(i+1)+"</span>");
			//
			inner_text_li_footer = (jQuery(this).text());
			//alert(inner_text_li_footer);
			var matches = regExpGetValueInParentisi.exec(inner_text_li_footer);
			qtddpomo= parseInt(matches[1]);
			percentage_in_relation_to_first = (qtddpomo/ranking_footer_first_qtddpomo);
			
			resizing = min_width_percentage + (percentage_in_relation_to_first*min_width_percentage_negative);
			//alert(qtddpomo);
			//resizing = min_width_percentage + ((((qtddpomo/ranking_footer_first_qtddpomo)/10)*2)*100);
			//alert(res);
			jQuery( this ).width( (resizing) + "%" );
			jQuery( this ).find('a').width( (resizing-15) + "%" );
		});
		jQuery(".ul-ranking-footer li:nth-child(1)").css({
				"background":"#FFF379",
				"color": "#9B7529",
		});
		jQuery(".ul-ranking-footer li:nth-child(1) .pos").css({
			"color": "#9B7529",
			//"font-size": "30px"
		});
		jQuery(".ul-ranking-footer li:nth-child(1) a").css("color", "#9B7529");

		jQuery(".ul-ranking-footer li:nth-child(2)").css({
				"background":"#98969B",
				"color": "#D0D8D7"
		});
		jQuery(".ul-ranking-footer li:nth-child(2) .pos").css({
			"color": "#D0D8D7",
			//"font-size": "26px"
		});
		jQuery(".ul-ranking-footer li:nth-child(2) a").css("color", "#D0D8D7");


		jQuery(".ul-ranking-footer li:nth-child(3)").css({
				"background":"#F1AB66",
				"color": "#50352F"
		});
		jQuery(".ta-preset li:nth-child(3) .pos").css({
			"color": "#50352F",
			//"font-size": "22px"
		});
		jQuery(".ul-ranking-footer li:nth-child(3) a").css("color", "#50352F");
		//jQuery(".btn-expand " ).mouseenter(function() {
		//	jQuery(this).find( "span" ).removeClass( "hidden-sm hidden-md " );
		//}).
		jQuery(".btn-expand " ).mouseover(function() {
			if(jQuery(this).find( ".icon-leg" ).hasClass( "hidden-sm hidden-md" )) {
				jQuery(this).find( ".icon-leg" ).removeClass( "hidden-sm hidden-md" );
				jQuery(this).mouseout(function() {
					jQuery(this).find( ".icon-leg" ).addClass( "hidden-sm hidden-md " );
				});
			}
		});
		jQuery(".contem-icone " ).mouseenter(function() {
			jQuery( ".icone-legenda" ).hide(100);
			if(!jQuery(this).find( ".icone-legenda" ).is(":animated"))
			jQuery(this).find( ".icone-legenda" ).show(400);
			/*$(this).*/
		});
		jQuery( ".contem-icone" ).mouseout(function() {
			jQuery( ".icone-legenda" ).hide(100);
		});
		
		
		//**********//
		/*jQuery(document).click(function(event) { 
		    if(!jQuery(event.target).closest('.loginlogbox').length) {
				if(jQuery('.loginlogbox').is(":visible")) {
					jQuery('.loginlogbox').hide();
				}
			}        
		});*/
		jQuery( ".abrir_login" ).click(function() {
			jQuery( "#loginlogbox" ).toggle("slow");
		});
		jQuery( ".abrir_settings" ).click(function() {
			jQuery( "#settingsbox" ).toggle("slow");
		});
		jQuery( window ).click(function() {
			//NOT MOUSE OVER LOGINLOGBOX
			if(jQuery( "#loginlogbox" ).is(":visible") && !jQuery( "#loginlogbox" ).is(":animated") && !jQuery( "#loginlogbox" ).is(":hover"))
			jQuery( "#loginlogbox" ).hide("fast");

			if(jQuery( "#settingsbox" ).is(":visible") && !jQuery( "#settingsbox" ).is(":animated") && !jQuery( "#settingsbox" ).is(":hover"))
			jQuery( "#settingsbox" ).hide("fast");
		});
	});
</script>
		

		<div  class="footer-white-link">
			<div class="col-xs-6">
				<p><?php _e("Developed by", "sis-foca-js"); ?> <a href="https://www.franciscomat.com">Francisco Mat</a>
				<?php /*, Fork us <a href="https://github.com/franciscof5/sistema-focalizador-javascript">on GitHub</a> */ ?>
				</p>
			</div>
			<?php
			/*<br /> Hosted by <a href="https://www.f5sites.com/pomodoros">F5 Sites</a>*/
			?>
			<div class="col-xs-6">
				<p style="text-align: right;"><a href="<?php bloginfo('url'); ?>/done/pomodoros-2"><?php _e("Project Pomodoros", "sis-foca-js"); ?></a> | <a href="https://angel.co/projects/68620-pomodoros-com-br">AngelList</a> | <a href="http://carreirasolo.org/novas/site-usa-tecnica-dos-pomodoros-para-agilizar-produtividade#.W_PWZ6uQxpg">CarreiraSolo</a></p>
			</div>
		</div>

<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
	
<?php do_action( 'bp_after_footer' ) ?>

<?php wp_footer(); ?>
<?php 
/*
<!--div id="footer-info">
				    <p id="assinatura">Desenvolvido por F5 Sites <br /> <a href="http://www.f5sites.com">www.f5sites.com</a></p>
				    <?php /*<p><?php printf( __( '%s is proudly powered by <a href="http://mu.wordpress.org">WordPress MU</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> and <a href="http://www.avenueb2.com">Avenue B2</a></p>
				</div-->

/*
					<!--div class="col-sm-3">
						<h3>Páginas</h3>
						<ul>
							<li><a href="<?php bloginfo('url'); ?>">Início</a></li>
							<?php if ( is_user_logged_in() ) { ?> 
								<li><a href="<?php bloginfo('url'); ?>/focar">Focar</a></li>
								<li><a href="<?php bloginfo('url'); ?>/colegas/<?php  $current_user = wp_get_current_user(); echo $current_user->display_name  ?>">Produtividade</a></li>
							<?php } ?>
							<li><a href="<?php bloginfo('url'); ?>/colegas">Amigos</a></li>
							<li><a href="<?php bloginfo('url'); ?>/mural">Mural</a></li>
							<li><a href="<?php bloginfo('url'); ?>/ranking">Ranking</a></li>
							<li><a href="<?php bloginfo('url'); ?>/calendar">Calendário</a></li>
						</ul>
						<?php //wp_list_pages("title_li=&include=8,3096,381,4814"); ?>
					</div-->
					*/ ?>
</body>
</html>