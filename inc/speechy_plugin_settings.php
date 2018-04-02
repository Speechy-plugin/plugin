<?php

// Retrieve plugin settings
$options = get_option( 'speechy_settings' );
define ('SPEECHY_OPTIONS', $url);
$options_player = get_option( 'player_settings' );

// setting page url
$admin_url = admin_url();
$url = $admin_url . "/options-general.php?page=speechy-plugin"; 
define ('SETTING_PAGE_URL', $url);

// Licence settings
$speechy_id_key = $options['speechy_id_key'];
$speechy_secret_key = $options['speechy_secret_key'];

define('ID_KEY', $speechy_id_key); // id_key will be here.
define('SECRET_KEY', $speechy_secret_key); // secret_key will be here.

// Voice setting
$speechy_voice = $options['voice'];
$speechy_voice != "" ? $speechy_voice : "Joanna";
define('VOICE', $speechy_voice);

// Ad setting.
$speechy_ad = $options['process_custom_audio'];
$speechy_ad != "" ? $speechy_ad : "0";
define('SPEECHY_AD', $speechy_ad);

// ** SpeechyAPi
$speechyApi = new SpeechyAPi(ID_KEY, SECRET_KEY);
$resp = $speechyApi->getUsage();

// Plan limits.
define('HOSTINGLIMIT', $resp['data']['mp3Limit']);
define('BANDWIDTHLIMIT', $resp['data']['hitLimit']);
define('MP3UPDATELIMIT', $resp['data']['mp3UpdateLimit']);
define('MP3PREPENDLIMIT', $resp['data']['mp3PrependLimit']);
