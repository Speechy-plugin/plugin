<?php
// looking for the MP3 field in the front end content 
function speechy_find_mp3($content){
	global $post;
	$post_id = $post->ID;
	
	$original_content = $content;

	if(is_singular()){
		// Get mp3_url for this post
		$sp_mp3 = get_post_meta( $post_id, 'mp3_url', true );
			
		//Position
		$options = get_option( 'speechy_settings' );
		$position = $options['position'];
		
		// Player settings
		$options_player = get_option( 'player_settings' );
		$player_logo = $options_player['player-logo'];
		
		//$audio_player = do_shortcode('[audio src="'.$sp_mp3.'"]');
		
		if ( ! empty( $sp_mp3 ) ) {
				$custom_content .= '<!-- Powered by https://speechy.io --><div class="speechy_mp3 '.$position.' clearfix">';
				$custom_content .= '<span class="player_title">'.PLAYER_TITLE.'</span>';
				
				if ( isset($player_logo) && $player_logo != '' ) : 
					$custom_content .= "<img src='" .  $player_logo . "' class='player_image'>";
					//$custom_content .= $audio_player;
					$custom_content .= '<audio id="speechy-player" class="player_with_image" preload="none" controls>';
						$custom_content .= '<source type="audio/mpeg" src="' . $sp_mp3 . '">';
					$custom_content .= '</audio>';
				else :
					//$custom_content .= $audio_player;
					$custom_content .= '<audio id="speechy-player" preload="none" controls>';
						$custom_content .= '<source type="audio/mpeg" src="' . $sp_mp3 . '">';
					$custom_content .= '</audio>';
				endif;
				
				$custom_content .= "<small class='download_link'><a href='".$sp_mp3."' onclick=\"ga('send', 'event', 'Button', 'Download MP3', 'Users blog', '0');\">Download MP3</a></small>";
				$custom_content .= "<small class='powered_by'>Powered by <a href='https://www.speechy.io/?utm_source=plugin&utm_medium=link&utm_campaign=powered_by' target='_blank' title='Try Speechy' alt='text-to-speech wordpress plugin'><img src='" . plugins_url( 'images/Speechy_icon_logo_32px.png', dirname(__FILE__) ) . "' ></a></small>";
				$custom_content .= '</div><!-- END speechy.io -->';
				
				if($position === "Before"){
					$content = $custom_content . $original_content ;
				}else{
					$content .= $original_content . $custom_content;
				}

			return $content;
		}else{
			return $content;
		}
	}else{
		return $content;
	}
}

add_filter( 'the_content', 'speechy_find_mp3' );