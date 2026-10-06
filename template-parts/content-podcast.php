<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php $featured_image = get_the_post_thumbnail_url(null, 'full'); ?>

<input type="hidden" id="background-image" value="<?php echo esc_url($featured_image); ?>">

<div class="page-hero">
<div class="container">


	<?php
	    $pod_id = get_the_ID();
	    $audio_file = get_field('audio_file'); 
	    $thumbnail = get_field('thumbnail');
	    $description = get_field('description');
	    $title = get_the_title();
	    $more_info = get_field('additional_podcast_information');
	    $podcaster = get_field('podcaster_names');
	    $gated = get_field("gated");

	    $container_id = 'main-podcast';

	    $audio_item = array(
	        'id' => $container_id,
	        'title' => esc_js($title),
	        'src' => esc_url($audio_file),
	        'cover' => esc_url($thumbnail['sizes']['medium']),
	        'podcaster' => $podcaster,
	    );
	?>

<div class="podcast-item" style="margin: 10em 0 4em;">

	        <?php if($gated && !is_user_logged_in()): ?>

            <div class="gated-overlay">
				This content is restricted for non-members
            </div>

        	<?php endif; ?>

    <div id="main-podcast" class="podcast-player-container"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const audioItem = <?php echo json_encode($audio_item); ?>;

    const player = new Shikwasa.Player({
        container: document.getElementById(audioItem.id),
        themeColor: '#000000',
        audio: {
            title: audioItem.title,
            artist: audioItem.podcaster,
            cover: audioItem.cover,
            src: audioItem.src,
        },
        controls: [
            'play', 
            'progress', 
            'time', 
            'volume', 
            'loop',
            'download',
            'mute'
        ]
    });
});
</script>

</div>
</div>


<div class="entry-content">
<div class="container">
<h1 class="wp-block-heading mb-4"><?php echo get_the_title(); ?></h1>

<?php echo get_field("additional_podcast_information"); ?>

</div>
</div>

	
</article>
