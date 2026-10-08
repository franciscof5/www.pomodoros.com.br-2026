<?php
//select2
wp_register_script("select2-js", get_bloginfo("stylesheet_directory")."/assets/select2/select2.full.min.js");
wp_register_script("select2-jsbr", get_bloginfo("stylesheet_directory")."/assets/select2/select2_locale_pt-BR.js");
wp_register_style('select2-css', get_bloginfo("stylesheet_directory")."/assets/select2/select2.min.css", __FILE__);

//jquery-ui
wp_register_script("jquery-ui-js", get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.min.js");
wp_register_style('jquery-ui-css', get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.min.css", __FILE__);
wp_register_style('jquery-ui-theme-css', get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.theme.min.css", __FILE__);
wp_register_script("jquery-ui-touhc-js", get_bloginfo("stylesheet_directory")."/assets/jquery.ui.touch-punch.min.js");
wp_enqueue_script("jquery-color", get_bloginfo("stylesheet_directory")."/assets/jquery.color-2.1.2.min.js");

//no sleep
wp_register_script("nosleep-js", get_bloginfo("stylesheet_directory")."/assets/NoSleep.min.js");

wp_enqueue_script("bootstrap-js", "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js");
wp_enqueue_style('bootstrap-css', "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css");
wp_enqueue_script("pomodoros-js");
#wp_enqueue_script("projectimer-pomodoros-shared-parts-js");
wp_enqueue_script("rangeslider-js");
wp_enqueue_script("sound-js");
wp_enqueue_script("jquery-color");
wp_enqueue_script("select2-js");
wp_enqueue_script("select2-jsbr");
wp_enqueue_style("select2-css");
wp_enqueue_script("jquery-ui-js");
wp_enqueue_style("jquery-ui-css");
wp_enqueue_style("jquery-ui-theme-css");
wp_enqueue_script("jquery-ui-touhc-js");
wp_enqueue_script("nosleep-js");
// if(!$isMobile) {
	wp_enqueue_script("artyom-js");
// }
?>
<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' >> ';_e('Focus', 'sis-foca-js'); ?>";
</script>

<?php #locate_template( array( 'sidebar-pomodoro-left.php' ), true ); ?>

<?php $theme_uri = get_stylesheet_directory_uri(); ?>

<audio id="active_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/crank-2.mp3" preload="auto"></audio>
<audio id="pomodoro_completed_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/23193__kaponja__10trump-tel.mp3" preload="auto"></audio>
<audio id="session_reseted_sound" src="<?php echo $theme_uri; ?>/pomodoro/sounds/magic-chime-02.mp3" preload="auto"></audio>

<div class="container-fluid">

<div class="row justify-content-md-center">
	<div class="col-md-auto col-sm-12 col-md-6">		
		<div id="pomodoro-relogio">							
		<form>
			<input type="button"
			       value="<?php _e('loading', 'sis-foca-js'); ?>..."
			       id="action_button_id"
			       tabindex="1"
			       disabled="true" />
		</form>

		<div id="relogio">
			<div id="back">
			<div id="upperHalfBack">
				<img src="<?php echo $theme_uri; ?>/pomodoro/spacer.png" />
				<img id="minutesUpLeftBack"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Left/0.png" />
				<img id="minutesUpRightBack" src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Right/0.png"/>
				<img id="secondsUpLeftBack"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Left/0.png" />
				<img id="secondsUpRightBack" src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Right/0.png"/>
			</div>

			<div id="lowerHalfBack">
				<img src="<?php echo $theme_uri; ?>/pomodoro/spacer.png" />
				<img id="minutesDownLeftBack"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Left/0.png" />
				<img id="minutesDownRightBack" src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Right/0.png" />
				<img id="secondsDownLeftBack"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Left/0.png" />
				<img id="secondsDownRightBack" src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Right/0.png" />
			</div>
			</div>

			<div id="front">
			<div id="upperHalf">
				<img src="<?php echo $theme_uri; ?>/pomodoro/spacer.png" />
				<img id="minutesUpLeft"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Left/0.png" />
				<img id="minutesUpRight" src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Right/0.png"/>
				<img id="secondsUpLeft"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Left/0.png" />
				<img id="secondsUpRight" src="<?php echo $theme_uri; ?>/pomodoro/Double/Up/Right/0.png"/>
			</div>

			<div id="lowerHalf">
				<img src="<?php echo $theme_uri; ?>/pomodoro/spacer.png" />
				<img id="minutesDownLeft"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Left/0.png" />
				<img id="minutesDownRight" src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Right/0.png" />
				<img id="secondsDownLeft"  src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Left/0.png" />
				<img id="secondsDownRight" src="<?php echo $theme_uri; ?>/pomodoro/Double/Down/Right/0.png" />
			</div>
			</div>
		</div><!-- fecha relogio -->
		
		<div id="relogio-digital" aria-label="Hora atual">
			<span id="relogio-horas">00</span>:<span id="relogio-minutos">00</span>
		</div>

		<input type="text" disabled="disabled" id="secondsRemaining_box">
		
		<ul id="pomolist">
			<li class="pomoindi" id="pomoindi1">1</li>		
			<li class="pomoindi" id="pomoindi2">2</li>
			<li class="pomoindi" id="pomoindi3">3</li>
			<li class="pomoindi" id="pomoindi4">4</li>
		</ul>
		
		<button onclick="reset_pomodoro_session()" style="margin: 8px 0 0 12px;" class="btn-transparent btn-round" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Reiniciar"><span class="fas fa-arrows-rotate" aria-hidden="true"></span></button>
		<button onclick="set_continuous_session()" style="margin: 8px 0 0 4px;" id="resetter_btn" class="btn-transparent btn-round" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Sem pausa"><span class="fas fa-forward" aria-hidden="true"></span></button>
		</div><!--fecha pomodoros painel-->
		<br />
		
		<!-- <div id="mascote_float">
			<div id="div_status"><?php #_e("Hello, welcome", "sis-foca-js"); ?></div>
			<img src="<?php #bloginfo('stylesheet_directory'); ?>/images/mascote_foca.png" />
		</div> -->
		
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link  active" href="#profile" role="tab" data-toggle="tab" aria-selected="true"><span><span class="fas fa-stopwatch" aria-hidden="true"></span> Pomodoro</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#buzz" role="tab" data-toggle="tab"><span><span class="fas fa-list" aria-hidden="true"></span> Todo</span></a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div id="tab-focus" class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="profile">
				<form name="pomopainel" id="pomopainel">		
					<div class="form-group">
						<label><span class="fas fa-paste" aria-hidden="true"></span> <?php _e("Task", "sis-foca-js"); ?></label><br />
						<input type="text" id="title_box" maxlength="70" tabindex="2" name="ti33" class="form-control">
						</input>
					</div>
					<div class="form-group">
						<label><span class="fas fa-tags" aria-hidden="true"></span> <?php _e("Project tags", "sis-foca-js"); ?></label>
						<select id="tags_box" class="js-example-tags " tabindex="3" multiple="multiple" placeholder="Does not work, use data-placeholder with js trick"  data-placeholder="projeto1, projeto2"></select>
					</div>

					<div class="form-group">
						<label><span class="fas fa-note-sticky" aria-hidden="true"></span> <?php _e("Notes", "sis-foca-js"); ?></label>
						<textarea rows="2" cols="34" id="description_box" tabindex="4" class="form-control"></textarea>
					</div>
					
					<label><span class="fas fa-paperclip" aria-hidden="true"></span> <?php _e("What kind of taks is that?", "sis-foca-js"); ?></label><br />
					<ul>
						<li><input type="radio" name="cat_vl" value="27" CHECKED> <?php _e("Work", "sis-foca-js"); ?></li>
						<li><input type="radio" name="cat_vl" value="26"> <?php _e("Study", "sis-foca-js"); ?></li>
						<li><input type="radio" name="cat_vl" value="28"> <?php _e("Personal", "sis-foca-js"); ?></li>
					</ul>
					<label><span class="fas fa-eye" aria-hidden="true"></span> <?php _e("Privacy", "sis-foca-js"); ?></label><br />
					<ul>
						<li><input type="radio" name="priv_vl" value="publish" CHECKED> <?php _e("Public - everyone can see", "sis-foca-js"); ?></li>
						<li><input type="radio" name="priv_vl" value="private"> <?php _e("Private - only you can see", "sis-foca-js"); ?> (fora do ranking)</li>
					</ul>
					<button class="btn btn-dark btn-darkness" id="botao-salvar-modelo" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="<?php _e("You can save your tasks for later", "sis-foca-js"); ?> na sua lista TODO"><span class="fas fa-save" aria-hidden="true"></span> <?php _e("Save Task", "sis-foca-js"); ?> </button>
					<input type="hidden" id="data_box">
					<input type="hidden" id="status_box">
					<input type="hidden" id="post_id_box">
					<input type="hidden" id="pomodoroAtivoBox" value='<?php echo get_user_meta(get_current_user_id(), "pomodoroAtivo", true); ?>'>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="buzz">
				<div class="container">
					<div id="auto_cicler" class="row">
						<label><span class="fas fa-arrows-spin" aria-hidden="true"></span> <?php _e("Automatic cycle", "sis-foca-js"); ?></label>
						<div class="col-12">
							<p style="margin:0 auto;">
								<button class="btn btn-transparent btn-round" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Iniciar ciclador" id="cycle_start"><span class="fas fa-play" aria-hidden="true"></span></button>
								&nbsp; 
								<button class="btn btn-transparent btn-round" id="cycle_prev" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Voltar tarefa"><span class="fas fa-backward" aria-hidden="true"></span></button> &nbsp; 
								<button class="btn btn-transparent btn-round" id="cycle_next" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Próxima tarefa"><span class="fas fa-forward" aria-hidden="true"></span></button> &nbsp; 
								<button class="btn btn-transparent btn-round" id="cycle_empty" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="Limpar Ciclador"><span class="fas fa-trash" aria-hidden="true"></span></button>
							</p>
						</div>
						<label><small><?php _e("Drop tasks below", "sis-foca-js"); ?></small></label>
						<ul id="contem-ciclo" style="">
							<?php echo get_user_meta(get_current_user_id(), "cycle_list", true); ?>
						</ul>
					</div>
					<div class="row">
						<label><span class="fas fa-list" aria-hidden="true"> </span><?php _e("TODO list", "sis-foca-js"); ?></label>	
						<ul id="contem-modelos">
							<?php
							$args = array(
									'post_type' => 'projectimer_focus',
									'post_status' => 'pending',
									'author'   => get_current_user_id(),
									//'orderby'   => 'title',
									'order'     => 'ASC',
									'posts_per_page' => -1,
									);
							$the_query = new WP_Query( $args );
							
							while ( $the_query->have_posts() ) : $the_query->the_post();
								$counter = $post->ID; ?>
								<li class="modelo-carregado" id="modelo-carregado-<?php echo $counter; ?>">
								
								<?php
								$taglist = "";
								$posttags = get_the_tags();
								if ($posttags) {
									$i=1;
									$c=count($posttags);
									foreach($posttags as $tag) {
										if($i<$c)
											$taglist.="<span class='fas fa-tags' aria-hidden='true'></span>".$tag->slug.", ";
										else
											$taglist.="<span class='fas fa-tags' aria-hidden='true'></span>".$tag->slug." ";
										$i++;
									}
								}
								?>
								
								<div class="model-container row" data-modelid="<?php echo $counter ?>">
									<div class="col-12">
										<span class='fas fa-move' aria-hidden='true'></span> &nbsp;
										<?php echo '<span id=bxtitle'.$counter.' data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" data-content="'.$taglist.'" aria-hidden="true">'.get_the_title()."</span>"; ?>
									</div>
									<div class="col-12" style="display:none">
										<?php echo "<span id=bxtag$counter><b>".$taglist."</b></span>"; ?>
									</div>
								</div>
								<div class="model-container-extra">
									<button class='btn btn-xs btn-success delete-task-model-btn' data-modelid="<?php echo $counter ?>"><span class="fas fa-check"></span></button>
									<button' class='btn btn-xs btn-none remove-task-from-list-btn' data-modelid="<?php echo $counter ?>"><span class="fas fa-trash red" style="color:black"></span></button>
								</div>

								</li>
								
								
							<?php 
							endwhile;
							// Reset Post Data
							wp_reset_postdata();
							?>
							<?php 
									/*
									style="width: 90%;float: left;" 

									<div class="delete-task-model" style="float: right;"></div>

									<!--div class='col-xs-10'-->
									<!--a href="#" onclick='load_model(<?php echo $counter ?>)'>
								LO
								</a-->
								<!--div class='col-xs-2'-->
								*/
									#onclick='delete_model(<?php echo $counter ?)' 
									#echo "<input type='button' class='btn btn-xs btn-primary' value='carregar' onclick='load_model($counter)'><br /> <br /><input type='button' class='btn btn-xs btn-success' value='concluir' onclick='delete_model($counter)'>"; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div><!-- #content -->

</div>
<?php #locate_template( array( 'sidebar-pomodoro-right.php' ), true ); ?>
