<script src="https://www.google.com/jsapi"></script>

<?php

$produtividade_usuario = user_object_productivity(bp_displayed_user_id());
//echo "<script>alert('desenha gagues');</script>";

//var_dump($produtividade_usuario);
// var data = google.visualization.arrayToDataTable([
// 	['Label', 'Value'],
// 	['Sempre', ".($produtividade_usuario["sempre"]['fatorProdutividade']*100)."],
// 	['30 dias', ".($produtividade_usuario["trintadias"]['fatorProdutividade']*100)."],
// 	['Mes', ".($produtividade_usuario["mes"]['fatorProdutividade']*100)."],
// 	['7 dias', ".($produtividade_usuario["setedias"]['fatorProdutividade']*100)."],
// 	['Semana', ".($produtividade_usuario["semana"]['fatorProdutividade']*100)."],
// ]);
echo "<script>
	google.load('visualization', '1', {packages:['gauge']});
  	google.setOnLoadCallback(drawChart);
  	function drawChart() {
		var data1 = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['Sempre', ".($produtividade_usuario["sempre"]['fatorProdutividade']*100)."],
		]);

		var data2 = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['30 dias', ".($produtividade_usuario["trintadias"]['fatorProdutividade']*100)."],
		]);

		var data3 = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['Mes', ".($produtividade_usuario["mes"]['fatorProdutividade']*100)."],
		]);

		var data4 = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['7 dias', ".($produtividade_usuario["setedias"]['fatorProdutividade']*100)."],
		]);

		var data5 = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['Semana', ".($produtividade_usuario["semana"]['fatorProdutividade']*100)."],
		]);
		
		var options = {
			redFrom: 90, redTo: 100,
			yellowFrom:75, yellowTo: 90,
			greenFrom:50, greenTo: 75,
			greyFrom:25, greyTo:50,
			minorTicks: 5
		};

		var chart1 = new google.visualization.Gauge(document.getElementById('chart_gauges_div1'));
		var chart2 = new google.visualization.Gauge(document.getElementById('chart_gauges_div2'));
		var chart3 = new google.visualization.Gauge(document.getElementById('chart_gauges_div3'));
		var chart4 = new google.visualization.Gauge(document.getElementById('chart_gauges_div4'));
		var chart5 = new google.visualization.Gauge(document.getElementById('chart_gauges_div5'));

		chart1.draw(data1, options);
		chart2.draw(data2, options);
		chart3.draw(data3, options);
		chart4.draw(data4, options);
		chart5.draw(data5, options);
  	}

	</script>";
?>

<div id="estats_box_div" class="row">
	<div class="col-md col-xs-6 col-sm-4">
		<div id='chart_gauges_div1'></div>
		<h3>Desde sempre</h3>
		<ul>
			<li>registrado:<strong>
				<?php
				echo $produtividade_usuario["sempre"]['totalDias'];
				?> </strong></li>
			<li>trabalho:<strong>
				<?php
				//Dias de servidao cruel (dias de trabalho)
				echo $produtividade_usuario["sempre"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>descanso:<strong>
				<?php
				//dias se sentindo culpado por nao trabalhar (dias sem trabalho)
				echo $produtividade_usuario["sempre"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["sempre"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
		<!--div id="chart_div" style="width: 900px; height: 500px;margin-top:200px;"-->
	</div>
	
	<div class="col-md col-xs-6 col-sm-4">
		<div id='chart_gauges_div2'></div>
		<h3>Últimos 30 dias</h3>
		<ul>
			<li>trabalho:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>descanso:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["trintadias"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	
	<div class="col-md col-xs-6 col-sm-4">
		<div id='chart_gauges_div3'></div>
		<h3>Mês atual</h3>
		<ul>
			<li>trabalho:<strong>
				<?php
				echo $produtividade_usuario["mes"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>descanso:<strong>
				<?php
				echo $produtividade_usuario["mes"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["mes"]['fatorProdutividade']*100;
				?>
			</strong></li>
			<li>*atual:<strong>
				<?php
				echo $produtividade_usuario["mes"]['totalDias'];
				?>
			</strong></li>
		</ul>
	</div>
	<div class="col-md col-xs-6 col-sm-4">
		<div id='chart_gauges_div4'></div>
		<h3>Últimos 7 dias</h3>
		<ul>
			<li>trabalho:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>descanso:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["setedias"]['fatorProdutividade']*100;
				?>
			</strong></li>
		</ul>
	</div>
	<div class="col-md col-xs-6 col-sm-4">
  		<div id='chart_gauges_div5'></div>
		<h3>Semana atual</h3>
		<ul>
			<li>trabalho:<strong>
				<?php
				echo $produtividade_usuario["semana"]['diasTrabalhados'];
				?>
			</strong></li>
			<li>descanso:<strong>
				<?php
				echo $produtividade_usuario["semana"]['diasFolga'];
				?>
			</strong></li>
			<li>Fator prod.:<strong>
				<?php
				echo $produtividade_usuario["semana"]['fatorProdutividade']*100;
				?>
			</strong></li>
			<li>* Dia atual:<strong>
				<?php
				echo $produtividade_usuario["semana"]['totalDias'];
				?>
			</strong></li>
		</ul>
	</div>
	<hr style="clear:both;width:100%"></hr>
</div>