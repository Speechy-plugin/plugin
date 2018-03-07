<?php
function createSpeechyAudio( $post_id){
	$post = get_post($post_id);
	global $post_data;
		
	// Checking if user don't want to create an MP3.
	$create_mp3_choice = isset($_REQUEST['speechy-get-checkbox']) ? $_REQUEST['speechy-get-checkbox'] : "";
	update_post_meta( $post_id, 'speechy-get-checkbox', $create_mp3_choice );
	
	$prepmp3type = isset($_REQUEST['prepmp3type']) ? $_REQUEST['prepmp3type'] : "";
	update_post_meta( $post_id, 'prepmp3type', $prepmp3type );
	
	$prepmp3id = isset($_REQUEST['prepmp3id']) ? $_REQUEST['prepmp3id'] : "";
	update_post_meta( $post_id, 'prepmp3id', $prepmp3id );
	
	$preptext = isset($_REQUEST['preptext']) ? $_REQUEST['preptext'] : "";
	update_post_meta( $post_id, 'preptext', $preptext );
	
	
	if( $create_mp3_choice == "checked"){
		// WE DON'T CREATE AN MP3 FILE.
		update_post_meta( $post_id, 'mp3_ready', 0);
		return;
	}else{
		// WE CREATE AN MP3 FILE.
		
		// Getting the text entered by user explicitly
		$speechy_text = stripslashes(isset($_REQUEST['speechy-post-class']) ? $_REQUEST['speechy-post-class'] : ""); // because get_post_meta is returning new value.
		
		// Get the voice choosed by the user explicitily inside the post
		$speechy_voice = stripslashes(isset($_REQUEST['speechy-voice-choice']) ? $_REQUEST['speechy-voice-choice'] : "");
		
		// Setting the voice	
		$voice = ($speechy_voice != "") ? $speechy_voice : VOICE;
		
		$post_object = get_post( $post_id, OBJECT, 'display' );
		$content = "<h1>".$post_object->post_title."</h1>\n";
			
		if (trim($speechy_text) == ""){ 
			// speechy_post_class is empty, we use the main post content
			
			$content .=  $post_object->post_content;
			add_post_meta( $post_id, "Text-to-mp3", $content, true );
		}
		else $content .= $speechy_text;
		// On new post, save_post is calling which should not call so work around is to check content if content is empty, we should not call speechy api.
		if(trim($content) == "") 
			return; 
		
		// ** SpeechyAPi
		$callbackUrl = get_site_url()."/speechy_callback";
		$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
		if($prepmp3type == 'mp3')
			$resp = $speechyApi->createAudio($post_id, $content, $voice, $callbackUrl, SpeechyAPi::PREPENDTYPE_MP3, $prepmp3id);
		elseif ($prepmp3type == 'text')
			$resp = $speechyApi->createAudio($post_id, $content, $voice, $callbackUrl, SpeechyAPi::PREPENDTYPE_TEXT, false, $preptext);
		else
			$resp = $speechyApi->createAudio($post_id, $content, $voice, $callbackUrl);
		
		$is_success = $resp['error'] == 0; // if status is 200 then its a success response.
		//file_put_contents(get_home_path()."/tst.txt" ,$content."\n\n\n".print_r($resp, true));
		if($is_success){
			$mp3_url = $resp['data']['url']; // url is in data.
			update_post_meta( $post_id, 'mp3_url', $mp3_url );
			update_post_meta( $post_id, 'mp3_ready', 0);
		}
	}
	
}
add_action('publish_post', 'createSpeechyAudio');
add_action('publish_page', 'createSpeechyAudio');

/* Success/error notice after post creation/update */

global $post;
$id = $_GET['post'];
$post_object = get_post( $id );

$edit = $_GET['action'];

$modified_time = get_post_meta( $id, 'post_modified', true );
 $post_modified_time = $post_object->post_modified;
 $formatted_date1 = date('Y.m.d H:i', strtotime($post_modified_time));

 $currentDateTime = date('Y-m-d H:i:s');
 $formatted_date2 = date('Y.m.d H:i', strtotime($currentDateTime));
 $post_status = get_post_status( $id );

 $speechy_value = get_post_meta( $id, 'speechy_post_class', true );
 
 $mp3_url = get_post_meta( $id, 'mp3_url', true );

 if(!$mp3_url){
	 $mp3_url = "";
 }

/*post content check */
$content_post = get_post($id);
$content = $content_post->post_content;

$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$resp = $speechyApi->getUsage();

if($resp['error'] == 0){
	if(($speechy_value != "" || $content != "" ) && $formatted_date1 == $formatted_date2 && $mp3_url !=""){
		add_action( 'admin_notices', 'speechy_mp3_ok' );
	}
	elseif($mp3_url == "" && $formatted_date1 == $formatted_date2){
		add_action( 'admin_notices', 'speechy_mp3_error' );
	}
}

function speechy_mp3_ok() {
  ?>
  <div class="updated notice notice-success is-dismissible">
      <p><?php _e( 'We are currently converting your blog post into an MP3 file. It will soon be available on the page with your blog post.', 'speechy' ); ?></p>
  </div>
  <?php
}

function speechy_mp3_error() {
	global $post;
	$getcheckbox = get_post_meta( $post->ID, 'speechy-get-checkbox', true );
	$warningmessage = ($getcheckbox == "checked") ? "As required, the MP3 file has not been created." : "Oops! There was an error creating your MP3 file. Please check if you have reached your plan's limits in the <a href=".SETTING_PAGE_URL .">speechy Settings page</a>.";
  ?>
  <div class="notice notice-error is-dismissible">
      <p><?= $warningmessage; ?></p>
  </div>
  <?php
}

/* ** Reaching limits? ** */
define('HOSTINGLIMIT', $resp['data']['mp3Limit']);
define('BANDWIDTHLIMIT', $resp['data']['hitLimit']);

function limit_passed_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
	
        <p><?php _e( 'It looks like you have reached your current MP3 hosting limits for your Amazon Cloud bucket. Please upgrade your plan in the <a href='.SETTING_PAGE_URL .'>Speechy Settings page</a> and keep up that great work!', 'speechy' ); ?>.</p>
    </div>
    <?php
}

function limit_reached_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'It looks like you will soon reach your current MP3 hosting limits for your Amazon Cloud bucket. Please upgrade your plan in the <a href="'.SETTING_PAGE_URL.'">Speechy Settings page</a> and keep up that great work!', 'speechy' ); ?>.</p>
    </div>
    <?php
}

global $pagenow;

if ( $pagenow == 'post-new.php' OR $pagenow == 'post.php' ){
	$options = get_option( 'speechy_settings' );

	if($options['speechy_id_key'] != ''){
		
		// Actual consumption
		$mp3Count = $resp['data']['mp3Count'];
		$hitCount = $resp['data']['hitCount'];
			
		// Reaching limit?
		$mp3Countreachlimits = HOSTINGLIMIT * 0.9;
		$hitCountreachlimits = BANDWIDTHLIMIT * 0.9;
		
		if($mp3Count > HOSTINGLIMIT){
			add_action( 'admin_notices', 'limit_passed_notice' );
		}else{
			if($mp3Count >= $mp3Countreachlimits){
				add_action( 'admin_notices', 'limit_reached_notice' );
			}
		}
	}
}

// On post/page deletion, we delete the Mp3 on the S3 bucket.

function deleteSpeechyAudio( $post_id){
	//$post = get_post($post_id);
	//global $post_data;
	
	$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
	$delete = $speechyApi->deleteAudio($post_id);
}
add_action('delete_post', 'deleteSpeechyAudio');