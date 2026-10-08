<?php
/*
Template Name: Template Redirect Closed
*/

get_header("app");

$custom_page = get_query_var('custom_page');

locate_template( "pages/page-".$custom_page.".php", true );

get_footer();
?>
