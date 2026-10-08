<?php die("tag-(now...") get_header();
/*
<script src="https://www.google.com/jsapi"></script>
<script src='https://www.google.com/jsapi'></script>  ?>
<script src="https://www.gstatic.com/charts/loader.js"></script>*/ ?>
AAAAAAAAAAAAAAa
<script src='https://www.google.com/jsapi'></script>

		
    <!--script>
     
     google.load("visualization", "1.1", {packages:["calendar"]});
     google.setOnLoadCallback(drawChart);

   function drawChart() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
          [ new Date(2012, 3, 13), 37032 ],
          [ new Date(2012, 3, 14), 38024 ],
          [ new Date(2012, 3, 15), 38024 ],
          [ new Date(2012, 3, 16), 38108 ],
          [ new Date(2012, 3, 17), 38229 ],
          // Many rows omitted for brevity.
          [ new Date(2013, 9, 4), 38177 ],
          [ new Date(2013, 9, 5), 38705 ],
          [ new Date(2013, 9, 12), 38210 ],
          [ new Date(2013, 9, 13), 38029 ],
          [ new Date(2013, 9, 19), 38823 ],
          [ new Date(2013, 9, 23), 38345 ],
          [ new Date(2013, 9, 24), 38436 ],
          [ new Date(2013, 9, 30), 38447 ],
          [ new Date(2014, 1, 24), 38436 ]
        ]);

       var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

       var options = {
         title: "Pomodoros completados",
         height: 350,
       };

       chart.draw(dataTable, options);
   }
    </script-->
    <script>
      //google.charts.load("current", {packages:[]});
      //google.charts.setOnLoadCallback(drawChart);

	   function drawChart2() {
	       var dataTable = new google.visualization.DataTable();
	       dataTable.addColumn({ type: 'date', id: 'Date' });
	       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
	       dataTable.addRows([
	          [ new Date(2012, 3, 13), 37032 ],
	          [ new Date(2012, 3, 14), 38024 ],
	          [ new Date(2012, 3, 15), 38024 ],
	          [ new Date(2012, 3, 16), 38108 ],
	          [ new Date(2012, 3, 17), 38229 ],
	          // Many rows omitted for brevity.
	          [ new Date(2013, 9, 4), 38177 ],
	          [ new Date(2013, 9, 5), 38705 ],
	          [ new Date(2013, 9, 12), 38210 ],
	          [ new Date(2013, 9, 13), 38029 ],
	          [ new Date(2013, 9, 19), 38823 ],
	          [ new Date(2013, 9, 23), 38345 ],
	          [ new Date(2013, 9, 24), 38436 ],
	          [ new Date(2013, 9, 30), 38447 ]
	        ]);

	       var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

	       var options = {
	         title: "Red Sox Attendance",
	         height: 350,
	       };

	       chart.draw(dataTable, options);
	   }

			google.load('visualization', '1', {packages:['gauge','calendar']});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				["prod.", <?php echo $fatorProdutividadeProjeto; ?>]
			]);

			var options = {
				width: 400, height: 220,
				redFrom: 90, redTo: 100,
				yellowFrom:75, yellowTo: 90,
				greenFrom:50, greenTo: 75,
				minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('projeto_produtividade_div'));
				chart.draw(data, options);
				//drawChart2();
			}
		</script>

<!--style>
	ul.item-list li.activity-item {width: 16% !important;}
</style>

<div id="calendar_basic" style="width: 1000px; height: 350px;"></div-->
<div class="content_nosidebar container-fluid">
	<?php do_action( 'bp_before_blog_home' ) ?>

	<!--div id="calendar_basic" style="width: 100%; height: 350px;"></div-->

	<?php
		//override query parameters
		global $query_string;
		$query = query_posts( $query_string . '&posts_per_page=5000000&post_type=projectimer_focus' );
		//var_dump(count($query));
		?>
		<?php
		$projetoNome = single_tag_title("", false);
		$projetoTotalPomodoros = count($query);
		$projetoHorasTrabalhadas = round(count($query)/2);
		//$projetoDiasTrabalhados = query_posts( $query_string . '&tag=apples' );
		//$projetoDiasTrabalhados = $wpdb->query('SELECT * FROM `wp_posts`,`wp_postmeta` WHERE `post_author` = '.get_current_user_id( ).' GROUP BY DATE (`post_date`)');
		/*$projetoDiasTrabalhados = $wpdb->query(
			'
			SELECT $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug
			FROM $wpdb->terms
		    	INNER JOIN $wpdb->term_taxonomy ON ($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
		    	INNER JOIN $wpdb->term_relationships ON ($wpdb->terms.term_id = $wpdb->term_relationships.term_taxonomy_id)
		    	INNER JOIN $wpdb->posts ON ($wpdb->term_relationships.object_id = $wpdb->posts.ID)
			WHERE $wpdb->term_taxonomy.taxonomy = "f5sites"
			ORDER BY $wpdb->posts.post_date DESC
			'
		);*/
		
		$query_by_authors = array();
		$query_by_post_title = array();
		$query_by_post_date = array();

		foreach($query as $entity)
		{
			if(!isset($query_by_authors[$entity->post_author]))
			{
				$query_by_authors[$entity->post_author] = array();
			}

			$query_by_authors[$entity->post_author][] = $entity;
		}
		//var_dump($query);die;
		foreach($query as $entity)
		{
			if(!isset($query_by_post_title[$entity->post_title]))
			{
				$query_by_post_title[$entity->post_title] = array();
			}

			$query_by_post_title[$entity->post_title][] = $entity;
		}
		foreach($query as $entity)
		{
			$dataAglutinadora = substr($entity->post_date,0,10); //data que vai reunir posts
			if(!isset($query_by_post_date[$dataAglutinadora]))
			{
				$query_by_post_date[$dataAglutinadora] = array();
			}
			$query_by_post_date[$dataAglutinadora][] = $entity;
		}
		$projetoColaboradores = count($query_by_authors);
		$projetoInicio  = $query[count($query)-1]->post_date;
		$projetoFinal = $query[0]->post_date;
		$projetoDuracao = ceil((strtotime($projetoFinal) - strtotime($projetoInicio))/60/60/24);
		if($projetoDuracao==0)$projetoDuracao=1;
		$projetoDiasTrabalhados = count($query_by_post_date);
		if($projetoDiasTrabalhados==0)$projetoDiasTrabalhados=1;
		/*foreach(array_keys($query_by_post_title) as $key){
			echo $key."<hr />";
		}*/
		//die;
		?>
		<div class="row">
			<h1>Projeto: <?php echo $projetoNome; ?></h1>
			<h3>Líder do projeto: </h3>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<p>Tempo de trabalho: <strong><?php echo $projetoHorasTrabalhadas; ?>h</strong></p>
				<p>Total de pomodoros completados neste projeto: <strong><?php echo $projetoTotalPomodoros; ?></strong></p>
				<p>Quantidades de colaboradores: <strong><?php echo $projetoColaboradores; ?> pessoas</strong></p>
				<p>Duração do projeto: <strong><?php echo $projetoDuracao; ?> dias</strong></p>
				<p>Dias trabalhados neste projeto: <strong><?php echo $projetoDiasTrabalhados; ?> dias</strong></p>
				<p>Fator produtividade do projeto: <strong><?php echo $fatorProdutividadeProjeto = round($projetoDiasTrabalhados/$projetoDuracao*100) ?></strong></p>
				<p>Data do primeiro pomodoro: <strong><?php echo $projetoInicio; ?></strong></p>
				<p>Data do último pomodoro: <strong><?php echo $projetoFinal; ?></strong></p>
			</div>
			<div class="col-sm-6">
				<h3>Stats</h3>
				<p>Média de pomodoros/total de dias: <strong><?php echo round($projetoTotalPomodoros/$projetoDuracao, 2); ?> pomodoros</strong></p>
				<p>Média de horas de trabalho/total de dias: <strong><?php echo round($projetoHorasTrabalhadas/$projetoDuracao, 2); ?>h</strong></p>
				<p>Média de pomodoros/dias trabalhados: <strong><?php echo round($projetoTotalPomodoros/$projetoDiasTrabalhados, 2); ?> pomodoros</strong></p>
				<p>Média de horas de trabalho/dias trabalhados: <strong><?php echo round($projetoHorasTrabalhadas/$projetoDiasTrabalhados, 2); ?>h</strong></p>
				<h3>Fator produtividade do projeto</h3>
			</div>
		</div>
		<div id='projeto_produtividade_div'></div>
		<h2>Lista de tarefas</h2>
		<p>Todas as tarefas feitas nesse projeto, organizadas por data:</p>
		<!--script src="https://www.google.com/jsapi"></script-->
		<script>
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);
			function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Task', 'Pomodoros completados'],
				<?php 
				foreach ($query_by_post_title as $arrayOfTitles) {
					echo "[\"".$arrayOfTitles[0]->post_title."\",".count($arrayOfTitles)."],";
				} ?>
			]);

			var options = {
				pieHole: 0.3,
			};

			var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
				chart.draw(data, options);
			}
		</script>
		<div id="donutchart" style="width: 100%; height: 600px;"></div>

		<!--script src='https://www.google.com/jsapi'></script-->
		<script>
			google.load('visualization', '1', {packages:['table']});
			google.setOnLoadCallback(drawTable);
			function drawTable() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Tarefa');
				data.addColumn('number', 'Pomodoros');
				data.addColumn('number', 'Horas');
				data.addColumn('number', 'Porcentagem');
				data.addRows([
					<?php foreach ($query_by_post_title as $arrayOfTitles) { 
						echo "[\"".$arrayOfTitles[0]->post_title."\",".
						count($arrayOfTitles).",".
						ceil(count($arrayOfTitles)/2).",".
						round((count($arrayOfTitles)/$projetoTotalPomodoros)*100,2)."],"; 
					} ?>	
				]);

				var table = new google.visualization.Table(document.getElementById('tasks_table_div'));
				table.draw(data, {showRowNumber: true});
			}
		</script>
		<div id='tasks_table_div'></div>

		<ul>
			<?php /*foreach ($query_by_post_title as $arrayOfTitles) { ?>
				<li><?php echo $arrayOfTitles[0]->post_title." (".
				count($arrayOfTitles)." pomodoros) (".
				ceil(count($arrayOfTitles)/2)." horas) (".
				round((count($arrayOfTitles)/$projetoTotalPomodoros)*100)."%)"; ?></li>
			<?php } */?>
		</ul>
		<h2>Membros</h2>
		<p>Quem trabalhou nesse projeto (ordenado por horas dedicas ao projeto):</p>
		<script src='https://www.google.com/jsapi'></script>
		<script>
			google.load('visualization', '1', {packages:['table']});
			google.setOnLoadCallback(drawTable);
			function drawTable() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Colaborador');
				//data.addColumn('html', 'Imagem')
				data.addColumn('number', 'Pomodoros');
				data.addColumn('number', 'Horas');
				data.addColumn('number', 'Valor/hora (R$)');
				data.addColumn('number', 'Total (R$)');
				data.addRows([
					<?php foreach($query_by_authors as $arrayOfAuthors) {
						$nome = bp_core_get_user_displayname($arrayOfAuthors[0]->post_author);
						echo "[\"".(empty($nome) ? "Usuário não logado" : $nome)."\",".
						//get_avatar( get_the_author_meta( 'user_email' ), '50' ).",".
						count($arrayOfAuthors).",".
						ceil(count($arrayOfAuthors)/2).",".
						"50,".
						round((count($arrayOfAuthors)/2)*50,2)."],"; 
					} ?>	
				]);

				var table = new google.visualization.Table(document.getElementById('authors_table_div'));
				table.draw(data, {
					showRowNumber: true,
					allowHtml:true,
					sortAscending:false,
					sortColumn:2
				});
			}
		</script>
		<div id='authors_table_div'></div>

		<!--ul>
			<li></li>
			<li>francisco (12 pomodoros) (6 horas) (R$30/hora) (R$180,00)</li>
			<li>fabio (6 pomodoros) (3 horas) (R$200/hora) (R$600,00)</li>
		</ul
		<h2>Orçamento</h2>
		<ul>
			<li>Total de horas:</li>
			<li>Pessoas envolvidas no projeto:</li>
			<li>Valor medio da hora:</li>
			<li>Valor total do orcamento</li>
		</ul-->
		<hr />
		<h2>Mural do projeto</h2>
		<div class="row">
		<?php if ( have_posts() ) : ?>
			<ul id="activity-stream" class="activity-list item-list">
				<?php while (have_posts()) : the_post(); ?>
				
				<?php do_action( 'bp_before_blog_post' ) ?>
				
				<li class="activity-item col-xs-4 col-sm-3 col-md-2">
					<div class="activity-avatar">
						<!--a href="http://pomodoros.com.br/colegas/thais/">
						<img src="http://www.gravatar.com/avatar/db64ee70f74329fd462a3d436eb40c72?d=http://pomodoros.com.br/wp-content/plugins/buddypress/bp-core/images/mystery-man.jpg&amp;s=50&amp;r=G" alt="Thais B" class="avatar user-825-avatar" height="50" width="50">
						</a-->
						<a href="<?php echo bp_core_get_userlink( bp_loggedin_user_id(), false, true ); ?>" title="Perfil de <?php echo bp_core_get_user_displayname( bp_loggedin_user_id() ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '64' ); ?>
						</a>
					</div>
					<div class="activity-content">
						<div class="activity-header">
							<p>
								<!--a href="http://pomodoros.com.br/colegas/thais/" title="Thais B">Thais B</a> completou um pomodoro, <a href="http://pomodoros.com.br/finalizar-todas-as-pendencias-do-caderninho-7/">finalizar todas as pendencias do caderninho</a-->
								<?php //printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?>
								<a href="<?php echo bp_core_get_userlink( bp_loggedin_user_id(), false, true ); ?>" title="<?php echo bp_core_get_user_displayname( bp_loggedin_user_id() ); ?>"><?php echo bp_core_get_user_displayname( bp_loggedin_user_id() ); ?></a> completou um pomodoro, <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
								<a href="<?php the_permalink() ?>" class="view activity-time-since" title="Ver Discussão">
								<!--span class="time-since">21 horas, 21 minutos atrás</span></a-->
								<?php 
								#human_time_diff(
								#echo the_time();
								echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' atrás'; 
								#printf( '<span class="time-since">%4$s</span></a>', the_time() ); 
								#bp_get_activity_comment_date_recorded(); ?>
							</p>
						</div>
						<!--div class="activity-meta">
							<a href="http://pomodoros.com.br/mural/favorite/3050/?_wpnonce=c0fa7588b3" class="button fav bp-secondary-action" title="Marcar como Favorito">Favorito</a>
							<a href="http://pomodoros.com.br/mural/delete/3050?_wpnonce=eb2bbc793e" class="button item-button bp-secondary-action delete-activity confirm" rel="nofollow">Excluir</a>		
						</div-->
					</div>
				</li>
				
				<?php /*
				<div class="post" id="post-<?php the_ID(); ?>">
					<div class="author-box">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></p>
					</div>

					<div class="post-content">
						<h2 class="posttitle"><?php the_time('G:i') ?> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						<!--p class="date"><?php the_date('m');/*.the_time()* ?> <em><?php _e( 'in', 'buddypress' ) ?> <?php the_category(', ') ?> <?php printf( __( 'by %s', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ) ?></em></p-->

						<div class="entry">
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
						</div>

						<!--p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p-->
					</div>
				</div>
				*/?>
				<?php do_action( 'bp_after_blog_post' ) ?>
				<?php endwhile; ?>
			</ul>
			</div>
			<?php 
			//echo '</div>';
			?>
			<!--div class="navigation">

				<div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
				<div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>

			</div-->

		<?php else : ?>

			<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
			<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

			<?php locate_template( array( 'searchform.php' ), true ) ?>

		<?php endif; ?>
	
	
	<?php do_action( 'bp_after_blog_home' ) ?>
	
	
	<?php if(function_exists('pf_show_link')){echo pf_show_link();}  ?>
	
	<?php global $post; ?>
	<hr />
	<!--a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?pfstyle=wp">GERAR PDF</a-->

</div><!-- #content -->

<?php //locate_template( array( 'sidebar-pomodoro-left.php' ), true ) ?>

<?php get_footer() ?>