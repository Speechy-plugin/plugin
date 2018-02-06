<?php
   /*
   Plugin Name: Speechy
   Plugin URI: https://speechy.io
   Description: Speechy is a plugin that uses the world's best text-to-speech software, Amazon Polly, to automatically create impressive MP3 versions of your blog posts.
   Version: 1.8
   Author: Nicolas Point
   Author URI: https://speechy.io
   License: GPL2
   */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

/* Speechy Callback Handling */ 
function speechy_callback($vars = '') {
	if($vars['pagename'] == 'speechy_callback'){
		$post_id = SpeechyAPi::getPostIdFromRequest();
		update_post_meta( $post_id, 'mp3_ready', 1);
		echo "done";
		exit();
	}
	return $vars;
}
add_filter( 'request', 'speechy_callback' );

/* ** github Updater ** */
require_once( plugin_dir_path( __FILE__ ) . 'github/githubpluginupdater.php' );

//require_once( 'BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new WPFDGitHubPluginUpdater( __FILE__, 'Speechy-plugin', "plugin" );
}

/* Enqueue CSS and JS files */
function speechy_scripts($hook) {
 
	// Top  Casinos List Widget
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . '/js/speechy_script.js' ));
    $my_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . '/css/style.css' ));
     
    // enqueues
    wp_register_script( 'speechy_widget_js', plugins_url( '/js/speechy_script.js', __FILE__ ), array( 'jquery'), null, true );
	wp_enqueue_script( 'speechy_widget_js' );

    wp_register_style( 'speechy_css',    plugins_url( '/css/style.css',    __FILE__ ), false, true );
    wp_enqueue_style ( 'speechy_css' );
	
	// Add the color picker css file       
    wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        //wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	
}
add_action('wp_enqueue_scripts', 'speechy_scripts');

/* Enqueue CSS and JS files BACK-END */
function speechy_scripts_backend() {
	wp_enqueue_script( 'speechy_backend_js', plugin_dir_url( __FILE__ ) . 'js/speechy_script_backend.js', array( 'wp-color-picker' ), false, true );
	
	// create my own version codes
    $my_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/style_backend.css' ));
    // register
    wp_register_style( 'speechy_backend_css',    plugins_url( '/css/style_backend.css',    __FILE__ ), false,  $my_css_ver );
    wp_enqueue_style ( 'speechy_backend_css' );
}
add_action( 'admin_enqueue_scripts', 'speechy_scripts_backend' );

// ** Define user infos and credentials ** 
//define('API_URL', "https://kw3nkaycwd.execute-api.us-east-1.amazonaws.com/prod/create-audio");

// Retrieve plugin settings
$options = get_option( 'speechy_settings' );
$options_player = get_option( 'player_settings' );
// setting page url
$admin_url = admin_url();
$url = $admin_url . "/options-general.php?page=speechy-plugin"; 
define ('SETTING_PAGE_URL', $url);

// Licence settings
$speechy_id_key = $options['speechy_id_key'];
$speechy_secret_key = $options['speechy_secret_key'];

define('ID_KEY', $speechy_id_key); // id_key will be here.
define('SECRET_KEY', $speechy_secret_key); // secret_key will be here.

// Voice setting
$speechy_voice = $options['voice'];
$speechy_voice != "" ? $speechy_voice : $speechy_voice = "Joanna";

define('VOICE', $speechy_voice);

// Player style settings
$speechy_border_color = $options_player['border-color'];
$speechy_bg_color = $options_player['bg-color'];
$speechy_text_color = $options_player['text-color'];
$speechy_player_title = $options_player['speechy_player_title'];

define('PLAYER_TITLE', $speechy_player_title); // id_key will be here.

/* Updating styles from settings */
function styl_func(){
	echo'<style>
	.speechy_mp3 {border: 1px dotted'. $speechy_border_color.' !important;
		background:'. $speechy_bg_color.'!important;
	}

	.speechy_mp3 .player_title, .speechy_mp3 .powered_by, .speechy_mp3 .powered_by a {
		color:'. $speechy_text_color .'!important;
	}
	</style>';
}
add_action('admin_footer','styl_func');
/* END Updating styles from settings */

// Add plugin settings link to Plugins page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=speechy-plugin') ) .'">'. __('Settings', 'speechy'). '</a>';
   return $links;
}


/* ** Speechy meta box (not sure to use the metabox or the shortcode) ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_metabox.php' );

// ** Speechy API **
include_once( plugin_dir_path( __FILE__ ) . '/speechyapi/speechyapi.php' ); 
	
/* ** Create MP3 function ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_createaudio.php' );

/* ** Audio player on post front/end ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_find_mp3.php' );

/* ** Shortcode (To finish)** */
//include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_shortcode.php' );

/* ** Create the back-end page for the subscription plans */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_admin_page.php' );

/* ** Playlist ** */
include_once( plugin_dir_path( __FILE__ ) . '/wpse-playlist-master/wpse-playlist.php' );

// ** SpeechyAPi
$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$resp = $speechyApi->getUsage();

// Plan limits.
define('HOSTINGLIMIT', $resp['data']['mp3Limit']);
define('BANDWIDTHLIMIT', $resp['data']['hitLimit']);
define('MP3UPDATELIMIT', $resp['data']['mp3UpdateLimit']);

/* Mayankk */
require  __DIR__ . '/vendor/persist-admin-notices-dismissal-master/persist-admin-notices-dismissal.php';
add_action( 'admin_init', array( 'PAnD', 'init' ) );
global $pagenow;

if ( $pagenow != 'options-general.php'){
	if($speechy_id_key == "" || $speechy_secret_key == ""){
		add_action( 'admin_notices', 'speechy_key_error' );
		add_action( 'admin_init', array( 'PAnD', 'init' ) );
		function speechy_key_error() {
			if ( ! PAnD::is_admin_notice_active( 'disable-done-notice-forever' ) ) {
			return;
			}
		  ?>
		  <div class="notice notice-error is-dismissible">
			  <p>For speechy plugin to work, a registration and secret key must be created on the plugin <a href="<?php echo SETTING_PAGE_URL; ?>">Setting Page</a></p>
		  </div>
		  <?php
		}
	}elseif($resp['error'] == 1){
		add_action( 'admin_notices', 'speechy_key_errorr' );
		function speechy_key_errorr() {
				if ( ! PAnD::is_admin_notice_active( 'disable-done-notice-forever' ) ) {
			return;
		}
		
	  ?>
	  <div data-dismissible="disable-done-notice-forever" class="notice notice-error is-dismissible">
	  <?php $url = admin_url(); ?>
		  <p>ID key or Secret key mismatch!</a></p>
	  </div>
	  <?php
	}
	}
}