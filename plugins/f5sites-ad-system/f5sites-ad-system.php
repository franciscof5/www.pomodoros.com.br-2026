<?php
/*
Plugin Name: F5 Sites | Ad System
Plugin URI: https://www.f5sites.com/f5sites-ad-system
Plugin Description: Show sponsors an ad over the f5sites fnetwork
Author: Francisco Matelli Matulovic
Author URI: https://www.franciscomat.com/
License: GPLv3
Tags: mu-plugins */

if( !defined( 'ABSPATH') ) exit();

add_shortcode( 'show_sponsor_geo', 'show_sponsor' );

//box-float
function show_sponsor($type_of="excerpt", $hide_title="false") {
	global $user_prefered_language;
	#echo $user_prefered_language;
	switch ($user_prefered_language) {
		case 'notset' :
		case 'en' :
		case 'en_US' :
			$post_id = 5985;
			break;
		
		case 'pt' :
		case 'pt_BR' :
			$post_id = 5980;
			break;

		case 'fr' :
		case 'fr_FR' :
			$post_id = 5987;
			break;

		case 'es' :
		case 'es_ES' :
			$post_id = 5986;
			break;

		case 'zh' :
		case 'zh_CN' :
			$post_id = 5988;
			break;

		default:
			$post_id = 5985;
			break;
	}
	#echo $post_id;
	if(function_exists("set_shared_database_schema"))
	set_shared_database_schema();

	$post_object = get_post( $post_id );
	#setup_postdata( $post_object );
	$ctt="";
	if($type_of=="box-float-right" || $type_of=="box-float-left" || $type_of=="box-float-center" )
		$ctt .= '<div style="border: 1px solid #aaa; padding: 10px; text-align:center;  max-width: 250px;';
	
	if($type_of=="box-float-right")
		$ctt .= 'float: right; margin: 0 10px;">';
	
	if($type_of=="box-float-left")
		$ctt .= 'float: left; margin: 0 20px 10px 0">';

	if($type_of=="box-float-center")
		$ctt .= 'margin: 0 auto;">';
	//if($type_of=="box-float-right")
	//	$ctt .= '<div style="border: 1px solid #aaa; float: right; margin: 0 10px; padding: 10px; text-align:center;  max-width: 250px;">';
		


	$ctt .= "<a href=".get_permalink($post_id)." rel='bookmark'>".get_the_post_thumbnail($post_id, 'large', array( 'class' => 'img-responsive' ));

	if(!$hide_title)
	$ctt .= $post_object->post_title;

	$ctt .= "</a>";
	
	if($type_of=="excerpt") {
		$ctt .= substr($post_object->post_content, 0, 96)."...";	
	}
	
	if($type_of=="box-float-right" || $type_of=="box-float-left" || $type_of=="box-float-center" )
		$ctt .= '</div>';

	if(function_exists("revert_database_schema"))
	revert_database_schema();
	return $ctt;
}

?>