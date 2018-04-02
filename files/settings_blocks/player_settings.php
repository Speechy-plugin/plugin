<?php
//get the older values, wont work the first time
$options = get_option( 'player_settings' ); 
?>
<form id="speechy_player_settings" action="options.php" method="post">
	<?php
	settings_fields( 'player_settings' );
	do_settings_sections( __FILE__ );
	?>
	<?php $title_color = (isset($options['title-color']) && $options['title-color'] != '') ? $options['title-color'] : '#000'; ?>
	<?php $player_border = (isset($options['player-border']) && $options['player-border'] != '') ? $options['player-border'] : '0'; ?>
	<?php $border_color = (isset($options['border-color']) && $options['border-color'] != '') ? $options['border-color'] : '#ddd'; ?>
	<?php $bg_color = (isset($options['bg-color']) && $options['bg-color'] != '') ? $options['bg-color'] : '#fff'; ?>
	<?php $player_logo = (isset($options['player-logo']) && $options['player-logo'] != '') ? $options['player-logo'] : ''; ?>
	<?php $player_bg_image = (isset($options['player-bg-image']) && $options['player-bg-image'] != '') ? $options['player-bg-image'] : ''; ?>
	
	<h3><?php  echo __("MP3 Player Settings" , "speechy"); ?></h3>
	
	<table class="player_settings">
		<tr>
			<td>
				<label for="speechy_player_title"><?php echo __("Player Title" , "speechy"); ?></label>
				<small><?php echo __("Example: Listen to this post or the name of your company" , "speechy"); ?></small>
			</td>
			<td><input type="text" id="speechy_player_title" class="" name="player_settings[speechy_player_title]" value="<?php echo (isset($options['speechy_player_title']) && $options['speechy_player_title'] != '') ? $options['speechy_player_title'] : ''; ?>" placeholder="Listen to this post:" /></td>
		</tr>
		<tr>
			<td><label for="text-color"><?php  echo __("Player Title Color" , "speechy"); ?></label></td>
			<td><input type="text" name="player_settings[title-color]" value="<?php echo $title_color; ?>" class="speechy-text-color-picker" ></td>
		</tr>
		<tr>
			<td><label for="player-border"><?php  echo __("Player Border" , "speechy"); ?></label></td>
			<td>
				<select name="player_settings[player-border]">
					<option value="0" <?php if( $player_border == '0' ) { echo "SELECTED";} ?>>No border</option>
					<option value="1" <?php if( $player_border == '1' ) { echo "SELECTED";} ?>>With border</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="border-color"><?php  echo __("Border color" , "speechy"); ?></label></td>
			<td><input type="text" name="player_settings[border-color]" value="<?php echo $border_color; ?>" class="speechy-color-picker" ></td>
		</tr>
		<tr>
			<td><label for="bg-color"><?php  echo __("Background color" , "speechy"); ?></label></td>
			<td><input type="text" name="player_settings[bg-color]" value="<?php echo $bg_color; ?>" class="speechy-bg-color-picker" ></td>
		</tr>
		<tr>
			<td>
				<label for="player-bg-image"><?php  echo __("Player Background Image" , "speechy"); ?></label>
				<small><?php echo __("Suggested image dimensions","speechy"); ?>: 800 by 200 pixels</small>
			</td>
			<td>
				<div class="show_player_bg_image">
					<?php
					if($player_bg_image != "") { echo "<img src='".$player_bg_image."' style='height: 100px' />";}
					?>
				</div>
				<input type="hidden" class="player_bg_image_value" name="player_settings[player-bg-image]" value="<?= $player_bg_image; ?>">
				<input type="button" class="set_player_bg_image button" value="<?php if($player_bg_image != "") { echo "Change"; }else{ echo "Set"; } ?> Player Background Image" name="player_settings[player-bg-image]">
				<?php if($player_bg_image != "") echo "<span class='delete_player_bg_image'>Remove image</span>"; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="player-logo"><?php  echo __("Player Logo" , "speechy"); ?></label>
				<small><?php echo __("Suggested image dimensions","speechy"); ?>: 100 by 100 pixels</small>
			</td>
			<td>
				<div class="show_player_logo">
					<?php
					if($player_logo != "") { echo "<img src='".$player_logo."' style='height: 100px' />";}
					?>
				</div>
				<input type="hidden" class="player_logo_value" name="player_settings[player-logo]" value="<?= $player_logo; ?>">
				<input type="button" class="set_player_logo button" value="<?php if($player_logo != "") { echo "Change"; }else{ echo "Set"; } ?> Player Logo" name="player_settings[player-logo]">
				<?php if($player_logo != "") echo "<span class='delete_player_logo'>Remove image</span>"; ?>
			</td>
		</tr>

	</table>
	
	<?php submit_button(); ?>
</form>