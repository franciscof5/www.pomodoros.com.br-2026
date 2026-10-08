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

?>
