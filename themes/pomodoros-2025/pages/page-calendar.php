<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Calendar', 'sis-foca-js'); ?>";
</script>

<div class="content_nosidebar">
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->

	<?php echo do_shortcode("[ranking-calendar]"); ?>
</div><!-- #content -->