=== Speechy ===
Contributors: speechy, nicozz
Stable tag: 1.0
Tested up to: 4.9
Requires at least: 4.6

Create high-quality audio versions of your WordPress blog posts with Speechy.
Start for free and upgrade as you grow!

== Description ==

Speechy is a WordPress plugin that uses the world’s best text-to-speech software, Amazon Polly, to automatically create impressive MP3 versions of your blog posts.

== Installation ==

= Install & Activate =

Installing the plugin is easy. Just follow these steps:

1. From the dashboard of your site, navigate to Plugins --> Add New.
2. Select the Upload option and hit "Choose File."
3. When the popup appears select the speechy-x.x.zip file from your desktop. (The 'x.x' will change depending on the current version number).
4. Follow the on-screen instructions and wait as the upload completes.
5. When it's finished, activate the plugin via the prompt. A message will show confirming activation was successful. A link to access the calendar directly on the frontend will be presented here as well.

== How to use Speechy ? ==

= 1. Sign up with Speechy =

In order to make Speechy convert your posts into MP3 files and host them on Amazon Cloud on a bucket created for you, you will need to sign up.

	1) Go to the setting pages here: Settings -> Speechy.
	2) Click on the link "Sign up for a free plan here" to open the Sign up pop-up window,
	3) Click on the Sign Up button
	4) Enter your Full Name, Email address, Website Url and a Password. Then click on the signup button.
	
= 2. Confirm your email address =
	1) After signup, you will receive an email to confirm your newly created account.
	2) Open the email and click on the "Verify Email" link. A new tab will open saying that your email has been confirmed.
	3) , you can now use the popup login window to log in.
	
= 3. Login to your Speechy account =

You can now use the popup login window to log in, with your Email address and Password.

= 4. Copy/paste your private keys =
	1) When logged inside the popup window, you will see your information and also two keys: ID key and Secret key.
	2) Copy/paste those keys inside your speechy settings page, select a voice from the drop-down menu below, and your done!

= 5. Select your prefered voice/language =
	
Inside the "Voice/Language", look for your langauge and select your prefered voice (male or female).

= 6. On the post edit page (optional) =

	1) Adapt your content to audio version: on the post edit page, by default, Speechy will use your main content. But if you need to adapt your content to an audio version, inside the Speechy optional setting, you can change your post content. If this texte area is not empty, speechy will use its content to create the audio version.
	2) Select a voice for a specific post: on the post edit page, inside the Speechy optional setting, you can also change the default voice using the drop down menu.

== Changelog ==

= 1.6.1 =
* Changing icon path for speechy on the MP3 player.
* CSS changes

= 1.6 =
* CSS modifications
* Voices updated on the dropdown list.

= 1.5 =
* Change in the file that look for the MP3 to show the player.

= 1.4 =
* Url changes for the speechy icon.

= 1.3 =
* Small changes in the css for download link
* Callback url issue fixed

= 1.2 =
* processing post content to avoid shortcodes ad other codes in the content
* positionning download icon.

= 1.1 =
* some css changes on the MP3 player.

= 1.0 =
* added the monthly conversion limits
* added logo and alt tag to the front page MP3 player.

= 0.9.3 =
* added the download icon to the player
* Modal Popup added

= 0.9.2 =
* new file created voice_samples.php
* changes in speechy_settings.php
* changes in speechy_how_to.php
* small changes in style_backend.css

= 0.9.1 =
* Explanation added to the settings page about how to sinup with Speechy.
* Default voice changed from Amy to Johanna.

= 0.9 =
* Important change: MP3 files are now created in the background. When done, Amazon send back the response and the database is updated.
* find mp3 file updated accordingly
* Added download icon to the downlosd link
* Payment info presented in a table
* Added a "Need Help" section in the settings page
* Create audio success message changed
* readme.txt file content updated.

= 0.8.1 =
* Added github uploader

= 0.8 =
* Added parsedown.php

= 0.7 =
* MP3 will be created by delayed process.
* MP3 will only be created when post is created or updated. Not on draft
* If checkbox is checked, MP3 will not be created.