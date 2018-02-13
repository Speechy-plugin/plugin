<h2>How to use Speechy</h2>

<h3>Description</h3>

Speechy is a WordPress plugin that uses the world’s best text-to-speech software, Amazon Polly, to automatically create impressive MP3 versions of your blog posts.

<h3>How to use Speechy ?</h3>

<?php if(isset($options['speechy_id_key']) && $options['speechy_id_key'] != ''){ ?>
	<h4>1. Sign up with Speechy</h4>

	<p>In order to make Speechy convert your posts into MP3 files and host them on Amazon Cloud on a bucket created for you, you will need to sign up.</p>

	<ol>
		<li>Go to the setting pages here: Settings -> Speechy.</li>
		<li>Click on the link "Sign up for a free plan here" to open the Sign up pop-up window,</li>
		<li>Click on the Sign Up button</li>
		<li>Enter your Full Name, Email address, Website Url and a Password. Then click on the signup button.</li>
	</ol>
		
	<h4>2. Confirm your email address</h4>
	<ol>
		<li>After signup, you will receive an email to confirm your newly created account.</li>
		<li>Open the email and click on the "Verify Email" link. A new tab will open saying that your email has been confirmed.</li>
		<li> You can now use the popup login window to log in.</li>
	</ol>

	<h4>3. Login to your Speechy account</h4>

	<p>You can now use the popup login window to log in, with your Email address and Password.</p>

	<h4>4. Copy/paste your private keys</h4>

	<ol>
		<li>When logged inside the popup window, you will see your information and also two keys: ID key and Secret key.</li>
		<li>Click on the "Apply Credentials" button to copy/paste them automatically into your key fields, and your done!</li>
	</ol>

<? }else{
?>
	<h4>Select your prefered voice/language</h4>
		
	<p>To select your standart prefered voice, go to the "<a href="?page=speechy-plugin&tab=speechy_settings">Speechy Settings</a>" tab, and below the title "Choose your Voice/Language", select a voice from the drop-down menu (male or female)</p>
	<p>In order to help you to choose the right voice for you, you can also listen to a sample of each voice in the "<a href="?page=speechy-plugin&tab=voice_samples">Voice samples</a>" tab.</p>

	<h4>On the post edit page</h4>

	<ol>
		<li><b>Convert your post content into an MP3 file</b>:<br />To convert your post content into an MP3 file, you just have to write your post using the main text editor, as you normally do. But most of the time, you will have to adapt your post a little...</li>
		<li><b>Adapt your content to audio version:</b><br />on the post edit page, by default, Speechy will use your main content. But if you need to adapt your content to an audio version, inside the Speechy optional setting, you should use the text area called "Speechy text version" to adapt your post content.<br />Be aware that Polly (we use Amazon Polly for text-to-speech conversion) will read your text as is. For example, if you don't put a period at the end of a title, Polly will not make a pause between this title and the following sentence.<br />Also note that if you write content in the "Speechy text version" text area, Speechy will use this content (and not the content within the main text editor) for the MP3 conversion.</li>
		<li><b>Choose a different voice than the default one:</b><br />on the post edit page, inside the Speechy optional setting, if you want, you can also change the default voice that you shoosed on the Speechy settings page using the drop down menu.</li>
		<li><b>Not converting a post into an MP3 file:</b><br />Sometimes, when creating a new post, you don't want to convert the post into an MP3 file (for example for a video). To do so, just check the "Speechy checkbox" checkbox.</li>
	</ol>
	
	<p>And you're done! </p>

	<p>From now on, you can easily convert your posts into MP3 files and give your beloved readers, a new and original way to consume your blog's content.</p>
<?php
} ?>