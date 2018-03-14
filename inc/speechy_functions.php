<?php

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

/* Upload an image to the customizer */
function speechy_theme_customizer( $wp_customize ) {

	// create a new section 
   $wp_customize->add_section( 'speechy' , array(
		'title'       => __( 'Speechy', 'speechy' ),
		'priority'    => 30,
		'description' => 'Upload an image to add to the MP3 player. For better results, the image must be square and minimum 100px wide',
	) );
	
	// Register new setting
	$wp_customize->add_setting( 'speechy_logo' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'speechy_logo', array(
		'label'    => __( 'MP3 player image', 'speechy' ),
		'section'  => 'speechy',
		'settings' => 'speechy_logo',
	) ) );
	
	// Speechy Player background Image
	$wp_customize->add_setting( 'speechy_bg' );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'speechy_bg', array(
		'label'    => __( 'Player background Image: (size: 400px x 100px)', 'speechy' ),
		'section'  => 'speechy',
		'settings' => 'speechy_bg',
	) ) );
	
}
add_action( 'customize_register', 'speechy_theme_customizer' );
/* END Upload an image to the customizer */

// Add plugin settings link to Plugins page
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'my_plugin_action_links' );

function my_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=speechy-plugin') ) .'">'. __('Settings', 'speechy'). '</a>';
   return $links;
}

// Deactivate default MediaElement.js styles by WordPress
/*
function remove_mediaelement_styles() {
        wp_dequeue_style('wp-mediaelement');
        wp_deregister_style('wp-mediaelement');
}
add_action( 'wp_print_styles', 'remove_mediaelement_styles' );

// Add media button (see also in js file)

add_action ( 'admin_enqueue_scripts', function () {
		if (is_admin ())
			wp_enqueue_media ();
	} 
);
*/

// Custom RSS Feeds

add_action('init', 'speechyRSS');
function speechyRSS(){
        add_feed('speechy', 'speechyRSSFunc');
}

function speechyRSSFunc(){
        //get_template_part('rss', 'speechy');
		require_once dirname( __FILE__ ) . '/rss-speechy.php';
}