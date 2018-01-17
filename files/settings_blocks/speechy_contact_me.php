<?php
$request = wp_remote_get('https://speechy.io/wp-json/speechycontent/v2/speechy_post/4/');

if(is_wp_error($request)){
	return false;
}

$body = wp_remote_retrieve_body($request);
$data = json_decode($body);
echo "<div class='speechy_block_contact_me'>".$data."</div>";
?>