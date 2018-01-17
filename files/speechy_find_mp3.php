<?php
// looking for the MP3 field in the front end content
function speechy_find_mp3($content){
	global $post;
	$post_id = $post->ID;
	
	    $custom_content = "";
		// Get mp3_url for this post
		$sp_mp3 = get_post_meta( $post_id, 'mp3_url', true );
		
		// Check if mp3_url has a value.
		if ( ! empty( $sp_mp3 ) ) {
			$custom_content .= "<div class='speechy_mp3 clearfix'>";
			$custom_content .= "<span class='player_title'>".PLAYER_TITLE."</span>";
			$custom_content .= do_shortcode( '[audio src="'.$sp_mp3.'"]' );
			//$custom_content .= "<small class='powered_by'>Powered by <a href='https://www.speechy.io/?utm_source=plugin&utm_medium=link&utm_campaign=powered_by' target='_blank'>Speechy.io</a></small>";
			$custom_content .= "<div class='download_link'><a href='".$sp_mp3."'>Download</a></div>";
			$custom_content .= "</div>";
			$custom_content .= $content;
			
			return $custom_content;
		}else{
			return $content;
		}
	
}

add_filter( 'the_content', 'speechy_find_mp3' );