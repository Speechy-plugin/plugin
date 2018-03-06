<?php

/* Enqueue CSS and JS files */
function speechy_scripts($hook) {
 
    // enqueues
    wp_register_script( 'speechy_widget_js', plugins_url( '/js/speechy_script.js', dirname(__FILE__)), array( 'jquery'), null, true );
	wp_enqueue_script( 'speechy_widget_js' );

    wp_register_style( 'speechy_css', plugins_url( '/css/style.css', dirname(__FILE__) ), false, true );
    wp_enqueue_style ( 'speechy_css' );
	
	// Add the color picker css file       
    wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        //wp_enqueue_script( 'custom-script-handle', plugins_url( 'custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	
}
add_action('wp_enqueue_scripts', 'speechy_scripts');

/* Enqueue CSS and JS files BACK-END */
function speechy_scripts_backend() {
	wp_enqueue_script( 'speechy_backend_js', plugins_url( 'js/speechy_script_backend.js', dirname(__FILE__) ), array( 'wp-color-picker' ), false, true );
	
    // register
    wp_register_style( 'speechy_backend_css', plugins_url( '/css/style_backend.css', dirname(__FILE__) ), false );
    wp_enqueue_style ( 'speechy_backend_css' );
}
add_action( 'admin_enqueue_scripts', 'speechy_scripts_backend' );
