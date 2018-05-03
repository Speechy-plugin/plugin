<?php
   /*
   Plugin Name: Speechy
   Plugin URI: https://speechy.io
   Description: Speechy is a premium WordPress Plugin that uses the world's best text-to-speech software, Amazon Polly, to automatically create impressive MP3 versions of your blog posts. No need to set up an AWS account. We convert, host and deliver your MP3 files the simple way!
   Version: 2.2.6
   Author: Nicolas Point
   Author URI: https://speechy.io
   License: GPL2
   */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

// Enqueue scripts
include_once( plugin_dir_path( __FILE__ ) . '/inc/speechy_enqueue_scripts.php');

// ** Speechy API **
include_once( plugin_dir_path( __FILE__ ) . '/speechyapi/speechyapi.php' ); 

// Speechy plugin settings
include_once( plugin_dir_path( __FILE__ ) . '/inc/speechy_plugin_settings.php');

// Speechy Functions
include_once( plugin_dir_path( __FILE__ ) . '/inc/speechy_functions.php');

// Player styles
include_once( plugin_dir_path( __FILE__ ) . '/inc/player_styles.php');

/* ** Speechy meta box (not sure to use the metabox or the shortcode) ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_metabox.php' );

/* ** Create MP3 function ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_createaudio.php' );

/* ** Audio player on post front/end ** */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_find_mp3.php' );

/* ** Create the back-end page for the subscription plans */
include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_admin_page.php' );

/* ** Playlist ** */
include_once( plugin_dir_path( __FILE__ ) . '/wpse-playlist-master/wpse-playlist.php' );

/* ** ** */
//include_once( plugin_dir_path( __FILE__ ) . '/ajax/increment_played.php' );


/* ** Shortcode (To finish)** */
//include_once( plugin_dir_path( __FILE__ ) . '/files/speechy_shortcode.php' );

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

/* ** github Updater ** */
require_once( plugin_dir_path( __FILE__ ) . 'github/githubpluginupdater.php' );

//require_once( 'BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new WPFDGitHubPluginUpdater( __FILE__, 'Speechy-plugin', "plugin" );
}


add_action ( 'admin_enqueue_scripts', function () {        if (is_admin ())            wp_enqueue_media ();    } );


