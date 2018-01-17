<?php
//get the older values, wont work the first time
$options = get_option( 'player_settings' ); 
?>
<form id="speechy_player_settings" action="options.php" method="post">
	<?php
	settings_fields( 'player_settings' );
	do_settings_sections( __FILE__ );
	?>
	<h3><?php  echo __("MP3 Player style settings" , "speechy"); ?></h3>
	<?php $border_color = (isset($options['border-color']) && $options['border-color'] != '') ? $options['border-color'] : '#ddd'; ?>
	<label for="border-color"><?php  echo __("Change border color" , "speechy"); ?></label>
	<input type="text" name="player_settings[border-color]" value="<?php echo $border_color; ?>" class="speechy-color-picker" >
		
	<?php $bg_color = (isset($options['bg-color']) && $options['bg-color'] != '') ? $options['bg-color'] : '#fff'; ?>
	<label for="bg-color"><?php  echo __("Change background color" , "speechy"); ?></label>
	<input type="text" name="player_settings[bg-color]" value="<?php echo $bg_color; ?>" class="speechy-bg-color-picker" >
		
	<?php $text_color = (isset($options['text-color']) && $options['text-color'] != '') ? $options['text-color'] : '#000'; ?>
	<label for="text-color"><?php  echo __("Change text color" , "speechy"); ?></label>
	<input type="text" name="player_settings[text-color]" value="<?php echo $text_color; ?>" class="speechy-text-color-picker" >
		
	<label for="speechy_player_title"><?php  echo __("Player title (Ex: Listen to this post:)" , "speechy"); ?></label>
	<input type="text" id="speechy_player_title" class="" name="player_settings[speechy_player_title]" value="<?php echo (isset($options['speechy_player_title']) && $options['speechy_player_title'] != '') ? $options['speechy_player_title'] : ''; ?>" placeholder="Listen to this post:" />

	<?php submit_button(); ?>
</form>