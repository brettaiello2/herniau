<?php
/**
 * Template Name: Custom Podcast Feed
 */

header('Content-Type: application/rss+xml; charset=UTF-8');

// Query all podcast posts
$args = array(
    'post_type'      => 'podcast',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$feed_query = new WP_Query($args);

// Channel metadata
$channel_title       = "HerniaU Podcast";
$channel_link        = home_url('/podcasts/herniau-podcast/');
$channel_description = "Doctors from around the world talk about their experiences in and out of the operating room";
$channel_language    = "en-US";
$channel_author      = "Hernia U";
$channel_email       = "support@herniau.com";
$copyright           = "© " . date("Y") . " Hernia U";

// Pull the "thumbnail" ACF field from the latest podcast post (or site-wide setting)
$thumbnail = null;
if ($feed_query->have_posts()) {
    $feed_query->the_post();
    $thumbnail = get_field('thumbnail', get_the_ID());
    wp_reset_postdata();
}
$thumbnail_url = $thumbnail && isset($thumbnail['url']) ? $thumbnail['url'] : '';
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
    xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
    xmlns:googleplay="http://www.google.com/schemas/play-podcasts/1.0"
    xmlns:podcast="https://podcastindex.org/namespace/1.0"
>
<channel>
    <title><?php echo esc_html($channel_title); ?></title>
    <atom:link href="<?php echo esc_url(home_url('/custom-podcast-feed/')); ?>" rel="self" type="application/rss+xml"/>
    <link><?php echo esc_url($channel_link); ?></link>
    <description><![CDATA[<?php echo $channel_description; ?>]]></description>
    <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
    <language><?php echo $channel_language; ?></language>
    <copyright><?php echo esc_html($copyright); ?></copyright>
    <itunes:subtitle>Doctors and Medical Professionals talking about hernia surgeries</itunes:subtitle>
    <itunes:author><?php echo esc_html($channel_author); ?></itunes:author>
    <itunes:type>episodic</itunes:type>
    <itunes:summary><![CDATA[<?php echo $channel_description; ?>]]></itunes:summary>
    <itunes:owner>
        <itunes:name><?php echo esc_html($channel_author); ?></itunes:name>
        <itunes:email><?php echo esc_html($channel_email); ?></itunes:email>
    </itunes:owner>
    <itunes:explicit>false</itunes:explicit>
    <itunes:category text="Education"/>
    <itunes:category text="Health &amp; Fitness">
        <itunes:category text="Medicine"/>
    </itunes:category>
    <podcast:guid><?php echo wp_generate_uuid4(); ?></podcast:guid>
    <generator>WordPress Custom Feed</generator>

    <?php if ($thumbnail_url): ?>
        <itunes:image href="<?php echo esc_url($thumbnail_url); ?>" />
        <image>
            <url><?php echo esc_url($thumbnail_url); ?></url>
            <title><?php echo esc_html($channel_title); ?></title>
            <link><?php echo esc_url($channel_link); ?></link>
        </image>
    <?php endif; ?>

<?php while ($feed_query->have_posts()): $feed_query->the_post(); ?>
    <?php
        $post_id   = get_the_ID();
        $title     = get_the_title();
        $link      = get_permalink();
        $pubDate   = get_the_date('D, d M Y H:i:s +0000');
        $author    = get_the_author();
        $guid      = get_permalink($post_id);

        // ACF fields
        $audio_url = get_field('audio_file', $post_id);
        $duration  = get_field('duration', $post_id);

        // Try to get filesize if local
        $filesize = 0;
        if ($audio_url) {
            $file_path = wp_parse_url($audio_url, PHP_URL_PATH);
            $abs_path  = ABSPATH . ltrim($file_path, '/');
            if (file_exists($abs_path)) {
                $filesize = filesize($abs_path);
            }
        }

        // Excerpt + content with fallback
        $excerpt = get_the_excerpt();
        $content = apply_filters('the_content', get_the_content());
        if (empty($excerpt)) {
            $excerpt = wp_trim_words(wp_strip_all_tags($content), 40, '...');
        }
    ?>
    <item>
        <title><![CDATA[<?php echo $title; ?>]]></title>
        <link><?php echo esc_url($link); ?></link>
        <pubDate><?php echo $pubDate; ?></pubDate>
        <dc:creator><![CDATA[<?php echo $author; ?>]]></dc:creator>
        <guid isPermaLink="false"><?php echo esc_url($guid); ?></guid>

        <description><![CDATA[<?php echo $excerpt; ?>]]></description>
        <itunes:subtitle><![CDATA[<?php echo $excerpt; ?>]]></itunes:subtitle>
        <content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
        <?php if ($audio_url): ?>
            <enclosure url="<?php echo esc_url($audio_url); ?>"
                       length="<?php echo esc_attr($filesize); ?>"
                       type="audio/mpeg" />
        <?php endif; ?>
        <itunes:summary><![CDATA[<?php echo $excerpt; ?>]]></itunes:summary>
        <itunes:explicit>false</itunes:explicit>
        <itunes:block>no</itunes:block>
        <?php if ($duration): ?>
            <itunes:duration><?php echo esc_html($duration); ?></itunes:duration>
        <?php endif; ?>
        <itunes:author><![CDATA[<?php echo $author; ?>]]></itunes:author>
        <googleplay:explicit>No</googleplay:explicit>
        <googleplay:block>no</googleplay:block>
    </item>
<?php endwhile; wp_reset_postdata(); ?>

</channel>
</rss>
