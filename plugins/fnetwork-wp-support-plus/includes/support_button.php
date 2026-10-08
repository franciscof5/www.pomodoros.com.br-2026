<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlusButton{
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'loadScripts') );
		add_action( 'wp_footer', array( $this, 'showButton') );
	}
	
	function loadScripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('wpce_support_button', WCE_PLUGIN_URL . 'asset/css/support_button.css');
		wp_enqueue_script( 'wpce_support_button', WCE_PLUGIN_URL . 'asset/js/support_button.js');
		wp_enqueue_script('wpce_fancybox', WCE_PLUGIN_URL . 'asset/lib/fancybox/jquery.fancybox.pack.js');
		wp_enqueue_style('wpce_fancybox_css', WCE_PLUGIN_URL . "asset/lib/fancybox/jquery.fancybox.css");
		
		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL
		);
		wp_localize_script( 'wpce_support_button', 'display_button_data', $localize_script_data );
	}
	
	function showButton(){
		$generalSettings=get_option( 'wpsp_general_settings' );
		if ($generalSettings['enable_support_button']){
			$flag=true;
			if ( ! is_user_logged_in() && ! $generalSettings['enable_guest_ticket'] ) $flag=false;
			if ($flag){
				$support_permalink=get_permalink($generalSettings['post_id']);
				$imageURL='';
				$style="";
				switch ($generalSettings['support_button_position']){
					case 'top_left':   $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-left.png';
										$style="top: 35px;left: 0px;";
										$panel_style="left: -300px;top: 39px;";
										$animate_direction='left';
										break;
					case 'top_right':  $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-right.png';
										$style="top: 35px;right: 0px;";
										$panel_style="right: -300px;top: 39px;";
										$animate_direction='right';
										break;
					case 'bottom_left': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-left.png';
										$style="bottom: 35px;left: 0px;";
										$panel_style="left: -300px;bottom: 10px;";
										$animate_direction='left';
										break;
					case 'bottom_right': $imageURL= WCE_PLUGIN_URL.'asset/images/support-button-right.png';
										$style="bottom: 35px;right: 0px;";
										$panel_style="right: -300px;bottom: 10px;";
										$animate_direction='right';
										break;
				}
				?>
				<img id="wpsp_support_btn" alt="support" src="<?php echo $imageURL;?>" style="<?php echo $style;?>" />
				<div id="wpsp_support_front_panel" style="<?php echo $panel_style;?>">
					<?php include_once( WCE_PLUGIN_DIR.'includes/support_panel.php' );?>
				</div>
				
				<div style="display:none;">
				    <div id="support_skype_chat_body">
				        <div id="supportChatContainer"></div>
				        <div class="wait">
				        	<img alt="Please Wait" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>">
				        </div>
				    </div>
				</div>
				
				<div style="display:none;">
				    <div id="support_skype_call_body">
				        <div id="supportCallContainer"></div>
				        <div class="wait">
				        	<img alt="Please Wait" src="<?php echo WCE_PLUGIN_URL.'asset/images/ajax-loader@2x.gif';?>">
				        </div>
				    </div>
				</div>
				
				<script type="text/javascript">
					jQuery(document).ready(function(){
						<?php if($generalSettings['enable_slider_menu']){?>
							setTimeout(function(){open_support_panel();}, 1000);
							setTimeout(function(){close_support_panel();}, 2000);
							jQuery('#wpsp_support_btn').click(function(){
								open_support_panel();
							});
							jQuery('#support_panel_close').click(function(){
								close_support_panel();
							});
							jQuery('#support_page_redirect').click(function(){
								window.location.href="<?php echo $support_permalink;?>";
							});
						<?php }else {?>
							jQuery('#wpsp_support_btn').click(function(){
								window.location.href="<?php echo $support_permalink;?>";
							});
						<?php }?>
					});
					function open_support_panel(){
						jQuery('#wpsp_support_front_panel').animate({ "<?php echo $animate_direction;?>": "+=300px" }, "slow" );
					}
					function close_support_panel(){
						jQuery('#wpsp_support_front_panel').animate({ "<?php echo $animate_direction;?>": "-=300px" }, "slow" );
					}
				</script>
				<?php
			}
		}
	}
}

$GLOBALS['WPSupportPlusButton'] =new WPSupportPlusButton();
?>