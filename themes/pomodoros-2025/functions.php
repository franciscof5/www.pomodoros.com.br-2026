<?php
/*
Vamos lá 2025
Lógica mais louca usa a página 404 como central de tudo kkk
*/
//
add_action('wp_enqueue_scripts', 'load_scritps');
add_action('login_form_middle', 'add_lost_password_link' );
add_action('wp_ajax_save_progress', 'save_progress');
add_action('wp_ajax_nopriv_save_progress', 'save_progress');
add_action('wp_ajax_load_session', 'load_session');
add_action('wp_ajax_nopriv_load_session', 'load_session');
add_action('wp_ajax_update_session', 'update_session');
add_action('wp_ajax_nopriv_update_session', 'update_session');
add_action('wp_ajax_save_or_delete_model', 'save_or_delete_model');
add_action('wp_ajax_nopriv_save_or_delete_model', 'save_or_delete_model');
add_action('wp_ajax_update_cycle_list', 'update_cycle_list');
add_action('wp_ajax_nopriv_update_cycle_list', 'update_cycle_list');
add_action('admin_menu', 'my_remove_menu_pages' );
add_action('wp_logout','go_home');
add_action('init', 'create_post_type' );
add_action('init', 'custom_rewrite_basic');
add_filter('style_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('login_redirect', 'admin_default_page');

add_action('init', 'custom_add_rewrite_rules');
add_action('template_redirect', 'custom_template_redirect');

if (!current_user_can('administrator')) {
    add_filter('show_admin_bar', '__return_false');
}

global $pages_open;
$pages_open = array("register", "product", "br", "carrinho", "app", "news", "focus-training");
global $pages_closed;
$pages_closed = array("focus", "calendar", "ranking", "produtividade", "stats", "csv", "metas", "premios", "game", "invite", "help", "product", "tag");

function custom_add_rewrite_rules() {
	global $pages_open, $pages_closed;
	// Páginas principais
	foreach ($pages_closed as $page) {
		add_rewrite_rule("^$page/?$", "index.php?custom_page=$page&template=closed", 'top');
	}

	// Páginas abertas
	foreach ($pages_open as $page) {
		add_rewrite_rule("^$page/?$", "index.php?custom_page=$page&template=open", 'top');
	}
}

function custom_template_redirect() {
	if (get_query_var('custom_page')) {
		$template = get_query_var('template');
	    include get_template_directory() . '/custom-page-'.$template.'.php';
        exit;
    }
}

function custom_query_vars($vars) {
    $vars[] = 'custom_page';
	$vars[] = 'template';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');


function admin_default_page() {
  return '/focus';
}

function google_play_link() {
	?>
	<a href="https://play.google.com/store/apps/details?id=com.f5sites.pomodoros" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/google-play-badge.png" alt="Google Play Badge" class="img-responsive"></a>
	<?php
}

function get_projectimer_project_tags($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $exclude_adm=="";
    if($author_id>0)
    	$exclude_adm=="";
    else {
    	$exclude_adm=", -2";
    	if($author_id==2)//unless it is admin
    		$exclude_adm=="";
    }
    
    	
    $posts = get_posts(array(
    	'post_type' => "projectimer_focus",
        'author' => $author_id.$exclude_adm,
        'posts_per_page' => -1,
        'fields' => 'ids'
        )
    );

    $ts = array();

    //loop over the post and count the tags
    foreach ((array)$posts as $p_id) {
        $tags = wp_get_post_terms( $p_id, $taxonomy);
        foreach ((array)$tags as $tag) {
        	#var_dump(isset($tags[$tag->term_id]));
            if (isset($ts[$tag->term_id])){ //if its already set just increment the count
                $ts[$tag->term_id]['count'] = $ts[$tag->term_id]['count']  + 1;
            }else{ //set the term name start the count
                $ts[$tag->term_id] = array('count' => 1, 'name' => $tag->name, 'slug' => $tag->slug);
            }
        }
    }
    #var_dump($posts);die;
    //so now $ts holds a list of arrays which each hold the name and the count of posts 
    arsort($ts);
    //that author have in that term/tag, so we just need to display it
    $url = get_author_posts_url($author_id);
    #echo '<ul>';
    foreach ($ts as $term_id => $term_args) {
        echo '<a href="/tag/'.$term_args['slug'].'">'.$term_args['name'].'</a>'.' <span class="count">'.$term_args['count'].'</span>'.', ';
    }
    /*foreach ($ts as $term_id => $term_args) {
        echo '<a href="'.add_query_arg('tag',$term_args['slug'],$url).'">'.$term_args['name'].'</a>'.' <span class="count">'.$term_args['count'].'</span>'.', ';
    }*/
    #echo '</ul>';
}

function get_author_post_tags_wpa78489($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $posts = get_posts(array(
    	'post_type' => "projectimer_focus",
        'author' => $author_id,
        'posts_per_page' => -1,
        'fields' => 'ids'
        )
    );

    $ts = array();

    //loop over the post and count the tags
    foreach ((array)$posts as $p_id) {
        $tags = wp_get_post_terms( $p_id, $taxonomy);
        foreach ((array)$tags as $tag) {
            if (isset($tags[$tag->term_id])){ //if its already set just increment the count
                $ts[$tag->term_id]['count'] = $ts[$tag->term_id]['count']  + 1;
            }else{ //set the term name start the count
                $ts[$tag->term_id] = array('count' => 1, 'name' => $tag->name, 'slug' => $tag->slug);
            }
        }
    }

    //so now $ts holds a list of arrays which each hold the name and the count of posts 
    //that author have in that term/tag, so we just need to display it
    $url = get_author_posts_url($author_id);
    #echo '<ul>';
    foreach ($ts as $term_id => $term_args) {
        echo '<span class="count">'.$term_args['count'].'</span> <a href="'.add_query_arg('tag',$term_args['slug'],$url).'">'.$term_args['name'].'</a>, ';
    }
    #echo '</ul>';
}

function user_object_productivity ($user_id) {
	//echo "<script>alert($user_id);</script>";
	$user_id = (empty($user_id)) ? get_current_user_id() : $user_id;
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//variaveis assistentes
	$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata($user_id)->user_registered)));
	$now = time();
	global $wpdb;
	$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

	/*It must be splitted because it uses itself values, and it cant be accessed in real time*/
	$SEMPRE['totalDias'] = floor($datediff/(60*60*24));
	$SEMPRE['diasTrabalhados'] = $wpdb->query('SELECT ID FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND `post_status` in ("publish", "private") GROUP BY DATE (`post_date_gmt`)');
	$SEMPRE['diasFolga'] = $SEMPRE['totalDias'] - $SEMPRE ['diasTrabalhados'];
	$SEMPRE['fatorProdutividade'] = round($SEMPRE['diasTrabalhados']/$SEMPRE['totalDias'], 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT ID FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND post_date_gmt > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date_gmt`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT ID FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 7;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT ID FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'];
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/($SETEDIAS['totalDias']), 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".($SEMANA['totalDias'])." DAY) GROUP BY DATE (`post_date_gmt`)");
	//Its to prevent a very intersting bug, when there are 2 posts with less than 24 hours of difference but are published at 2 differents days, it will result in a 2 posts for 1 day, grouped by date, because there are 2 differente days
	($SEMANA['diasTrabalhados']>$SEMANA['totalDias']) ? $SEMANA['diasTrabalhados'] = $SEMANA['totalDias'] : $SEMANA['diasTrabalhados'];
	$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
	$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

	$new_object_productivity = array(
		"sempre" => $SEMPRE,
		"trintadias" => $TRINTADIAS,
		"mes" => $MES,
		"setedias" => $SETEDIAS,
		"semana" => $SEMANA
	);
	return $new_object_productivity;
}

function user_object_productivity_human_time_diff ($user_id) {
	//echo "<script>alert($user_id);</script>";
	$user_id = (empty($user_id)) ? get_current_user_id() : $user_id;
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//variaveis assistentes
	$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata($user_id)->user_registered)));
	$now = time();
	global $wpdb;
	$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

	/*It must be splitted because it uses itself values, and it cant be accessed in real time*/
	$totalDias = floor($datediff/(60*60*24));
	
	$totalDias_human = human_time_diff( $data_registro_do_usuario, current_time('timestamp') );

	$diasTrabalhados = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND `post_status` in ("publish", "private")  GROUP BY DATE (`post_date_gmt`)');

	$diasTrabalhados_human = human_time_diff( strtotime("+".$diasTrabalhados." days"), current_time('timestamp') );
	
	$diasFolga = $totalDias - $diasTrabalhados;
	$diasFolga_human = human_time_diff( strtotime("+".$diasFolga." days"), current_time('timestamp') );
	
	$SEMPRE['totalDias'] = $totalDias;
	$SEMPRE['totalDias_human'] = $totalDias_human;
	$SEMPRE['diasTrabalhados'] = $diasTrabalhados;
	$SEMPRE['diasFolga'] = $diasFolga;
	$SEMPRE['fatorProdutividade'] = round($diasTrabalhados/$totalDias, 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND post_date_gmt > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date_gmt`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 6;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'] +1;
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/($SETEDIAS['totalDias']+1), 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".($SEMANA['totalDias']-1)." DAY) GROUP BY DATE (`post_date_gmt`)");
	//Its to prevent a very intersting bug, when there are 2 posts with less than 24 hours of difference but are published at 2 differents days, it will result in a 2 posts for 1 day, grouped by date, because there are 2 differente days
	($SEMANA['diasTrabalhados']>$SEMANA['totalDias']) ? $SEMANA['diasTrabalhados'] = $SEMANA['totalDias'] : $SEMANA['diasTrabalhados'];
	$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
	$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

	$new_object_productivity = array(
		"sempre" => $SEMPRE,
		"trintadias" => $TRINTADIAS,
		"mes" => $MES,
		"setedias" => $SETEDIAS,
		"semana" => $SEMANA
	);
	return $new_object_productivity;
}

if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}

function blockusers_from_wp_admin() {
	if ( is_admin() && ! current_user_can( ‘administrator’ ) && ! ( defined( ‘DOING_AJAX’ ) && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

function default_page() {
  return '/focus';
}

function load_scritps() {		
	#wp_enqueue_style('pomodoro-css', get_bloginfo("stylesheet_directory")."/pomodoro/pomodoro.css", __FILE__, time());
	#ERROR CONSOLE wp_enqueue_style('fonts-css', get_bloginfo("stylesheet_directory")."/assets/fonts/stylesheet.css", __FILE__);

	//alertify
	wp_enqueue_script("alertify-js", get_bloginfo("stylesheet_directory")."/assets/alertify.min.js");
	wp_enqueue_style('alertify-css', get_bloginfo("stylesheet_directory")."/assets/alertify.core_and_default_merged.css", __FILE__);
	
	//bootstrap
	// wp_dequeue_script('bootstrap-css');
	// wp_dequeue_script('bootstrap-scripts');
	// wp_dequeue_style('bootstrap-js');
	// wp_dequeue_style('bootstrap-style');
	#JA CARREGADO EM SMART LANG
	// wp_enqueue_script("bootstrap-js", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.js");
	// wp_enqueue_style('bootstrap-css', get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css", __FILE__);
	
	wp_enqueue_style("fontawesome-css", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css");

	
	//
	#wp_register_script("artyom-js", get_bloginfo("stylesheet_directory")."/assets/artyom.window.min.js");
	#wp_enqueue_script("speakW-js", get_bloginfo("stylesheet_directory")."/assets/speakWorker.js");
	
	//fullpage.js for home
	// wp_enqueue_script("fullpage-js", get_bloginfo("stylesheet_directory")."/assets/fullpage.min.js");
	// wp_enqueue_style('fullpage-css', get_bloginfo("stylesheet_directory")."/assets/fullpage.min.css", __FILE__);
	// wp_enqueue_style('fullpage_homepage.css', get_bloginfo("stylesheet_directory")."/assets/fullpage_homepage.css", __FILE__, time()*rand());
	
	#<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css" />
	//inter8
	//Theme language, need to be there
	load_theme_textdomain( 'sis-foca-js', get_template_directory() . '/languages' );

	//THEME CSS FOR IMPROVE SPEED
	wp_enqueue_style('theme-css', get_bloginfo("stylesheet_directory")."/style.css", __FILE__, time()*rand());
	

	
	global $user_prefered_language;
	if(isset($_SESSION["user_prefered_language"])) {
		$user_prefered_language==$_SESSION["user_prefered_language"];
	} else {
		if($user_prefered_language=="" || $user_prefered_language)
			$user_prefered_language="en_US";
	}
	if($user_prefered_language=="US")
		$user_prefered_language="en_US";
	
	$filelang = $user_prefered_language.".js";
	//var_dump($filelang);die;
	//if(qtranxf_getLanguage() == "en")
		//$filelang="en.js";
	   //else if(qtranxf_getLanguage() == "pt")
		//$filelang="pt-br.js";
	//} else {
		//If the function doesnt exists then call the default language
		//$filelang="pt-br.js";
	//}
	$filelang = ($filelang=="" || !isset($filelang)) ? "pt_BR.js" : $filelang;
	$filelang = "pt_BR.js";
	wp_enqueue_script("pomodoros-language", get_bloginfo("stylesheet_directory")."/languages/js/".$filelang, __FILE__, time());
	#var_dump(get_bloginfo("stylesheet_directory")."/languages/".$filelang);die;
	// Register the script
	//wp_register_script( 'some_handle', 'path/to/myscript.js' );
	wp_register_script("pomodoros-js", get_bloginfo("stylesheet_directory")."/pomodoro/pomodoro-functions.js", __FILE__, time());

	wp_localize_script(
        'pomodoros-js',
        'pomodorosData',
        [
            'themeUrl' => get_stylesheet_directory_uri()
        ]
    );

	// Localize the script with new data
	$localized_array = array(
		'php_locale' => $user_prefered_language,
		'is_admin' => current_user_can("administrator") ? true : false,
	);
	
	wp_localize_script( 'pomodoros-js', 'data_from_php', $localized_array );

	// Enqueued script with localized data.
	//wp_enqueue_script( 'pomodoros-js' );
		#echo get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.js";
	wp_register_script("projectimer-pomodoros-shared-parts-js", get_bloginfo("stylesheet_directory")."/pomodoro/projectimer-pomodoros-shared-parts.js", __FILE__);
	#
	#VIA CSS wp_enqueue_style("projectimer-pomodoros-shared-parts-css", get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.css", __FILE__);

	//
	wp_register_script("sound-js", get_bloginfo("stylesheet_directory")."/assets/soundmanager2-nodebug-jsmin.js", __FILE__);

	wp_register_script("rangeslider-js", get_bloginfo("stylesheet_directory")."/assets/rangeslider.min.js", __FILE__);
	
	//nao precisa ja tem setInterval com load_session
	#wp_enqueue_script("heartbeat");
}

function myplugin_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

function show_recent_pomodoros() {
	#<h3><script>document.write(txt_foot_last)</script></h3>
	?>
		<ul>
			<?php 
			$args = array( 'post_type' => 'projectimer_focus', 'posts_per_page' => 80, 'post_status' => 'publish' ); 
			$recent_posts = get_posts( $args );
			foreach( $recent_posts as $recent ) { ?>
				<li>
				<?php echo get_avatar($recent->post_author, 24) ?>
				<a href="<?php echo get_permalink($recent->ID); ?>" title="Look <?php esc_attr($recent->post_title); ?>">
				<?php echo $recent->post_title ?>
				<span class="post_location">
				<span class="post_location_city"><?php echo get_post_meta($recent->ID, "post_location_city", true); ?></span>
				<span class="post_location_region"><?php echo get_post_meta($recent->ID, "post_location_region", true); ?></span>
				<span class="post_location_country"><?php echo get_post_meta($recent->ID, "post_location_country", true); ?></span>		
				</span>
				</a> 
				</li>
			<?php }
			#
			if(function_exists('set_shared_database_schema'))set_shared_database_schema();
			 ?>
		</ul>
	<?php
}

function show_welcome_message($alertify=false) {
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$args = array(
	              'post_type' => 'projectimer_focus',
	              'post_status' => 'draft',
	              'author'   => get_current_user_id(),

	              'posts_per_page' => 1,
	            );
		$recent = get_posts($args);
		/*if( $recent ) {
			$title = ", you most recent task is <i>".get_the_title($recent[0]->ID)."</i>";
		} else{
			$title = ", you did not started a task yet"; //No published posts
		} 
		
		$msg_saudacao = "Hello ".$current_user->display_name." ".$title.", <a href=/focar>go to online app and start focus</a>";*/
		if( $recent ){
		  $title = ", ".__("you most recent task is", "sis-foca-js")." <i>".get_the_title($recent[0]->ID)."</i>";#sua tarefa mais recente é
		}else{
		  $title = ", ".__("you never started a task", "sis-foca-js"); #você ainda não começou nenhuma tarefa //No published posts
		} 
		$msg_saudacao = __("Hello", "sis-foca-js")." ".$current_user->display_name.$title.", <a href=/focar>".__("go to online app and start focus", "sis-foca-js")."</a>";#acessar aplicativo online e focar
	} else {
		$msg_saudacao = __("Dear visitor", "sis-foca-js").", <a href=/register>".__("register for free", "sis-foca-js")."</a> ".__("and start focus right now", "sis-foca-js");
		$msg_saudacao2 = __("If you already have an account", "sis-foca-js").", <a id=testes href=# class=abrir_login>".__("login", "sis-foca-js")."</a>";
	} 
	if($alertify) {
		echo "<script>alertify.log('".$msg_saudacao."');</script>";
		if(isset($msg_saudacao2))
		echo "<script>alertify.log('".$msg_saudacao2."');</script>";	
	} else {
		if(isset($msg_saudacao2))
			echo $msg_saudacao.". ".$msg_saudacao2;
		else
			echo $msg_saudacao;
	}
	
}
####
function get_meta_values( $meta_key,  $post_type = 'post' ) {

    $posts = get_posts(
        array(
            'post_type' => $post_type,
            'meta_key' => $meta_key,
            'posts_per_page' => -1,
            #'author' => '-2', exclude francisco matelli matulovic
        )
    );

    $meta_values = array();
    foreach( $posts as $post ) {
        $meta_values[] = get_post_meta( $post->ID, $meta_key, true );
    }
    return array_count_values($meta_values);
    #return $meta_values;

}

function array_to_rank ($ar, $qtt) { ?>
	<ul>
	<?php 
	arsort($ar);
	$i = 1;
	foreach ($ar as $key => $value) { 
		if($key) {
		?>
		<li>
			<?php echo $i.". ".$key. " : ".$value; ?>
		</li>
	<?php 
	if (++$i == $qtt) break;
	} 
	}?>
	</ul>
<?php }

#get_projectimer_tags_COPY();
function get_projectimer_tags_COPY($excludeTags=NULL) {
	
	global $please_dont_change_wpdb_woo_separated_tables;
	$please_dont_change_wpdb_woo_separated_tables=true;

	$args = array(
		'post_type' => array("projectimer_focus"),
		'author'        =>  get_current_user_id(),
		'post_status' => array("publish", "future", "pending", "draft"),
		'posts_per_page' => -1,

	);
	$all_projectimer_tags = get_posts( $args );
	$please_dont_change_wpdb_woo_separated_tables=false;
	#set_shared_database_schema();
	$terms = array();
	foreach ($all_projectimer_tags as $post) {
		$tags = get_the_terms($post->ID, 'post_tag');
		if($tags) {
			foreach ($tags as $tag) {
				//array_
				//$t = "<option>".$tag->slug."</option>";
				$t = $tag->slug;
				if(!in_array($t, $terms)) {
					if($excludeTags) {
						if(!in_array($t, $excludeTags))
						$terms[] = $t;
					} else {
						$terms[] = $t;
					}

				}
			}
		}
		//$terms[] = $tags;
	}
	if($terms)
		return $terms;
	else
		return "projeto-inicial";
}

#
function add_lost_password_link() {
    return '<a href="/wp-login.php?action=lostpassword">Forgot password (esqueci a senha)</a>';
    #
}

function go_home(){
	wp_redirect( home_url() );
	exit();
}

function my_remove_menu_pages() {
	wp_get_current_user();
	if(!current_user_can('administrator')) {
		remove_menu_page('link-manager.php');
		remove_menu_page('themes.php');
		remove_menu_page('index.php');
		remove_menu_page('tools.php');
		remove_menu_page('profile.php');
		remove_menu_page('upload.php');
		remove_menu_page('post.php');
		remove_menu_page('post-new.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('admin.php');
		remove_menu_page('edit-comments.php');
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'tools.php', 'wp-cumulus.php' );
		
		 remove_meta_box('linktargetdiv', 'link', 'normal');
		  remove_meta_box('linkxfndiv', 'link', 'normal');
		  remove_meta_box('linkadvanceddiv', 'link', 'normal');
		  remove_meta_box('postexcerpt', 'post', 'normal');
		  remove_meta_box('trackbacksdiv', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('postcustom', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('commentsdiv', 'post', 'normal');
		  remove_meta_box('revisionsdiv', 'post', 'normal');
		  remove_meta_box('authordiv', 'post', 'normal');
		  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
		  remove_meta_box('submitdiv', 'post', 'normal');
		  remove_meta_box('avhec_catgroupdiv', 'post', 'normal');
		  remove_meta_box('categorydiv', 'post', 'normal');
	}
}

function checkLogin() {
	if(!get_current_user_id()) {
		header('Content-type: application/json');//CRUCIAL
		echo json_encode("NOTIN");
		die();
	}
}

function save_progress () {
	
	checkLogin();
	global $force_publish_post_not_shared;

	$force_publish_post_not_shared = true;
	if(!$_POST['post_priv'])
		$_POST['post_priv']="publish";

	#if($_POST['post_tags'])
	#	$tagsinput = explode(" ", $_POST['post_tags']);
	$tagsinput = $_POST['post_tags'];
	
	if($_POST["post_acao"]=="publish") {
		$future = wp_get_post_from_current_user("future");
		if($future) {
			$update_status = array(
				'ID' => $future[0]->ID,
				'post_status' => "publish"
			);
			var_dump($update_status);
			echo "publish : ".$forced_update_seconds_down = wp_update_post($update_status);
			die;
		} else {
			echo "já publicado";
			die;
		}
	}
	if($_POST["post_acao"]=="future") {
		$data_post = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +25 minute"));
		#$data_post_gmt = current_time("mysql", true);
		$data_post_gmt = $data_post;
		// echo "data_post:".$data_post.", data_post_gmt:".$data_post_gmt;die;
		// echo "ok";
		// die;
		
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => $_POST['post_priv'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => $current_user->ID,
			'tags_input' => ($_POST['post_tags']),
			'post_date' => $data_post,
			'post_date_gmt' => $data_post_gmt
			//'post_category' => array(0)
		);

		$save_progress = wp_insert_post( $my_post );
		echo "save_progress: ".$save_progress;
		if($save_progress) {
			if($save_progress) {
				update_post_meta( $save_progress, 'post_location_city', $_POST['post_local_city'] );
				update_post_meta( $save_progress, 'post_location_region', $_POST['post_local_region'] );
				update_post_meta( $save_progress, 'post_location_country', $_POST['post_local_country'] );
			}
			if(function_exists("cp_module_notify_displayNoticesFor"))
			cp_module_notify_displayNoticesFor(cp_currentUser());

			
			//$id = get_current_postid_for_user(get_current_user_id());
			$id = $save_progress;
			$current_user = get_currentuserinfo();
			$namefull = $current_user->user_firstname." ".$current_user->user_lastname;
			$user_id = $current_user->ID;

			$act_args = array(
				'user_id' => $user_id,
				'item_id' => $id,
				'component' => 'projectimer',
				'type' => 'projectimer_start',
			);
			//
			if($_POST["post_priv"]=="private")
				$act_args['hide_sitewide'] = true;
			//
			$act_args['action'] = "<p><a href='/colegas/".$current_user->user_login."'><span class=activity_title>".$namefull."</span></a> completou <a href='".get_permalink($save_progress)."'><span class=hidden>$id</span>".$_POST['post_titulo']." (25 min)</a></p>";
		
			$ac = bp_activity_add( $act_args );
			//
			echo "ATIVI:".$ac;
		} else {
			//echo " ERROR NOT PUBLISHED"; #NOT RESPONSE FOR ERROR
		}
	}
	if($_POST["post_acao"]=="interrupt") {
		$future = wp_get_post_from_current_user("future");
		if($future) {
			echo wp_delete_post($future[0]->ID);
			die;
		} else {
			echo "já interrompido";
			die;
		}
	}
	die(); 
}

function woo_custom_order_button_text() {
    #return __( 'Realizar Doação', 'woocommerce' ); 
    return __( 'Realizar Pagamento', 'woocommerce' ); 
}

function wp_get_post_from_current_user($status) {
	$args = array(
		'post_type'      => 'projectimer_focus',
		'post_status'    => $status,
		'posts_per_page' => 1,
		'author'	 => get_current_user_id(),
	);
	return get_posts($args);
}

function load_session () {
	checkLogin();
	//checa se já existe um rascunho, caso não cria o primeiro
	
	$scheduled = wp_get_post_from_current_user("future");
	$draft = wp_get_post_from_current_user("draft");
	$post = false;
	if ($draft) {
		$post = $draft;
	}
	if($scheduled) {
		$post = $scheduled;
	} 	
	if($post) {
		$agora = current_time("mysql");
		$postdate = $post[0]->post_date;
		$postdate_strtotime  = strtotime($postdate);
		$agora_strtotime = strtotime($agora);		
		$secondsRemainingFromPHP = ($postdate_strtotime - $agora_strtotime);
		//
		$tags = wp_get_post_tags($post[0]->ID);
		$tags_list = array();
		foreach ($tags as $t) {
			$tags_list[]=$t->name;
		}
		$forced_update_seconds_down=false;
		if($secondsRemainingFromPHP<0) {
			//missed schedule? tem que publicar
			if($post[0]->post_status=="future") {
				$update_status = array(
					'ID' => $post[0]->ID,
					'post_status' => "published"
				);
				$forced_update_seconds_down = wp_update_post($update_status);
			}
		}
		$postReturned['post_title'] = $post[0]->post_title;
		$postReturned['post_tags'] = $tags_list;
		$postReturned['post_category'] = $post[0]->post_category;
		$postReturned['post_content'] = $post[0]->post_content;
		$postReturned['ID'] = $post[0]->ID;
		$postReturned['post_status'] = $post[0]->post_status;
		$postReturned['tags_total'] = get_projectimer_tags_COPY();
		$postReturned['agora'] = $agora;
		$postReturned['post_date'] = $postdate;
		$postReturned['agora_strtotime'] = $agora_strtotime;
		$postReturned['postdate_strtotime'] = $postdate_strtotime;	
		$postReturned['secondsRemainingFromPHP'] = $secondsRemainingFromPHP;
		$postReturned['forced_update_seconds_down'] = $forced_update_seconds_down;
	} else {
		$argsnew = array(
				'post_type' => 'projectimer_focus',
				'post_status' => 'draft',
				'author'   => get_current_user_id(),
				'post_title' => 'Testar Pomodoros',
				//'post_tags' => 'projeto-inicial',
				'post_content' => 'Bem vindo ao Pomodoros, descreva aqui o que precisa fazer para terminar a tarefa, use este campo como anotações',
			);
		$ok = wp_insert_post($argsnew);
		if($ok) {
			wp_set_post_tags( $ok, 'projeto-inicial' );
			$postReturned['post_title'] = $argsnew['post_title'];
			$postReturned['post_tags'] = array('projeto-inicial');
			$postReturned['post_content'] = $argsnew['post_content'];
			$postReturned['ID'] = $f;
			$postReturned['post_date'] = "now";
			$postReturned['post_status'] = $argsnew['post_status'];
			$postReturned['secondsRemainingFromPHP'] = 0;
			$postReturned['agora'] = $agora;
			$postReturned['agora_gmt'] = $agora_gmt;
			$postReturned['tags_total'] = get_projectimer_tags_COPY();
		}
	}
	
	$vol = get_user_meta(get_current_user_id(), "rangeVolume", true);
	if($vol<0 || $vol>100 || $vol=="")
		$vol=100;
	$postReturned['range_volume'] = $vol;
	//

	$soundfx_enabled = get_user_meta(get_current_user_id(), "soundfx_enabled", true);
	if($soundfx_enabled=="")
		$soundfx_enabled=true;
	$postReturned['soundfx_enabled'] = $soundfx_enabled;

	$voice_enabled = get_user_meta(get_current_user_id(), "voice_enabled", true);
	if($voice_enabled=="")
		$voice_enabled=true;
	$postReturned['voice_enabled'] = $voice_enabled;

	echo json_encode($postReturned);
	die();
}

function update_session () {
	checkLogin();
	$scheduled = wp_get_post_from_current_user("future");
	$draft = wp_get_post_from_current_user("draft");
	if ($draft) {
		$my_post = array(
			'ID'	=> $draft[0]->ID,
			// 'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'tags_input' => $_POST['post_tags'],
			'edit_date' => true,
		);
		$update_draft_ok = false;
		$update_draft_ok = wp_update_post( $my_post );
	}
	if($scheduled) {
		$my_post = array(
			'ID'	=> $scheduled[0]->ID,
			// 'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'tags_input' => $_POST['post_tags'],
			// 'edit_date' => true,
		);
		$update_scheduled_ok = false;
		$update_scheduled_ok = wp_update_post( $my_post );
	} 	
	
	//
	$vok = update_user_meta(get_current_user_id(), "rangeVolume", $_POST['range_volume']);
	$soundfx_enabled_ok = update_user_meta(get_current_user_id(), "soundfx_enabled", $_POST['soundfx_enabled']);
	$voice_enabled_ok = update_user_meta(get_current_user_id(), "voice_enabled", $_POST['voice_enabled']);
	//
	$postReturned["update_draft_ok"] = $update_draft_ok;
	$postReturned["update_scheduled_ok"] = $update_scheduled_ok;
	$postReturned['volume_ok'] = $vok;
	$postReturned['soundfx_enabled_ok'] = $soundfx_enabled_ok;
	$postReturned['voice_enabled_ok'] = $voice_enabled_ok;

	header('Content-type: application/json');//CRUCIAL
	echo json_encode($postReturned);
	die;
}

function save_or_delete_model () {
	checkLogin();
	//header('Content-type: application/json');//CRUCIAL
	
	if(isset($_POST['post_para_deletar'])) {
		//echo "deletando: ".$_POST['post_para_deletar'];
		$del = wp_trash_post($_POST['post_para_deletar']);
		if($del)
		echo true;
		die();
	} else {
		var_dump($_POST);
		///$tagsinput = explode(" ", $_POST['post_tags']);	
		//var_dump($tagsinput);
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => "pending",
			'post_author' => $current_user->ID,
			'tags_input' => ($_POST['post_tags'])
		);
		var_dump($my_post);
		#var_dump(($_POST['post_tags']));
		$idofpost = wp_insert_post( $my_post );
		echo $idofpost;
		#die();
	}
}

function update_cycle_list() {
	checkLogin();
	//
	if(isset($_POST["clean"])) {
		$ok = update_user_meta(get_current_user_id(), "cycle_list", "");
		echo $ok;
	} else {
		if(isset($_POST['list'])) {
			$ok = update_user_meta(get_current_user_id(), "cycle_list", $_POST["list"]);
			echo $ok;
		} else {
			echo false;
		}	
	}
	
}
function create_post_type() {
	createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN();
}

function createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN() {
	if ( ! post_type_exists( "projectimer_focus" ) ) {
		$labelFocus = array(
			'name'  => __( 'Focus',' projectimer-plugin' ), 
			'singular_name' => __( 'Focus',    ' projectimer-plugin' ),
			'add_new'    => __( 'Add New', ' projectimer-plugin' ),
			'add_new_item'  => __( 'Add New Focus',    ' projectimer-plugin' ),
			'edit'  => __( 'Edit', ' projectimer-plugin' ),
			'edit_item'  => __( 'Edit Focus', ' projectimer-plugin' ),
			'new_item'   => __( 'New Focus', ' projectimer-plugin' ),
			'view'  => __( 'View Focus', ' projectimer-plugin' ),
			'view_item'  => __( 'View Focus', ' projectimer-plugin' ),
			'search_items'  => __( 'Search Focus', ' projectimer-plugin' ),
			'not_found'  => __( 'No Focus found', ' projectimer-plugin' ),
			'not_found_in_trash' => __( 'No Focus found in Trash', ' projectimer-plugin' ),
			'parent'     => __( 'Parent Focus',     ' projectimer-plugin' ),
		);
		
		$postTypeFocusParams = array(
			'labels'  => $labelFocus,
			'singular_label'  => __( 'Focus', ' projectimer-plugin' ),
			'public'  => true,
			//'show_ui' => true,
			'menu_icon' => get_bloginfo('stylesheet_directory').'/images/projectimer_post_type_icon.png',
			'description' => 'Post type for Projectimer Plugin',
			'menu_position'   => 20,
			'can_export' => true,
			'hierarchical'    => false,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'done'),//, 'with_front' => false ),
			'has_archive' => true,
			'query_var'  => true,
			'show_in_rest' => true,
			'taxonomies' => array('post_tag', 'category'),
			'supports'   => array( 'title', 'content', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' )
		);

		#var_dump($postTypeFocusParams);die;
		register_post_type("projectimer_focus", $postTypeFocusParams);
		
		#register_taxonomy_for_object_type("post_tags", "projectimer_focus");
		#register_taxonomy_for_object_type("categories", "projectimer_focus");
		#register_taxonomy_for_object_type('category', 'projectimer_focus');
		#register_taxonomy_for_object_type('post_tag', 'projectimer_focus');
	}
}

/*function get_user_subscription($user_id, $domain) {
	$user_id = (!isset($user_id)) ? get_current_user_id() : $user_id;
	$sql = "SELECT * FROM f5sites_posts WHERE post_type='subscription' AND post_author=".$user_id;
	global $wpdb;
	 echo "<pre>"; print_r($wpdb); echo "</pre>";
	
	$results = $wpdb->get_results( $sql, OBJECT );
	die;
				
}*/
//get_user_subscription(2, $_SERVER['REQUEST_URI']);


function modified_views_so_15799171( $views ) {
	//não usa mais 2024
    $views['all'] = str_replace( 'All ', 'Tutti ', $views['all'] );

    if( isset( $views['publish'] ) )
        $views['publish'] = str_replace( 'Published ', 'Online ', $views['publish'] );

    if( isset( $views['future'] ) )
        $views['future'] = str_replace( 'Scheduled ', 'Future ', $views['future'] );

    if( isset( $views['draft'] ) )
        $views['draft'] = str_replace( 'Drafts ', 'Drafts ', $views['draft'] );

    if( isset( $views['pending'] ) )
        $views['trash'] = str_replace( 'Pending ', 'Models ', $views['trash'] );

    if( isset( $views['trash'] ) )
        $views['trash'] = str_replace( 'Trash ', 'Done ', $views['trash'] );
    #PT
    if( isset( $views['draft'] ) )
        $views['draft'] = str_replace( 'Rascunhos ', 'Clipboard ', $views['draft'] );

    if( isset( $views['pending'] ) )
        $views['pending'] = str_replace( 'Pendentes ', 'Modelos ', $views['pending'] );

    return $views;
}

function custom_rewrite_basic() {
  add_rewrite_rule('^shop/?$', 'index.php?page_id=3487', 'top');
}


function wpse187831_redir_loggedin() {
    global $action;

    if ('logout' === $action || !is_user_logged_in()) {
        return;
    }

    wp_redirect(apply_filters(
        'wpse187831_loggedin_redirect',
        current_user_can('administrator') ? admin_url() : home_url(),
        wp_get_current_user()
    ), 302);
    exit;
}

/*
function show_lang_options($hide_title=false, $current_location="") {
	global $user_prefered_language;
	if($current_location=="") {
		if($user_prefered_language!="")
			$current_location = $user_prefered_language;
		else
			$current_location = "notset";
	} ?>

		<?php 
		if(!$hide_title) { ?>
			<strong>Change Language:</strong>
		<?php }
		/*if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Change Language</h3>
		<?php } else { ?>
			<strong>Change Language:</strong>
		<?php } * / ?>

	<?php
	#var_dump($user_prefered_language);
	#var_dump($current_location);die;
	switch ($current_location) {
		case 'notset' :
		case 'en' :
		case 'en_US' :
			generate_flag_links_except("en");
			break;
		
		case 'pt' :
		case 'pt_BR' :
			generate_flag_links_except("pt");
			break;

		case 'fr' :
		case 'fr_FR' :
			generate_flag_links_except("fr");
			break;

		case 'es' :
		case 'es_ES' :
			generate_flag_links_except("es");
			break;

		case 'zh' :
		case 'zh_CN' :
			generate_flag_links_except("zh");
			break;

		default:
			generate_flag_links_except("en");
			break;
	}
	/*
	if($current_location!="en" && $current_location!="en_US") { ?>
		<?php if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Change Language</h3>
		<?php } else { ?>
			<strong>Change Language:</strong>
		<?php } ?>
		<a href="<?php echo get_bloginfo('url'); ?>/?lang=en_US"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/us.png" alt="Language Flag"> English</a>
	<?php } else { ?>
		<?php if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Mudar Idioma</h3>
		<?php } else { ?>
			<strong>Mudar Idioma:</strong>
		<?php } ?>
		<a href="<?php echo get_bloginfo('url'); ?>/?lang=pt_BR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/br.png" alt="Bandeira de Idioma"> Português</a>
	<?php }* /
}

/*
function generate_flag_links_except($except) { ?>
	<?php 
	$base_link = $_SERVER['REQUEST_URI']; 
	$base_link = preg_replace('/\?.*    /', '', $base_link);
	?>
	<?php if($except!="en" && $except!="en_US") { ?>
		<a href="<?php echo $base_link; ?>?lang=en_US"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/us.png" alt="Language Flag"> English</a>
	<?php } ?>
	<?php if($except!="fr" && $except!="fr_FR") { ?>
		<a href="<?php echo $base_link; ?>?lang=fr_FR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/fr.png" alt="Drapeau de langue"> Français</a>
	<?php } ?>
	<?php if($except!="pt" && $except!="pt_BR") { ?>
		<a href="<?php echo $base_link; ?>?lang=pt_BR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/br.png" alt="Bandeira de Idioma"> Português</a>
	<?php } ?>
	<?php if($except!="es" && $except!="es_ES") { ?>
		<a href="<?php echo $base_link; ?>?lang=es_ES"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/es.png" alt="Bandera de Idioma"> Spañol</a>
	<?php } ?>
	<?php if($except!="zh" && $except!="zh_CN") { ?>
		<a href="<?php echo $base_link; ?>?lang=zh_CN"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/cn.png" alt="语言标志"> 中文</a>
	<?php } ?>
<?php }

function check_language_user_and_content($tags) {
	global $user_prefered_language;
	global $user_prefered_language_prefix;
	$user_prefered_language_prefix = substr($user_prefered_language,0,2);
	if($tags) {
		foreach ($tags as $tag) {
			# code...
			if(substr($tag->slug, 0, 5)=="lang-") {
				$content_lang = substr($tag->slug, 5, 7);
				if($user_prefered_language_prefix!=$content_lang) { ?>
					<div class="alert alert-warning">
					<strong><?php _e("Warning!", "sis-foca-js"); ?></strong> 
					<?php _e("These content is not avaiable in your language. Original content language is: ", "sis-foca-js");
					echo "<strong>".$content_lang."</strong>";
					echo "<br>";
					echo "<a href='/'>".__("Go to blog homepage", "sis-foca-js")."</a>";
					#echo "These content is not avaiable in your language";	] ?>
					</div>
				<?php }
			}
		}
	}
	#var_dump($user_prefered_language_prefix);die;
}

function smart_set_user_language() {
	global $user_prefered_language;
	
	if(class_exists("WC_Geolocation")) {
		$wclocation = WC_Geolocation::geolocate_ip();
		$user_location_georefered = $wclocation['country'];

	}
	if(!$user_location_georefered) {
		if(function_exists("locale_accept_from_http"))
			$user_location_georefered = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		else
			$user_location_georefered = "en_US";
	}
	if($user_location_georefered=="BR")
		$user_location_georefered="pt_BR";

	#$user_prefered_language = $user_location_georefered;
	#var_dump($user_location_georefered);
	

	#$user_lang_pref = get_user_meta(get_current_user_id(), "pomodoros_lang", true);
	#if($user_lang_pref=="")
	#	$user_lang_pref="en_US";
	/*if($user_lang_pref) {
		if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "pt_BR" );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "en_US" );
		}
	} else {* /
	$user_prefered_language = $user_location_georefered;
	session_start();
	if(!isset($_SESSION["user_prefered_language"]))
	$_SESSION["user_prefered_language"]=$user_prefered_language;
	
	if($_GET && isset($_GET["lang"])) {
		/*if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {	
			$user_lang_on_url="pt_BR";
			#update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_on_url );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			$user_lang_on_url="en_US";
			#update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_on_url );
		}* /

		#if($user_lang_on_url!=$user_prefered_language) {
			#$user_prefered_language=$user_lang_on_url;
			$user_prefered_language=$_GET["lang"];
			$_SESSION["user_prefered_language"]=$user_prefered_language;
		#}
	}

	if(isset($_SESSION["user_prefered_language"])) {
		$user_prefered_language=$_SESSION["user_prefered_language"];
	} else {
		$_SESSION["user_prefered_language"]=$user_prefered_language;
	}
	if($user_prefered_language=="")
		$user_prefered_language=="en_US";
	#var_dump($_SESSION["user_prefered_language"]);
	#var_dump($user_prefered_language);
	switch_to_locale($user_prefered_language);
	define_title_apendix($user_prefered_language);
	#var_dump($user_prefered_language);die;
	return $user_prefered_language;
}

function define_title_apendix($lang) {
	global $title_apendix;
	switch ($lang) {
		case 'notset' :
		case 'en' :
		case 'en_US' :
			$title_apendix = "USA/UK";
			break;
		case 'pt' :
		case 'pt_BR' :
			$title_apendix = "Brasil";
			break;

		case 'fr' :
		case 'fr_FR' :
			$title_apendix = "France";
			break;

		case 'es' :
		case 'es_ES' :
			$title_apendix = "Espanã/AL";
			break;

		case 'zh' :
		case 'zh_CN' :
			$title_apendix = "中国";
			break;
		default:
			$title_apendix = "Global";
			break;
	}
}

function show_recent_posts_georefer() {
	#<h3><script>document.write(txt_foot_blog)</script></h3>
	?>
	<div class="widget widget_recent_entries">
		<ul>
		
			<?php 
			if(function_exists('set_shared_database_schema'))set_shared_database_schema();
			
			$idObj = get_category_by_slug("www.pomodoros.com.br"); 

			global $user_prefered_language;
			$user_prefered_language_prefix = substr($user_prefered_language, 0,2);
			
			$arro = array(
				'cat' => $idObj->term_id,
				'posts_per_page' => 6,
				'tag' => "lang-".$user_prefered_language_prefix,
			);
			
			/*if($user_prefered_language=="en" || $user_prefered_language=="en_US")
				#$args[] = array("tag"=>"english");
				$arro["tag"] = "english";
			else 
				$arro["tag__not_in"] = 579;* /
			wp_reset_query();
			$catquery = new WP_Query( $arro );
			while($catquery->have_posts()) : $catquery->the_post();
			?>
			
			<li>
				<?php the_post_thumbnail(array(50,50)); ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
			</li>
			
			<?php endwhile;	?>
		</ul>
	</div>
	<?php
}

/*function show_most_recent_taskDISABLED() {
	#echo '<h3 class="widget-title">Tarefa recente</h3>';
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user(); 
		$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),

		              'posts_per_page' => 1,
		            );
		$recent = get_posts($args);
		if( $recent ){
		  $title = ", ".__("you most recent task is", "sis-foca-js")." <i>".get_the_title($recent[0]->ID)."</i>";#sua tarefa mais recente é
		}else{
		  $title = ", ".__("you never started a task", "sis-foca-js"); #você ainda não começou nenhuma tarefa //No published posts
		} 
		$msg_saudacao = __("Hello", "buddypress")." ".$current_user->display_name.$title.", <a href=/focar>".__("go to online app and start focus", "sis-foca-js")."</a>";#acessar aplicativo online e focar
	} else {
		#$msg_saudacao = "Caro visitante, <a href=/register>crie sua conta GRÁTIS</a> para acessar o aplicativo online";
		#$msg_saudacao2 = "Se já possui um usuário, <a id=testes href=# class=abrir_login>acesse sua conta</a>";
		echo show_welcome_message();
	} 
			
	echo $msg_saudacao;
	if(isset($msg_saudacao2))
	echo $msg_saudacao2;
	#die();
}*/
