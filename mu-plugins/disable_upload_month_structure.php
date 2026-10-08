<?php
add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_zero');

add_filter('wp_handle_upload_prefilter', 'wpse47415_pre_upload');

function wpse47415_pre_upload($file){
    add_filter('upload_dir', 'wpse47415_custom_upload_dir');
    return $file;
}

function wpse47415_post_upload($fileinfo){
    #buga fica de lembrança
    remove_filter('upload_dir', 'wpse47415_custom_upload_dir');
    return $fileinfo;
}

function wpse47415_custom_upload_dir($path){
    $siteurl = (preg_replace('#^https?://#', '', get_site_url()) );
    $path["path"]= "/var/www/wp-content/uploads/$siteurl";
    $path["basedir"]= "/var/www/wp-content/uploads/$siteurl";
    return $path;
}
