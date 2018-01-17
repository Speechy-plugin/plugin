<?php
//global $pagenow;
//options-general.php

/*
 * Add the admin menu inside the Options page
 */
add_action( 'admin_menu', 'speechy_menu' );

function speechy_menu() {
	add_options_page( 'Speechy settings', 'Speechy', 'manage_options', 'speechy-plugin', 'speechy_options' );
}

/*
 * Register the settings
 */
 
add_action('admin_init', 'speechy_register_settings');
function speechy_register_settings(){
    //this will save the option in the wp_options table as 'speechy_settings'
    register_setting('speechy_settings', 'speechy_settings', 'speechy_settings_validate');
}

add_action('admin_init', 'player_register_settings');
function player_register_settings(){
    //this will save the option in the wp_options table as 'speechy_settings'
	register_setting('player_settings', 'player_settings', 'player_settings_validate');
}

function speechy_settings_validate($args){
    //make sure you return the args
    return $args;
}

function player_settings_validate($args){
    //make sure you return the args
    return $args;
}

//The markup for your plugin settings page
function speechy_options(){ ?>
    <div class="wrap speechy">
	
    <h1><?php echo __("Speechy Settings" , "speechy"); ?></h1>
	
	<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'speechy_settings';
	?>
	
	<h2 class="nav-tab-wrapper"> 
		<a href="?page=speechy-plugin&tab=speechy_settings" class="nav-tab <?php echo $active_tab == 'speechy_settings' ? 'nav-tab-active' : ''; ?>">Speechy Settings</a>
		
		<?php if(ID_KEY != ''){ ?>
			<a href="?page=speechy-plugin&tab=player_settings" class="nav-tab <?php echo $active_tab == 'player_settings' ? 'nav-tab-active' : ''; ?>">MP3 Player Colors</a>
			<a href="?page=speechy-plugin&tab=payments_history" class="nav-tab <?php echo $active_tab == 'payments_history' ? 'nav-tab-active' : ''; ?>">Payments Info</a>
			<a href="?page=speechy-plugin&tab=contact" class="nav-tab <?php echo $active_tab == 'contact' ? 'nav-tab-active' : ''; ?>">Contact Me!</a>
		<?php } ?>
	</h2>
	
	<div class="speechy_block_left">
	
		<?php if( $active_tab == 'speechy_settings' ) { ?>
		
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_settings.php' ); ?>
				
		<?php } elseif( $active_tab == 'player_settings' ) { ?>
		
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/player_settings.php' ); ?>
			
		<?php } elseif( $active_tab == 'payments_history' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/payments_history.php' ); ?>
			
		<?php } elseif( $active_tab == 'contact' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_contact_me.php' ); ?>
			
		<?php } ?>
	
	</div> <!-- /speechy left -->
	
	<div class="speechy_block_right">
		
		<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_how_to.php' ); ?>

	</div>
</div>
<?php }
	
