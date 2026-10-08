<?php
/*
Plugin Name: F5 Sites | Login Screen
Plugin URI: https://www.f5sites.com/software/wordpress/f5sites-login-screen/
Description: Simple update your logo /mu-plugins folder and change file f5sites-login-screen.php for customize css.
Author: Francisco Matelli Matulovic
Author URI: www.franciscomat.com
Version: 1.0
License: GPLv3
Tags: logo, wp-login, wpmu
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'login_enqueue_scripts', 'f5_login_logo' );
add_filter( 'login_headerurl', 'f5_login_logo_url' );
add_filter( 'login_headertext', 'f5_login_logo_url_title' );

function f5_login_logo() {
	#wp_dequeue_script("jquery");
	#wp_enqueue_script("jquery");
	echo '<style type="text/css">
		#login h1 a, .login h1 a {
			/*height:inherit !important;*/
			background: url('.site_url().'/wp-content/plugins/f5sites-login-screen/wp-login-logo.png) no-repeat center center ;
			-webkit-background-size: cover;
	        -moz-background-size: cover;
	        -o-background-size: cover;
	        background-size: cover;
			margin-top:-25px !important;
			width:320px;
			height:160px;
			/*
			margin-top:25px !important;
			padding-bottom: 30px;
			position: relative;
			display:block;*/
		}
		body, html, .wp-core-ui .button-primary {
			/*background: #006599 !important;*/
			background: #E6E6E6 !important; /*#222*/
		}
		a {
			color:#666 !important;
		}
		#login {
			background: #E6E6E6; /*#222;*/
			min-height:90%;
			padding-top: 4% !important;
		}
		.login form {
			/*border-radius: 15px;*/
			border-radius: 0px;
			border: 0 !important;
			background: #E6E6E6 !important;
		}
		#f5alert {
			text-align:center;color:#FFF;
			font-weight:600;
			color: #666666;
		}
		.message {
			display: none !important;
		}
		.login .admin-email__actions .button-primary,
		#wp-submit {
			background: #03659C !important;
			border-radius: 0;
			color:#FFF;
			text-shadow:none;
			border:0;
			text-transform:uppercase;
		}
		.login #backtoblog, .login #nav {
			text-align:center;
		}
		.login label {
			color: #222;
			font-weight: bold;
		}
		</style>

	<script type="text/javascript">
	
	(function() {
	    // Load the script
	    var script = document.createElement("SCRIPT");
	    script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
	    script.type = "text/javascript";
	    document.getElementsByTagName("head")[0].appendChild(script);

	    // Poll for jQuery to come into existance
	    var checkReady = function(callback) {
		if (window.jQuery) {
		    callback(jQuery);			
		}
		else {
		    window.setTimeout(function() { checkReady(callback); }, 100);
		}
	    };

	    // Start polling...
	    checkReady(function($) {
		// Use $ here...
		//alert("foi jQuery");
	    $("#login h1 a").prop(\'href\', \'https://www.f5sites.com/'.$_SERVER["HTTP_HOST"].'\');
		$("<p id=f5alert>Você está acessando: <a href=https://'.$_SERVER["HTTP_HOST"].' alt=F5 Sites | '.get_bloginfo("description").'\>'.get_bloginfo("name").'</strong></a></br>'.get_bloginfo("description").'</br>Use sua conta F5 Sites</p>").insertBefore("#loginform");
	    });
	    
	})();

	</script>';
}
/*
site_url()
$("<p id=f5alert>Você está acessando: <a href="http://www.f5sites.com/'.site_url().'" alt="F5 Sites | '.get_bloginfo("description").'"">'.get_bloginfo("name").'</strong></a></br>'.get_bloginfo("description").'</br>Use sua conta F5 Sites</p>").insertBefore("#loginform");
	    });
$("<p id=f5alert>Você está acessando: <a href='.home_url().' alt='.get_bloginfo("description").'>'.get_bloginfo("name").'</strong></a></br>'.get_bloginfo("description").'</br>Use sua conta F5 Sites</p>").insertBefore("#loginform");
	    });
*/
function f5_login_logo_url() {
    return home_url();
}

function f5_login_logo_url_title() {
    #get_bloginfo("description")
    return get_bloginfo("name").get_bloginfo("description");
}
