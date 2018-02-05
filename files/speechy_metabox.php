<?php
// https://www.smashingmagazine.com/2011/10/create-custom-post-meta-boxes-wordpress/

/* Display the post meta box. */
function speechy_post_class_meta_box( $post ) { 

wp_nonce_field( basename( __FILE__ ), 'speechy_post_class_nonce' ); ?>
  <p>
	<?php
	$get_checkbox = get_post_meta( $post->ID, 'speechy-get-checkbox', true );
	$get_the_voice = get_post_meta( $post->ID, 'speechy-voice-choice', true );
	$voice = ($get_the_voice && '' != $get_the_voice ) ? $get_the_voice : VOICE;
	?>
 
  <p>
    <label for="speechy-post-class"><?php _e( "Speechy checkbox", 'peechy' ); ?></label>
		<p><?php _e( "By default, speechy will create an MP3 file for each post. If you DON'T want this MP3 file to be created, check the following checkbox", 'speechy' ); ?>.</p>
    <input type="checkbox" name="speechy-get-checkbox" id="speechy-get-checkbox" value="checked" <?=$get_checkbox; ?>> <?php _e( "Please, don't create an MP3 file with this post. Thanks!", 'speechy' ); ?>
  </p> 
  
  <p>
    <label for="speechy-post-class"><?php _e( "Speechy text version", 'peechy' ); ?></label>
		<p><?php _e( "We recommend you to use this text field to adapt your post content to the audio file version", 'speechy' ); ?>.<br />
		<?php _e( "This version will only be used to create the audio file, and not shown on your post page.", 'speechy' ); ?><br />
		<?php _e( "You can use <a href='http://docs.aws.amazon.com/polly/latest/dg/supported-ssml.html#break-tag' target='_blank'> Amazon Polly tags</a> to adapt your text.", 'speechy' ); ?></p>
    <textarea name="speechy-post-class" id="speechy-post-class" rows="20" style="width: 100%"><?php echo esc_attr( get_post_meta( $post->ID, 'speechy_post_class', true ) ); ?></textarea>
  </p>
  
  <label for="speechy-post-class"><?php _e( "Select a voice", 'speechy' ); ?></label>
  <p><?php _e( "You can select a new voice only for this post, different from the one set in the setting page", 'speechy' ); ?></p>
  
  <select name="speechy-voice-choice" id="speechy-voice-choice">
						<optgroup label="English (US) (en-US)">
							<option value="Joanna" <?php if($voice== 'Joanna') { echo "SELECTED";} ?>>Joanna - Female - US</option>
							<option value="Joey" <?php if($voice== 'Joey') { echo "SELECTED";} ?>>Joey - Male - US</option>
							<option value="Kendra" <?php if($voice== 'Kendra') { echo "SELECTED";} ?>>Kendra - Female - US</option>
							<option value="Kimberly" <?php if($voice== 'Kimberly') { echo "SELECTED";} ?>>Kimberly - Female - US</option>
							<option value="Matthew" <?php if($voice== 'Matthew') { echo "SELECTED";} ?>>Matthew - Male - US</option>
							<option value="Salli" <?php if($voice== 'Salli') { echo "SELECTED";} ?>>Salli - Female - US</option>
							<option value="Ivy" <?php if($voice== 'Ivy') { echo "SELECTED";} ?>>Ivy - Female child voice - US</option>
							<option value="Justin" <?php if($voice== 'Justin') { echo "SELECTED";} ?>>Justin - Male child voice - US</option>
						</optgroup>
						<optgroup label="English (British) (en-GB)">
							<option value="Amy" <?php if($voice== 'Amy') { echo "SELECTED";} ?>>Amy - Female - UK</option>
							<option value="Brian" <?php if($voice== 'Brian') { echo "SELECTED";} ?>>Brian - Male - UK</option>
							<option value="Emma" <?php if($voice== 'Emma') { echo "SELECTED";} ?>>Emma - Female - UK</option>
						</optgroup>
						   
						  <optgroup label="Español (Castellano) (es-ES)">
							<option value="Conchita" <?php if($voice== 'Conchita') { echo "SELECTED";} ?>>Conchita - Mujer</option>
							<option value="Enrique" <?php if($voice== 'Enrique') { echo "SELECTED";} ?>>Enrique - Hombre</option>
						  </optgroup>
						  <optgroup label="Français (fr-FR)">
							<option value="Celine" <?php if($voice== 'Celine') { echo "SELECTED";} ?>>Céline - Femme</option>
							<option value="Mathieu" <?php if($voice== 'Mathieu') { echo "SELECTED";} ?>>Mathieu - Homme</option>
						  </optgroup>
						  <optgroup label="French (Canadian) (fr-CA))">
							<option value="Chantal" <?php if($voice== 'Chantal') { echo "SELECTED";} ?>>Chantal - Femmme - fr-CA</option>
						  </optgroup>
						  <optgroup label="English (Australian) (en-AU)">
							<option value="Nicole" <?php if($voice== 'Nicole') { echo "SELECTED";} ?>>Nicole - Female - en-AU</option>
							<option value="Russell" <?php if($voice== 'Russell') { echo "SELECTED";} ?>>Russell - Male - en-AU</option>
						  </optgroup>
						  <optgroup label="English (Indian) (en-IN)">
							<option value="Aditi" <?php if($voice== 'Aditi') { echo "SELECTED";} ?>>Aditi - Female - en-IN</option>
							<option value="Raveena" <?php if($voice== 'Raveena') { echo "SELECTED";} ?>>Raveena - Female - en-IN</option>
						  </optgroup>
						  <optgroup label="Portuguese (Brazilian) (pt-BR)">
							<option value="Ricardo" <?php if($voice== 'Ricardo') { echo "SELECTED";} ?>>Ricardo - Male - pt-BR</option>
							<option value="Vitoria" <?php if($voice== 'Vitoria') { echo "SELECTED";} ?>>Vitória - Female - pt-BR</option>
						  </optgroup>
						   <optgroup label="Portuguese (European) (pt-PT)">
							<option value="Cristiano" <?php if($voice== 'Cristiano') { echo "SELECTED";} ?>>Cristiano - Male - pt-PT</option>
							<option value="Ines" <?php if($voice== 'Ines') { echo "SELECTED";} ?>>Inês - Female - pt-PT</option>
						  </optgroup>
						  <optgroup label="German (de-DE)">
							<option value="Hans" <?php if($voice== 'Hans') { echo "SELECTED";} ?>>Hans - Male - DE</option>
							<option value="Marlene" <?php if($voice== 'Marlene') { echo "SELECTED";} ?>>Marlene - Female - DE</option>
							<option value="Vicki" <?php if($voice== 'Vicki') { echo "SELECTED";} ?>>Vicki - Female - DE</option>
						  </optgroup>
						  <optgroup label="Russian (ru-RU)">
							<option value="Maxim" <?php if($voice== 'Maxim') { echo "SELECTED";} ?>>Maxim - Male - RU</option>
							<option value="Tatyana" <?php if($voice== 'Tatyana') { echo "SELECTED";} ?>>Tatyana - Female - RU</option>
						  </optgroup>
						  <optgroup label="Danish (da-DK)">
							<option value="Mads" <?php if($voice== 'Mads') { echo "SELECTED";} ?>>Mads - Male - DK</option>
							<option value="Naja" <?php if($voice== 'Naja') { echo "SELECTED";} ?>>Naja - Female - DK</option>
						  </optgroup>
						  <optgroup label="Dutch (nl-NL)">
							<option value="Lotte" <?php if($voice== 'Lotte') { echo "SELECTED";} ?>>Lotte - Female - NL</option>
							<option value="Ruben" <?php if($voice== 'Ruben') { echo "SELECTED";} ?>>Ruben - Male - NL</option>
						  </optgroup>
						
	</select>
  </p>
<?php 
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function speechy_add_post_meta_boxes() {
   
  // Textearea
  add_meta_box(
    'speechy-post-class',      // Unique ID
    esc_html__( 'Speechy optional settings', 'Speechy' ),    // Title
    'speechy_post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'normal',         // Context
    'high'         // Priority
  );
  
  
}

/* Save the meta box's post metadata. */
function speechy_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['speechy_post_class_nonce'] ) || !wp_verify_nonce( $_POST['speechy_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  //if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
  //  return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  // $get_checkbox = get_post_meta( $post->ID, 'speechy-get-checkbox', true );
  $new_checkbox = ( isset( $_POST['speechy-get-checkbox'] ) ? $_POST['speechy-get-checkbox'] : '' );
  $new_meta_value = ( isset( $_POST['speechy-post-class'] ) ? $_POST['speechy-post-class'] : '' );
  $voice_choice = ( isset($_POST['speechy-voice-choice']) ? $_POST['speechy-voice-choice'] : '' );

  /* Get the meta key. */
  $checkbox_key = 'speechy-get-checkbox';
  $meta_key = 'speechy_post_class';
  $voice_key = 'speechy-voice-choice';
  
  /* Get the meta value of the custom field key. */
  $checkbox_value = get_post_meta( $post_id, $checkbox_key, true );
  $meta_value = get_post_meta( $post_id, $meta_key, true );
  $voice_value = get_post_meta( $post_id, $voice_key, true );
  
  /* Checkbox value */
  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_checkbox && '' == $checkbox_value ){
    add_post_meta( $post_id, $checkbox_key, $new_checkbox, true );

  /* If the new meta value does not match the old value, update it. */
  }elseif( $new_checkbox && $new_checkbox != $checkbox_value ){
    update_post_meta( $post_id, $checkbox_key, $new_checkbox );

  /* If there is no new meta value but an old value exists, delete it. */
  }elseif( '' == $new_checkbox && $checkbox_value ){
    delete_post_meta( $post_id, $checkbox_key, $checkbox_value );
  }
  
  // Textearea
  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value ){
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  }elseif( $new_meta_value && $new_meta_value != $meta_value ){
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  }elseif( '' == $new_meta_value && $meta_value ){
    delete_post_meta( $post_id, $meta_key, $meta_value );
  }
  
  // Voice 
  /* If a new meta value was added and there was no previous value, add it. */
  if ( $voice_choice && '' == $voice_value ){
    add_post_meta( $post_id, $voice_key, $voice_choice, true );

  /* If the new meta value does not match the old value, update it. */
  }elseif( $voice_choice && $voice_choice != $voice_value ){
    update_post_meta( $post_id, $voice_key, $voice_choice );

  /* If there is no new meta value but an old value exists, delete it. */
  }elseif( '' == $voice_choice && $voice_value ){
    delete_post_meta( $post_id, $voice_key, $voice_value );
  }
  
}

/* Meta box setup function. */
function speechy_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'speechy_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'speechy_save_post_class_meta', 10, 2 );
}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'speechy_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'speechy_post_meta_boxes_setup' );