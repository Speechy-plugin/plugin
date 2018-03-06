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
	<?php $text_color = (isset($options['text-color']) && $options['text-color'] != '') ? $options['text-color'] : '#000'; ?>
	<?php $bg_image = (isset($options['bg-image']) && $options['bg-image'] != '') ? $options['bg-image'] : '#000'; ?>
	<?php $player_logo = (isset($options['player-logo']) && $options['player-logo'] != '') ? $options['player-logo'] : ''; ?>
	<?php $player_bg_image = (isset($options['player-bg-image']) && $options['player-bg-image'] != '') ? $options['player-bg-image'] : ''; ?>
	
	<h3><?php  echo __("MP3 Player Settings" , "speechy"); ?></h3>
	
	<table class="player_settings">
		<tr>
			<td><label for="speechy_player_title"><?php  echo __("Player Title (Ex: Listen to this post:)" , "speechy"); ?></label></td>
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
			<td><label for="text-color"><?php  echo __("Text color" , "speechy"); ?></label></td>
			<td><input type="text" name="player_settings[text-color]" value="<?php echo $text_color; ?>" class="speechy-text-color-picker" ></td>
		</tr>
		
		<tr>
			<td>
				<label for="player-logo"><?php  echo __("Player Logo" , "speechy"); ?></label>
			</td>
			<td>
				<div class="show_player_logo">
					<?php
					if($player_logo != "") { echo "<img src='".$player_logo."' />";}
					?>
				</div>
				<input type="hidden" class="player_logo_value" name="player_settings[player-logo]" value="<?= $player_logo; ?>">
				<input type="button" class="set_player_logo button" value="<?php if($player_logo != "") { echo "Change"; }else{ echo "Set"; } ?> Player logo" name="player_settings[player-logo]">
				<?php if($player_logo != "") echo "<span class='delete_player_logo'>delete image</span>"; ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="player-bg-image"><?php  echo __("Player Background Image" , "speechy"); ?></label>
			</td>
			<td>
				<div class="show_player_bg_image">
					<?php
					if($player_bg_image != "") { echo "<img src='".$player_bg_image."' />";}
					?>
				</div>
				<input type="hidden" class="player_bg_image_value" name="player_settings[player-bg-image]" value="<?= $player_bg_image; ?>">
				<input type="button" class="set_player_bg_image button" value="<?php if($player_logo != "") { echo "Change"; }else{ echo "Set"; } ?> Player logo" name="player_settings[player-bg-image]">
				<?php if($player_bg_image != "") echo "<span class='delete_player_bg_image'>delete image</span>"; ?>
			</td>
		</tr>
		
		<tr>
			<td><label for="text-color"><?php  echo __("Player Background Image" , "speechy"); ?></label></td>
			<td>
				<?php if (get_theme_mod( 'speechy_bg' ) != ""){ ?>
					<p><input type="radio" name="player_settings[bg-image]" value="20" checked > <div>Your custom image:</div><img src='<?= get_theme_mod( 'speechy_bg' ); ?>' style="width: 300px"></p>
				<?php } ?>
				<p>Upload your own Player background image using the <a href="<?= admin_url( '/customize.php?autofocus%5Bsection%5D=speechy' ); ?>">Customizer</a>.</p>
				<p><input type="radio" name="player_settings[bg-image]" value="0" <?php if( $bg_image == '0' ) { echo "checked";} ?>> No background image</p>
				<p><input type="radio" name="player_settings[bg-image]" value="1" <?php if( $bg_image == '1' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-1-small.jpg' ></p>
				<p><input type="radio" name="player_settings[bg-image]" value="3" <?php if( $bg_image == '3' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-3-small.jpg' ></p>
				<p><input type="radio" name="player_settings[bg-image]" value="5" <?php if( $bg_image == '5' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-5-small.jpg' ></p>
				<p><input type="radio" name="player_settings[bg-image]" value="7" <?php if( $bg_image == '7' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-7-small.jpg' ></p>
				<p><input type="radio" name="player_settings[bg-image]" value="8" <?php if( $bg_image == '8' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-8-small.jpg' ></p>
				<p><input type="radio" name="player_settings[bg-image]" value="10" <?php if( $bg_image == '10' ) { echo "checked";} ?>> <img src='<?php echo plugins_url( ); ?>/speechy/images/background-10-small.jpg' ></p>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
	</table>
	
	<?php submit_button(); ?>
</form>