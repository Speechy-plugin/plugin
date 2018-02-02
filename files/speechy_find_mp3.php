<?php
// looking for the MP3 field in the front end content
function speechy_find_mp3($content){
	global $post;
	$post_id = $post->ID;
	
	    $custom_content = "";
		
		// MP3 available?
		$mp3_ready = get_post_meta( $post_id, 'mp3_ready', true );
		
		if($mp3_ready == '1'){
			
			// Get mp3_url for this post
			$sp_mp3 = get_post_meta( $post_id, 'mp3_url', true );
		
			if ( ! empty( $sp_mp3 ) ) {
				$custom_content .= "<!-- speechy.io --><div class='speechy_mp3 clearfix'>";
				$custom_content .= "<span class='player_title'>".PLAYER_TITLE."</span>";
				$custom_content .= do_shortcode( '[audio src="'.$sp_mp3.'"]' );
				$custom_content .= "<small class='powered_by'>Powered by <a href='https://www.speechy.io/?utm_source=plugin&utm_medium=link&utm_campaign=powered_by' target='_blank' title='Try Speechy' alt='text-to-speech wordpress plugin'><img src='". plugins_url() ."/speechy-master/images/Speechy_icon_logo_32px.png'</a></small>";
				$custom_content .= "<div class='download_link'><a href='".$sp_mp3."' onclick=\"ga('send', 'event', 'Button', 'Download MP3', 'Users blog', '0');\">Download</a></div>";
				$custom_content .= "</div><!-- END speechy.io -->";
				$custom_content .= $content;
				
				return $custom_content;
			}else{
				return $content;
			}
		}else{
			return $content;
		}
	
}

add_filter( 'the_content', 'speechy_find_mp3' );