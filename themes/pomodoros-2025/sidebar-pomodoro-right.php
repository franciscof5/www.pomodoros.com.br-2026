<?php do_action( 'bp_before_sidebar' ); ?>

<div id="sidebar-pomodoro-right" class="sidebar col-xs-6 col-sm-6 col-md-3 hidden-xs">
	<!--center><button data-toggle="collapse" data-target="#sidebar_pomodoro_padder"><span class="glyphicon glyphicon-resize-vertical"></span></button></center-->

	<!--button data-toggle="collapse" data-target="#default_sidebar_in" class="collapse_button collapse_right" ><span class="glyphicon glyphicon-resize-horizontal"></span></button-->

	<div class="padder width" id="sidebar_pomodoro_padder">

		<li>
		<h3><?php _e("Sponsored by", "sis-foca-js"); ?></h3>
		<?php 
		echo show_sponsor("excerpt");
		?>
		</li>

		<li>
			<h3><?php _e("Buy to support our free services", "sis-foca-js"); ?></h3>
			<?php 
			echo do_shortcode('[product id="5912"]'); 
			?>
		</li>
		
		<li>
			<?php 
			global $current_user;
			wp_get_current_user(); 
			?>
			<h3 class="widget-title"><?php _e("Statistics from", "sis-foca-js"); echo " ".$current_user->display_name; ?></h3>
			
			<?php
			$produtividade_usuario = user_object_productivity_human_time_diff(bp_displayed_user_id());
			?>
			<div class="table-responsive">
			<table class="table table-striped table-responsive table-condensed">
				<thead>
					<tr>
						<th>Period</th>
						<th>Time</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e("Time from register", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["sempre"]['totalDias_human']; ?></td>
					</tr>
					<tr>
						<td><?php _e("Work time", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["sempre"]['diasTrabalhados']; ?> <?php _e("days", "sis-foca-js"); ?></td>
					</tr>
					<tr>
						<td><?php _e("Time not worked", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["sempre"]['diasFolga']; ?> <?php _e("days", "sis-foca-js"); ?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-responsive table-condensed">
				<thead>
					<tr>
						<th>Period</th>
						<th>Days</th>
						<th>%</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php _e("Last 7 days", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["setedias"]['diasTrabalhados']."/7"; ?></td>
						<td><?php echo ($produtividade_usuario["setedias"]['fatorProdutividade']*100)."%"; ?></td>
					</tr>
					<tr>
						<td><?php _e("Current month", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["mes"]['diasTrabalhados']."/".$produtividade_usuario["mes"]['totalDias']; ?></td>
						<td><?php echo ($produtividade_usuario["mes"]['fatorProdutividade']*100)."%"; ?></td>
					</tr>
					<tr>
						<td><?php _e("Since beggining", "sis-foca-js"); ?></td>
						<td><?php echo $produtividade_usuario["sempre"]['diasTrabalhados']."/".$produtividade_usuario["sempre"]['totalDias']; ?></td>
						<td><?php echo ($produtividade_usuario["sempre"]['fatorProdutividade']*100)."%"; ?></td>
					</tr>
				</tbody>
			</table>
			</div>
			<?php /*
			<p>
				<span><?php _e("Time from register", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["sempre"]['totalDias']; ?></span>
				<br>
				<span><?php _e("Work time", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["sempre"]['diasTrabalhados']; ?> </span>
				<br>
				<span><?php _e("Not work time", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["sempre"]['diasFolga']; ?> </span>
			</p>
			<!--p>Produtividade</p-->
			<!--p>Dia trabalhados/total dias no período, fator desempenho (%)</p-->
			<p>
				<!--li>Hoje :<?php echo $produtividade_usuario["semana"]['totalDias']; ?> </li-->
				<span><?php _e("Last 7 days", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["setedias"]['diasTrabalhados']."/7".", ".($produtividade_usuario["setedias"]['fatorProdutividade']*100)."%"; ?> </span>
				<br>
				<span><?php _e("Current month", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["mes"]['diasTrabalhados']."/".$produtividade_usuario["mes"]['totalDias'].", ".($produtividade_usuario["mes"]['fatorProdutividade']*100)."%"; ?> </span>
				<br>
				<span><?php _e("Since beggining", "sis-foca-js"); ?>: <?php echo $produtividade_usuario["sempre"]['diasTrabalhados']."/".$produtividade_usuario["sempre"]['totalDias'].", ".($produtividade_usuario["sempre"]['fatorProdutividade']*100)."%"; ?> </span>
			</p>*/
			?>
		</li>

		<li>
			<h3 class="widget-title"><?php _e("Export Calendar", "sis-foca-js"); ?> (iCal)</h3>
			<p><?php _e("See your pomodoros in the calendars of Google, Apple, Microsoft and others.", "sis-foca-js"); #Veja seus pomodoros nos calendários da Google, Apple, Microsoft e outros. ?></p>
			<p><a href="/calendar" class="btn btn-primary btn-xs" style="text-transform: uppercase;"><?php _e("Export Calendar", "sis-foca-js"); ?></a></p>
		</li>
		<li>
			<h3 class="widget-title"><?php _e("Export Worksheet", "sis-foca-js"); #Exportar Planilha ?></h3>
			<p><?php _e("Have control over your data, view your pomodoros in Microsoft Excel, LibreOffice Calc and others", "sis-foca-js"); #Tenha controle sobre seus dados, visualize seus pomodoros no Microsoft Excel, LibreOffice Calc e outros ?></p>
			<p><a href="/csv" class="btn btn-primary btn-xs" style="text-transform: uppercase;"><?php _e("Export Worksheet", "sis-foca-js"); ?></a></p>
		</li>
		<li>
			<h3 class="widget-title"><?php _e("Your projects", "sis-foca-js"); ?></h3>
			<p><?php get_projectimer_project_tags(get_current_user_id());	?></p>
		</li>

		<!--li>
			<h3 class="widget-title">Spotify</h3>
			<p><iframe src="https://open.spotify.com/user/nsqx6avzxhybkmfumqb1juwmn/playlist/5jtIpYaaFTza3O9ZnaVrLa?si=Wp_OCq20RGOEPj2JFFwYoQ" width="100%" height="300" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe></p>
		</li-->
		
		<!--li>
			<p><?php the_widget( 'WP_Widget_Tag_Cloud', "title=Projetos da Comunidade", 'before_title=<h3 class="widget-title">&after_title=</h3>' ); ?> </p>
		</li-->
		
	<?php #dynamic_sidebar( 'pomodoros' ); ?>
	</div><!-- .padder -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ); ?>
	<?php /*
	<h3><script>document.write(txt_tips_heading)</script></h3>
	<p><script>document.write(txt_tips_description)</script></p>
	<input type="button" onclick="proxima_dica()" value="" id="botao_dicas">
	<ul id="dicas">
		<li id="dica_1"><script>document.write(txt_tips_1)</script></li>
		<li id="dica_2"><script>document.write(txt_tips_2)</script></li>
		<li id="dica_3"><script>document.write(txt_tips_3)</script></li>
		<li id="dica_4"><script>document.write(txt_tips_4)</script></li>
		<li id="dica_5"><script>document.write(txt_tips_5)</script></li>
		<li id="dica_6"><script>document.write(txt_tips_6)</script></li>
		<li id="dica_7"><script>document.write(txt_tips_7)</script></li>
		<li id="dica_8"><script>document.write(txt_tips_8)</script></li>
		<li id="dica_9"><script>document.write(txt_tips_9)</script></li>
		<li id="dica_10"><script>document.write(txt_tips_last)</script></li>
	</ul>
	*/ ?>
	
