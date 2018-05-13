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

/* **  Add Speechy Stats to the posts list page ** */
add_filter('manage_posts_columns', 'speechy_add_post_columns', 5);
add_action('manage_posts_custom_column', 'speechy_get_post_column_values', 5, 2);
add_filter( 'manage_edit-post_sortable_columns', 'speechy_sortable_column' );

// Add new columns
function speechy_add_post_columns($defaults){
    // field vs displayed title
    $defaults['speechy'] = __('Speechy Stats', 'speechy');
    return $defaults;
}

// Populate the new columns with values
function speechy_get_post_column_values($column_name, $postID){

    if($column_name === 'speechy'){
		$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);

		$count = $speechyApi->getListenBytesForEveryPost(); 
		$hitCount = $count['data'][$postID]['hitCount'];
		echo $hitCount;

    }
}

// Create column sorteable
function speechy_sortable_column( $columns ) {
    $columns['speechy'] = 'speechy';
 
    return $columns;
}
/* **  END Add Speechy Stats to the posts list page ** */

// Custom RSS Feeds

add_action('init', 'speechyRSS');
function speechyRSS(){
        add_feed('speechy', 'speechyRSSFunc');
}

function speechyRSSFunc(){
        //get_template_part('rss', 'speechy');
		require_once dirname( __FILE__ ) . '/rss-speechy.php';
}