<?php
// Player style settings
// border-color";s:7:"#ddb67c";s:8:"bg-color";s:7:"#dd3333";s:10:"text-color";s:7:"#eeee22";s:20:"speechy_player_title";s:20:"Listen to this post:"

$speechy_border = $options_player['player-border'];
$speechy_border_color = $options_player['border-color'];
$speechy_bg_color = $options_player['bg-color'];
$speechy_bg = esc_url( get_theme_mod( 'speechy_bg' ) );

if(isset($speechy_bg) && $speechy_bg != "") {
	$speechy_bg_image =  'background: url("' . $speechy_bg.'") !important;';
}else{
	$speechy_bg_image = (isset($options_player['bg-image']) && $options_player['bg-image'] != '0') ? 'background: url("' . plugins_url( ).'/speechy/images/background-'.$options_player['bg-image'].'.jpg") !important;'  : '';
}

$speechy_text_color = $options_player['text-color'];
$speechy_title_color = $options_player['title-color'];
$speechy_player_title = $options_player['speechy_player_title'];

define('PLAYER_BORDER', $speechy_border);
define('PLAYER_BORDER_COLOR', $speechy_border_color);

define('PLAYER_BG_COLOR', $speechy_bg_color);
define('PLAYER_BG_IMAGE', $speechy_bg_image);
define('PLAYER_TITLE_COLOR', $speechy_title_color);
define('PLAYER_TEXT_COLOR', $speechy_text_color);
define('PLAYER_TITLE', $speechy_player_title);

/* Updating styles from settings */
function styl_func(){
	echo'<style>
	.speechy_mp3 {
		border: ' . PLAYER_BORDER . 'px dotted '. PLAYER_BORDER_COLOR .' !important;
		background:'. PLAYER_BG_COLOR .'!important;
		' . PLAYER_BG_IMAGE .'
	}

	.speechy_mp3 .player_title {
		color:'. PLAYER_TEXT_COLOR .'!important;
	}
	
	.speechy_mp3 .powered_by, .speechy_mp3 .powered_by am, .speechy_mp3 .download_link a {
		color:'. PLAYER_TITLE_COLOR .'!important;
	}
	</style>';
}
add_action('wp_footer','styl_func');
/* END Updating styles from settings */