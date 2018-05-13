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

add_action('admin_init', 'mp3prepend_setting');
add_action( 'wp_ajax_mp3prepend_setting','mp3prepend_setting' );
add_action('wp_ajax_nopriv_mp3prepend_setting', 'mp3prepend_setting');

function mp3prepend_setting(){
	$action = isset($_REQUEST['action'])?$_REQUEST['action']:false;
	if($action === "mp3upload"){
		$name = $_REQUEST['mp3name'];
		$filename = $_FILES['mp3file']['tmp_name'];
		$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
		$resp = $speechyApi->addMp3($name, $filename);
		header("Location: ?page=speechy-plugin&tab=mp3prepend");
	}
	elseif($action === "mp3uploadajax"){
		$name = $_REQUEST['mp3name'];
		$filename = $_FILES['mp3file']['tmp_name'];
		$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
		$resp = $speechyApi->addMp3($name, $filename);
		if($resp['error'] == '0'){
			$id = $resp['data']['id']; 
			$list = $speechyApi->getMp3List();
			$list = $list['data']['mp3list'];
			$html = '';
			$html .= '<option value="0" <?php if( $process_custom_audio== "0" ) { echo "SELECTED";} ?>>No MP3 added</option>';
			$html .= '<option value="1">Upload New Audio</option>';
			
			foreach ( $list as $mp3 ) {
				$html .= '<option value="'.$mp3['id'].'" ' . ($mp3['id'] == $id?'selected':'') . '>'.$mp3['name'].'</option>';
			}
			echo json_encode(array("html"=>$html, "id"=>$id, "error"=>0));
		}
		else {
			echo json_encode($resp);
		}
		exit();
	}
	elseif($action === "mp3remove"){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:false;
		if($id){
			$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
			$resp = $speechyApi->deleteMp3($id);
		}
		
		header("Location: ?page=speechy-plugin&tab=mp3prepend");
	}
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
		<a href="?page=speechy-plugin&tab=how_to" class="nav-tab <?php echo $active_tab == 'how_to' ? 'nav-tab-active' : ''; ?>">How to use Speechy</a>
		<?php if(ID_KEY != ''){ ?>
			<a href="?page=speechy-plugin&tab=player_settings" class="nav-tab <?php echo $active_tab == 'player_settings' ? 'nav-tab-active' : ''; ?>">MP3 Player Style</a>
			<a href="?page=speechy-plugin&tab=mp3prepend" class="nav-tab <?php echo $active_tab == 'mp3prepend' ? 'nav-tab-active' : ''; ?>">Prepended Audio Message</a>
			<a href="?page=speechy-plugin&tab=voice_samples" class="nav-tab <?php echo $active_tab == 'voice_samples' ? 'nav-tab-active' : ''; ?>">Voice Samples</a>
			<a href="?page=speechy-plugin&tab=payments_history" class="nav-tab <?php echo $active_tab == 'payments_history' ? 'nav-tab-active' : ''; ?>">Payments Info</a>
		<?php } ?>
	</h2>
	
	<div class="speechy_block_left seventy">
	
		<?php if( $active_tab == 'speechy_settings' ) { ?>
		
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_settings.php' ); ?>
				
		<?php } elseif( $active_tab == 'player_settings' ) { ?>
		
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/player_settings.php' ); ?>
		
		<?php } elseif( $active_tab == 'mp3prepend' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/mp3prepend.php' ); ?>
		
		<?php } elseif( $active_tab == 'payments_history' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/payments_history.php' ); ?>
			
		<?php } elseif( $active_tab == 'contact' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_contact_me.php' ); ?>
			
		<?php }elseif( $active_tab == 'how_to' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/speechy_how_to.php' ); ?>
			
		<?php }elseif( $active_tab == 'voice_samples' ) { ?>
			
			<?php include_once( plugin_dir_path( __FILE__ ) . '/settings_blocks/voice_samples.php' ); ?>
			
		<?php } ?> 
	
	</div> <!-- /speechy left -->
	
	<div class="speechy_block_left thirty">
		<?php if( $active_tab == 'speechy_settings' ) { ?>
			<div class="help">
				<h4>Need help?</h4>
				<ol>
				<li>Take a look at the How To page <a href="?page=speechy-plugin&tab=how_to">here</a></li>
				<li>See the following video:
				<div style="margin: 10px 0">
				<script src="https://fast.wistia.com/embed/medias/5dpvufsxtg.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_5dpvufsxtg popover=true popoverAnimateThumbnail=true" style="display:inline-block;height:71px;position:relative;width:150px">&nbsp;</span>
				</div>
				</li>
				<li>Send us an email at <a href="mailto:help@speechy.io">help@speechy.io</a></li>
				<li>Or use the chat box on <a href="https://speechy.io">speechy.io</a>.</li>
				</ol>
				
				<p>We will do our best to help you!</p>
				<p>Nicolas,<br />
				Speechy founder.</p>
			</div>
		<?php } ?>
	</div>
</div>
<?php }
	
