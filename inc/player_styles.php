<?php
// Player style settings
// border-color";s:7:"#ddb67c";s:8:"bg-color";s:7:"#dd3333";s:10:"text-color";s:7:"#eeee22";s:20:"speechy_player_title";s:20:"Listen to this post:"

$speechy_border = $options_player['player-border'];
$speechy_border_color = $options_player['border-color'];
$speechy_bg_color = (isset($options_player['bg-color']) && $options_player['bg-color'] != '0') ? 'background: '.$options_player['bg-color'].' !important;'  : '';
$player_padding = (isset($options_player['player-logo']) && $options_player['player-logo'] != '' ) ? "" : "padding: 5px !important;";

$speechy_bg = $options_player['player-bg-image'];
$speechy_bg_image = (isset($speechy_bg) && $speechy_bg != '') ? 'background: url("'.$speechy_bg.'") !important;'  : '';

$speechy_text_color = $options_player['text-color'];
$speechy_title_color = $options_player['title-color'];
$speechy_player_title = $options_player['speechy_player_title'];
	
define('PLAYER_BORDER', $speechy_border);
define('PLAYER_PADDING', $player_padding);
define('PLAYER_BG_COLOR', $speechy_bg_color);
define('PLAYER_BG_COLOR', $speechy_bg_color);
define('PLAYER_BG_IMAGE', $speechy_bg_image);
define('PLAYER_TITLE_COLOR', $speechy_title_color);
define('PLAYER_TEXT_COLOR', $speechy_text_color);
define('PLAYER_TITLE', $speechy_player_title);

/* Updating styles from settings */
function styl_func(){
	echo'<style>
	.speechy_mp3 {
		' . PLAYER_PADDING .'
		border: ' . PLAYER_BORDER . 'px solid '. PLAYER_BORDER_COLOR .' !important;
		'. PLAYER_BG_COLOR .'
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