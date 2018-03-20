<?php
// ** SpeechyAPi
$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$resp = $speechyApi->getUsage();

// print_r($resp);

/* ** Plans ** */
/*
free
blogger-plan
pro-plan
premium-plan
*/

$plan_id = $resp['data']['plan'];

if($plan_id == "free"){
	$plan =  "14 days Free Trial";
}else{
	$plan = str_replace("-", " ", $plan_id);
	$plan = ucfirst($plan);
}

/* Warning Notice */
define('WARNINGMP3', $resp['data']['mp3Limit']);
define('WARNINGHIT', $resp['data']['hitLimit']);
define('MP3UPDATELIMIT', $resp['data']['mp3UpdateLimit']);

/* ** Actual consumption ** */
$mp3Count = $resp['data']['mp3Count'];
$hitCount = $resp['data']['hitCount'];
$mp3UpdateCount = $resp['data']['mp3UpdateCount'];

if($plan_id == "free"){
	$freePlanValidity = $resp['data']['freePlanValidity'];
	define('FREEPLANVALIDITY', $freePlanValidity);
	
}
/* Reaching limit */
$mp3Countreachlimits = HOSTINGLIMIT * 0.9;
$hitCountreachlimits = BANDWIDTHLIMIT * 0.9;
$hitConversionsreachlimits = MP3UPDATELIMIT * 0.9;

/* ** Plans limit notice ** */
$class_notice_mp3 = "none";
$class_notice_hit = "none";
$class_notice_conversions = "none";

$planclassmp3 = $planclasshit = $planclassconv = "green";

//get the older values, wont work the first time
$options = get_option( 'speechy_settings' ); 

if(isset($options['speechy_id_key']) && $options['speechy_id_key'] != ''){
	/* MP3 files */
	if(null !==HOSTINGLIMIT){
		if($mp3Count > HOSTINGLIMIT){
		$plan_mp3_limit_notice = _e("<div class='limit_notice red'><h4>You have reached your current plan's maximum MP3 hosting limits.</h4><h4><a href='javascript:void()' onclick=\"openPortal(function(msg){ alert(msg);});\">Upgrade your plan here</a> and keep creating more amazing MP3 files for your blog!</h4></div>", "speechy");
		
		$class_notice_mp3 = $planclassmp3 = "red";
		}else{
			if($mp3Count >= $mp3Countreachlimits){
				// Congratulations! Your listeners have maxed out your current monthly MP3 play limit. Your blog deserves an upgrade.
				$plan_mp3_limit_notice = _e("<div class='limit_notice orange'><h4>You will soon reach your current plan's maximum MP3 hosting limits.</h4><h4><a href='javascript:void()' onclick=\"openPortal(function(msg){ document.getElementById('updated-msg').innerHTML = msg; });\">Upgrade your plan here</a> and keep up that great work!</h4></div>", "speechy");

				$class_notice_mp3 = $planclassmp3 = "orange";
			} 
		}
	}
	
	/* hit files */
	if(null !==HOSTINGLIMIT){
		if($hitCount > BANDWIDTHLIMIT){
			// You will soon reach your current plan’s maximum MP3 hosting limits. Upgrade your plan and keep up that great work!
			$plan_hit_limit_notice = _e("<div class='limit_notice red'><h4>Congratulations! Your listeners have maxed out your current monthly MP3 play limit. Your blog deserves an upgrade.</h4><h4><a href='javascript:void()' onclick=\"openPortal(function(msg){ document.getElementById('updated-msg').innerHTML = msg;});\">Upgrade your plan here</a> and keep up that great work!</h4></div>", "speechy");
			
			$class_notice_hit = $planclasshit = "red";
		}else{
			if($hitCount >= $hitCountreachlimits){
				$plan_hit_limit_notice = _e("<div class='limit_notice orange'><h4>Well done! Your listeners have almost maxed out your current monthly MP3 play limit.</h4><h4>It looks like a great time for an upgrade. <a href='javascript:void()' onclick=\"openPortal(function(msg){ document.getElementById('updated-msg').innerHTML = msg; });\">Upgrade your plan</a> and keep up that great work!</h4></div>", "speechy");

				$class_notice_hit = $planclasshit = "orange";
			}
		}
	}
	
	/* Conversion files */
	if(null !== HOSTINGLIMIT){
		if($mp3UpdateCount > MP3UPDATELIMIT){
			// You will soon reach your current plan’s maximum MP3 hosting limits. Upgrade your plan and keep up that great work!
			$plan_conversion_limit_notice = _e("<div class='limit_notice red'><h4>You have reached your current plan's maximum MP3 conversion limits.</h4><h4><a href='javascript:void()' onclick=\"openPortal(function(msg){ alert(msg);});\">Upgrade your plan here</a> and keep creating more amazing MP3 files for your blog!</h4></div>", "speechy");
			
			$class_notice_conversion =  $planclassconv = "red";
		}else{
			if($mp3UpdateCount >= $hitConversionsreachlimits){
				$plan_conversion_limit_notice = _e("<div class='limit_notice orange'><h4>You will soon reach your current plan's maximum MP3 conversion limits.</h4><h4><a href='javascript:void()' onclick=\"openPortal(function(msg){ document.getElementById('updated-msg').innerHTML = msg; });\">Upgrade your plan here</a> and keep up that great work!</h4></div>", "speechy");

				$class_notice_conversion = $planclassconv = "orange";
			}
		}
	}
}
?>
<?php add_thickbox(); ?>

<h3><?php echo __("Subscription Info" , "speechy"); ?></h3>

<?php
if(isset($options['speechy_id_key']) && $options['speechy_id_key'] != '' && null !== HOSTINGLIMIT){
	?>
	<h3>
		<?php 
		if($plan_id == "free"){ 
			echo "You have <span>".FREEPLANVALIDITY."</span> days left on your free trial"; } 
		else {
			echo __("Your current plan is:" , "speechy") . " <span>" . $plan . "</span>";	
		}   
		?>
		(<a href='javascript:void()' class="open_iframe" onclick='openPortal(function(msg){ document.getElementById("updated-msg").innerHTML = msg;});' ><?php echo __('Upgrade', 'speechy'); ?></a>)</h3>
		
		<div id="updated-msg"></div>
	
	<?php	
	echo $plan_mp3_limit_notice;
	echo $plan_hit_limit_notice; 
	echo $plan_conversion_limit_notice;
	?>

	<table class="table yourplan">		
		<tr>
			<td class="<?= $class_notice_conversion; ?>"><?php echo __("MP3 conversions this month" , "speechy"); ?></td>
			<td><span class="<?= $planclassconv; ?>"><?= $mp3UpdateCount; ?></span> / <?= MP3UPDATELIMIT; ?></td>
		</tr>
		<tr>
			<td class="<?= $class_notice_mp3; ?>"><?php echo __("MP3 stored on Amazon Cloud" , "speechy"); ?></td>
			<td><span class="<?= $planclassmp3; ?>" ><?= $mp3Count; ?></span> / <?= HOSTINGLIMIT; ?></td>
		</tr>
		<tr>
			<td class="<?= $class_notice_hit; ?>"> <?php echo __("MP3 played this month" , "speechy"); ?></td>
			<td><span class="<?= $planclasshit; ?>"><?= $hitCount; ?></span> / <?= BANDWIDTHLIMIT; ?></td>
		</tr>
	
	</table>
	
	<p>
	<?php echo __("If you need more space and bandwidth, you can" , "speechy"); ?> <a href='javascript:void()' class="open_iframe" onclick='openPortal(function(msg){ document.getElementById("updated-msg").innerHTML = msg;});' ><?php echo __("upgrade your plan here" , "speechy"); ?></a>.</p>
	<?php //  ?>
	<?php
}else{
	?>
	<div class='limit_notice red'><?php echo __("For Speechy to work properly, you need to enter the ID key and Secret key." , "speechy"); ?><p><a href='javascript:void()' onclick="openPortal(function(msg){ document.getElementById('updated-msg').innerHTML = msg; });"><?php echo __("Sign up for a free plan or confirm your credentials here" , "speechy"); ?></a></p></div>
	<?php
}
?>

<form id="speechy_licence_form" action="options.php" method="post">
	<?php
	settings_fields( 'speechy_settings' );
	do_settings_sections( __FILE__ );
	?>
	<?php
	if(!isset($options['speechy_id_key']) || $options['speechy_id_key'] == ''){
		
	?>
		<div class="notice notice-error">
			<h3><?php echo __("Important: For Speechy to work properly, you need to enter the ID key and Secret key" , "speechy"); ?>.<br /><a href='javascript:void()' onclick='openPortal(function(msg){ document.getElementById("updated-msg").innerHTML = msg; });'><?php echo __("Sign up for a free plan here" , "speechy"); ?></a>.</h3>
		</div>
	<?php
	}
	?>
		
	<h3><?php echo __("Licence Settings" , "speechy"); ?></h3>
	
	<table>
		<tr>
			<td><label for="key"><?php echo __("ID key" , "speechy"); ?></label></td>
			<td><input type="text" id="speechy_id_key" class="" name="speechy_settings[speechy_id_key]" value="<?php echo (isset($options['speechy_id_key']) && $options['speechy_id_key'] != '') ? $options['speechy_id_key'] : ''; ?>" placeholder="" /></td>
		</tr>
		<tr>
			<td><label for="key"><?php echo __("Secret key" , "speechy"); ?></label></td>
			<td><input type="text" id="speechy_secret_key" class="" name="speechy_settings[speechy_secret_key]" value="<?php echo (isset($options['speechy_secret_key']) && $options['speechy_secret_key'] != '') ? $options['speechy_secret_key'] : ''; ?>" placeholder="" /></td>
		</tr>
	</table>

	
<?php if(isset($options['speechy_id_key']) && $options['speechy_id_key'] != ''){ ?>

	<h3><?php echo __("Speechy Settings" , "speechy"); ?></h3>
	
	<?php $position = (isset($options['position']) && $options['position'] != '') ? $options['position'] : 'Before'; ?>
	
	<table>
		<tr>
			<td><label><?php echo __("Player position" , "speechy"); ?></label></td>
			<td>
				<select name="speechy_settings[position]">
					<option value="Before" <?php if($position== 'Before') { echo "SELECTED";} ?>>Before the post content</option>
					<option value="After" <?php if($position== 'After') { echo "SELECTED";} ?>>After the post content</option>
				</select>
			</td>
		</tr>
	</table>
	
	<?php $voice = (isset($options['voice']) && $options['voice'] != '') ? $options['voice'] : ''; ?>
	
	<table>
		<tr>
			<td>
				<label for="speech_voice"><?php echo __("Default voice" , "speechy"); ?></label>
				(<?php echo __("It can later be changed on the post edit page" , "speechy"); ?>)<br />
				You can listen to voice examples <a href="?page=speechy-plugin&tab=voice_samples">here</a>
			</td>
			<td>
				<select name="speechy_settings[voice]">
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
						<option value="Conchita" <?php if($voice== 'Conchita') { echo "SELECTED";} ?>>Conchita - Mujer - ES</option>
						<option value="Enrique" <?php if($voice== 'Enrique') { echo "SELECTED";} ?>>Enrique - Hombre - ES</option>
					  </optgroup>
					  <optgroup label="Français (fr-FR)">
						<option value="Celine" <?php if($voice== 'Celine') { echo "SELECTED";} ?>>Céline - Femme - FR</option>
						<option value="Mathieu" <?php if($voice== 'Mathieu') { echo "SELECTED";} ?>>Mathieu - Homme - FR</option>
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
			</td>
		</tr>
	</table>

	<?php $process_custom_audio = (isset($options['process_custom_audio']) && $options['process_custom_audio'] != '') ? $options['process_custom_audio'] : ''; ?>
	
	<table>
		<tr>
			<td>
				<label for="speech_voice"><?php echo __("Default prepend welcome or sponsorship message" , "speechy"); ?>*</label>
			</td>
			<td>
				<select name="speechy_settings[process_custom_audio]">
					<option value="0" <?php if( $process_custom_audio== "0" ) { echo "SELECTED";} ?>>No MP3 added</option>
					<?php
						$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
						$list = $speechyApi->getMp3List();
						$list = $list['data']['mp3list'];
					foreach ( $list as $mp3 ) {
						?>
						<option value="<?php echo $mp3['id']; ?>" <?php if( $process_custom_audio== $mp3['id'] ) { echo "SELECTED";} ?>><?= $mp3['name']; ?></option>
						<?php
					}
					?>
				</select>
				<p>Upload a <a href="?page=speechy-plugin&tab=mp3prepend">new MP3</a>.</p>
			</td>
		</tr>
		<tr>
			<td colspan="2">* This message will be played before the main audio file.<br />You can select another message on the post edit page, or just choose to write the message on a normal text field.</td>
		</tr>
	</table>

	<?php $speechy_itunes_image = (isset($options['speechy_itunes_image']) && $options['speechy_itunes_image'] != '') ? $options['speechy_itunes_image'] : ''; ?>
	
	<h3><?php echo __("Speechy Podcast" , "speechy"); ?></h3>
	
	<p>Speechy podcast RSS: <a href="<?= site_url(); ?>/feed/speechy" target="_blank"><?= site_url(); ?>/feed/speechy</a></p>

	<p>Submit your Speechy podcast to iTunes iConnect here: <a href="https://podcastsconnect.apple.com/" target="_blank">https://podcastsconnect.apple.com/</a></p>
	<table>
		<tr>
			<td>
				<label for="player-bg-image"><?php  echo __("Itunes Image" , "speechy"); ?></label>
				<?php echo __("Suggested dimensions","speechy"); ?>: 1400 by 1400 pixels.
			</td>
			<td>
				<div class="show_speechy_itunes_image">
					<?php
					if($speechy_itunes_image != "") { echo "<img src='".$speechy_itunes_image."' style='height: 100px' />";}
					?>
				</div>
				<input type="hidden" class="speechy_itunes_image_value" name="speechy_settings[speechy_itunes_image]" value="<?= $speechy_itunes_image; ?>">
				<input type="button" class="set_speechy_itunes_image button" value="<?php if($speechy_itunes_image != "") { echo "Change"; }else{ echo "Set"; } ?> Itunes Image" name="speechy_settings[speechy_itunes_image]">
				<?php if($speechy_itunes_image != "") echo "<span class='delete_speechy_itunes_image'>Remove image</span>"; ?>
			</td>
		</tr>
		
		<?php $speechy_itunes_category = (isset($options['speechy_itunes_category']) && $options['speechy_itunes_category'] != '') ? $options['speechy_itunes_category'] : ''; ?>
		<tr>
			<td>
				<label for="speechy_itunes_category"><?php  echo __("Itunes Category" , "speechy"); ?></label>
			</td>
			<td>
				<select name="speechy_settings[speechy_itunes_category]" id="speechy_itunes_category">
					<option value="Arts" <?php if($speechy_itunes_category == "Arts"){ echo "SELECTED";} ?> >Arts</option>
					<option value="Business" <?php if($speechy_itunes_category == "Business"){ echo "SELECTED";} ?>>Business</option>
					<option value="Comedy" <?php if($speechy_itunes_category == "Comedy"){ echo "SELECTED";} ?>>Comedy</option>
					<option value="Education" <?php if($speechy_itunes_category == "Education"){ echo "SELECTED";} ?>>Education</option>
					<option value="Games &amp; Hobbies" <?php if($speechy_itunes_category == "Games &amp; Hobbies"){ echo "SELECTED";} ?>>Games &amp; Hobbies</option>
					<option value="Government &amp; Organizations" <?php if($speechy_itunes_category == "Government &amp; Organizations"){ echo "SELECTED";} ?>>Government &amp; Organizations</option>
					<option value="Health" <?php if($speechy_itunes_category == "Health"){ echo "SELECTED";} ?>>Health</option>
					<option value="Kids" <?php if($speechy_itunes_category == "Kids"){ echo "SELECTED";} ?>>Kids</option>
					<option value="Music"<?php if($speechy_itunes_category == "Music"){ echo "SELECTED";} ?> >Music</option>
					<option value="News &amp; Politics"<?php if($speechy_itunes_category == "News &amp; Politics"){ echo "SELECTED";} ?> >News &amp; Politics</option>
					<option value="Religion" <?php if($speechy_itunes_category == "Religion"){ echo "SELECTED";} ?>>Religion</option>
					<option value="Science &amp; Medicine" <?php if($speechy_itunes_category == "Science &amp; Medicine"){ echo "SELECTED";} ?>>Science &amp; Medicine</option>
					<option value="Society &amp; Culture" <?php if($speechy_itunes_category == "Society &amp; Culture"){ echo "SELECTED";} ?>>Society &amp; Culture</option>
					<option value="Sports &amp; Recreation" <?php if($speechy_itunes_category == "Sports &amp; Recreation"){ echo "SELECTED";} ?>>Sports &amp; Recreation</option>
					<option value="Technology" <?php if($speechy_itunes_category == "Technology"){ echo "SELECTED";} ?>>Technology</option>
					<option value="TV &amp; Film" <?php if($speechy_itunes_category == "TV &amp; Film"){ echo "SELECTED";} ?>>TV &amp; Film</option>
				</select>
			</td>
		</tr>
		
		<?php $speechy_itunes_email = (isset($options['speechy_itunes_email']) && $options['speechy_itunes_email'] != '') ? $options['speechy_itunes_email'] : ''; ?>
		<tr>
			<td>
				<label for="speechy_itunes_email"><?php  echo __("iTunes contact email" , "speechy"); ?></label>
				
			</td>
			<td>
				<input type="text" id="speechy_itunes_email" class="" name="speechy_settings[speechy_itunes_email]" value="<?php echo (isset($options['speechy_itunes_email']) && $options['speechy_itunes_email'] != '') ? $options['speechy_itunes_email'] : ''; ?>" placeholder="" />
			</td>
		</tr>
		
		<?php $speechy_itunes_explicit = (isset($options['speechy_itunes_explicit']) && $options['speechy_itunes_explicit'] != '') ? $options['speechy_itunes_explicit'] : 'No'; ?>
		<tr>
			<td>
				<label for="speechy_itunes_explicit"><?php  echo __("iTunes explicit content" , "speechy"); ?></label>
				
			</td>
			<td>
				<select name="speechy_settings[speechy_itunes_explicit]" id="speechy_itunes_explicit">
					<option value="yes" <?php if($speechy_itunes_explicit == "yes"){ echo "SELECTED";} ?>>Yes</option>
					<option value="clean" <?php if($speechy_itunes_explicit == "clean"){ echo "SELECTED";} ?>>Clean</option>
					<option value="no" <?php if($speechy_itunes_explicit == "no"){ echo "SELECTED";} ?>>No</option>
				</select>
			</td>
		</tr>
	</table>
	
<?php } else { ?>
		<h3>How to sign up with Speechy?</h3>
		<p>To make speechy work properly, you need to:</p>
		<ol>
			<li>Create an account by <a href='javascript:void()' onclick='openPortal(function(msg){ document.getElementById("updated-msg").innerHTML = msg; });'><?php echo __("Sign up for a free plan here" , "speechy"); ?></a>. A popup will open. Click on the Sign up button and fill the form</li>
			<li>After signing up, a confirmation email will be sent to your email adress. Open this email and click the confirmation link you will find inside.</li>
			<li>Then, you can sign in through same the popup window you used to sign up.</li>
			<li>After sign in, you will have access to your ID key and Secret key. Copy/paste those keys in your Speechy settings page (the two fields above).</li>
			<li>Success! You are now registered for a free plan. If you reach the MP3 limits, you can upgrade to a pay plan if you want to.</li>
		</ol>
<?php } ?> 
	<?php submit_button(); ?>
</form>