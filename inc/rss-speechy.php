<?php
/**
 * Template Name: Custom RSS Template - speechy
 */
 
$postCount = 20; // The number of posts to show in the feed
$posts = query_posts('showposts=' . $postCount);
header('Content-Type: ' . feed_content_type('rss2') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

$plugins_url = plugins_url();

// Site infos
$site_title = get_bloginfo( 'name' );
$site_url = network_site_url( '/' );
$site_description = get_bloginfo( 'description' );
$admin_email = get_bloginfo( 'admin_email' );
// END Site infos

// Speechy Itunes default image
$speechy_itunes_default_image = $site_url . "images/speechy_logo_1400x1400px.jpg";

// Player options
$options = get_option( 'speechy_settings' );

$speechy_itunes_image = (isset($options['speechy_itunes_image']) && $options['speechy_itunes_image'] != '') ? $options['speechy_itunes_image'] : $speechy_itunes_default_image;
$speechy_itunes_category = (isset($options['speechy_itunes_category']) && $options['speechy_itunes_category'] != '') ? $options['speechy_itunes_category'] : '';
$speechy_itunes_email = (isset($options['speechy_itunes_email']) && $options['speechy_itunes_email'] != '') ? $options['speechy_itunes_email'] : $admin_email;
$speechy_itunes_explicit = (isset($options['speechy_itunes_explicit']) && $options['speechy_itunes_explicit'] != '') ? $options['speechy_itunes_explicit'] : 'No';
// END Player options

// Get copyright
/*public function get_copyright() {
		$all_posts  = get_posts( 'post_status=publish&order=ASC' );
		$first_post = $all_posts[0];
		$first_date = $first_post->post_date_gmt;

		$copyright = 'Copyright &copy; ';
		if ( substr( $first_date, 0, 4 ) === date( 'Y' ) ) {
			$copyright .= date( 'Y' );
		} else {
			$copyright .= substr( $first_date, 0, 4 ) . '-' . date( 'Y' );
		}
		$copyright .= ' ' . get_bloginfo( 'name' );

		$copyright = $this->filter_force_html_decode( $copyright );
		return $copyright;
}*/
// END Get copyright
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

/**
 * Fires between the xml and rss tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"

	<?php
	/**
	 * Fires at the end of the RSS root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_ns' );
	?>

<channel>
	<title><?php wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url'); ?></link>
	<description><?php bloginfo_rss("description"); ?></description>
	<image>
		<url><?= $speechy_itunes_image; ?></url>
		<title><?php wp_title_rss(); ?></title>
		<link><?= $site_url; ?></link>
	</image>
	<itunes:owner>
		<itunes:name><?= $site_title; ?></itunes:name>
		<itunes:email><?= $speechy_itunes_email; ?></itunes:email>
	</itunes:owner>
	<itunes:category text="Business"></itunes:category>
	<itunes:explicit><?= $speechy_itunes_explicit; ?></itunes:explicit>
	<itunes:image href="<?= $speechy_itunes_image; ?>"/>
	<itunes:author><?= $site_title; ?></itunes:author>
	<itunes:summary><?php bloginfo_rss("description"); ?></itunes:summary>
	<itunes:subtitle><?php bloginfo_rss("description"); ?></itunes:subtitle>
	<copyright></copyright>
	<lastBuildDate><?php
		$date = get_lastpostmodified( 'GMT' );
		echo $date ? mysql2date( 'r', $date, false ) : date( 'r' );
	?></lastBuildDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<sy:updatePeriod><?php
		$duration = 'hourly';

		/**
		 * Filters how often to update the RSS feed.
		 *
		 * @since 2.1.0
		 *
		 * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
		 *                         'yearly'. Default 'hourly'.
		 */
		echo apply_filters( 'rss_update_period', $duration );
	?></sy:updatePeriod>
	<sy:updateFrequency><?php
		$frequency = '1';

		/**
		 * Filters the RSS update frequency.
		 *
		 * @since 2.1.0
		 *
		 * @param string $frequency An integer passed as a string representing the frequency
		 *                          of RSS updates within the update period. Default '1'.
		 */
		echo apply_filters( 'rss_update_frequency', $frequency );
	?></sy:updateFrequency>
	<?php
	/**
	 * Fires at the end of the RSS2 Feed Header.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_head');

	while( have_posts()) : the_post();
	
	global $post;
	$post_id = get_the_ID();
		//$audio_file      = $amazon_pollycast->get_audio_file_location( get_the_ID() );
		//$categories_list = $amazon_pollycast->get_itunes_categories( get_the_ID() );
		$audio_file = get_post_meta( $post_id, 'mp3_url', true );
	?>
		<item>
			<title><?php the_title_rss(); ?></title>
			<link><?php echo esc_url( $audio_file ); ?></link>
			<pubDate><?php echo esc_html( mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false ) ); ?></pubDate>
			<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
			<enclosure url="<?php echo esc_url( $audio_file ); ?>" length="0" type="audio/mpeg"/>
			<guid><?php the_guid(); ?></guid>
			<itunes:author><![CDATA[<?php the_author(); ?>]]></itunes:author>
			<itunes:summary><![CDATA[<?php the_excerpt_rss(); ?>]]></itunes:summary>
			<itunes:keywords><![CDATA[<?= $speechy_itunes_category; ?>]]></itunes:keywords>
			<itunes:explicit><?= $speechy_itunes_explicit; ?></itunes:explicit>
		</item>
	<?php endwhile; ?>
</channel>
</rss>
