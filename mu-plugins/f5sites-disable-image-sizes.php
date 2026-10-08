<?php
/* Plugin Name: F5 Sites | Disable Images Sizes
Plugin Description: Quick disable wordpress images sizes. Just put it on mu-plugins and no more too much images sizes on upload
Plugin URI: https://www.f5sites.com/software/wordpress/f5sites-disable-image-sizes
Plugin Author: Francisco Matelli Matulovic
Author URI: https://www.franciscomat.com
Tags: mu-plugins
*/

#
add_filter( 'intermediate_image_sizes', '__return_empty_array' );

function example_callback( $string ) {
    // (maybe) modify $string.
echo $string;
	$string = "https://www.focalizador.com.br/wp-content";
	die($string);
   return "https://www.focalizador.com.br/wp-content";
}
#add_filter( 'content_url', 'example_callback', 1, 1 );

#define("WP_CONTENT_URL", "https://www.focalizador.com.br/wp-content");

?>
