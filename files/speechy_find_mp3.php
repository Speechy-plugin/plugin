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
		
		// Player title
		$show_title = get_the_title($post_id);
		$count = strlen($show_title);
		$pixels = $count * 8.5;
		$speed = $count / 7.5;
		$animation = "-moz-animation: scroll-title ".$speed."s linear infinite;-webkit-animation: scroll-title ".$speed."s linear infinite;animation: scroll-title ".$speed."s linear infinite;";
		$show_scrolling = ($count >= 46) ? " scroll" : "";
		
		//$audio_player = do_shortcode('[audio src="'.$sp_mp3.'"]');
		
		if ( ! empty( $sp_mp3 ) ) {
				$custom_content .= '<!-- Audio file powered by Speechy. If you want to convert your post into podcasts, visit us at: https://speechy.io -->';
				$custom_content .= '<div class="speechy_mp3 '.$position.' clearfix">';
				$custom_content .= "<small class='powered_by'><a href='https://www.speechy.io/?utm_source=plugin&utm_medium=link&utm_campaign=powered_by' target='_blank' title='Try Speechy' alt='text-to-speech wordpress plugin'><img src='" . plugins_url( 'images/Sp.png', dirname(__FILE__) ) . "' ></a></small>";
				$custom_content .= "<small class='download_link'><a href='".$sp_mp3."' title='Download this post' onclick=\"ga('send', 'event', 'Button', 'Download MP3', 'Users blog', '0');\"> </a></small>";
				
				if ( isset($player_logo) && $player_logo != '' ) : 
					$custom_content .= "<img src='" .  $player_logo . "' class='player_image'>";
					//$custom_content .= $audio_player;
					$custom_content .= '<div class="player_with_image">';
						$custom_content .= '<div class="scroll-title">';
							$custom_content .= '<span class="player_title ' . $show_scrolling . '" style="width: ' . $pixels . 'px; ' . $animation . '">' . $show_title . '</span>';
						$custom_content .= '</div>';
						$custom_content .= do_shortcode('[audio src="'.$sp_mp3.'"]');
					$custom_content .= '</div>';
				else :
					//$custom_content .= $audio_player;
					$custom_content .= '<div class="player_without_image">';
						$custom_content .= '<div class="scroll-title">';
							$custom_content .= '<span class="player_title ' . $show_scrolling . '" style="width: ' . $pixels . 'px; ' . $animation . '">' . $show_title . '</span>';
						$custom_content .= '</div>';
						$custom_content .= do_shortcode('[audio src="'.$sp_mp3.'"]');
					$custom_content .= '</div>';
				endif;
				$custom_content .= '</div>';
				$custom_content .= '<!-- END speechy.io -->';
				
				if($position === "After"){
					$content .= $original_content . $custom_content;
				}else{
					$content = $custom_content . $original_content;
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