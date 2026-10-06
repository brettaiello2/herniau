<?php
/**
 * Template Name: TEMP Duration
 *  Template Post Type: page
 *
 */
get_header();
?>


<?php
$videos = new WP_Query([
    'post_type' => 'video', 
    'posts_per_page' => -1
]);

while ($videos->have_posts()) : $videos->the_post();
    $video_id = get_field('brightcove_id');
    ?>

    <div style="margin-bottom: 40px;">
      <video-js
        data-video-id="<?php echo $video_id; ?>"
        data-account="81909694001"
        data-player="rxDeY9XEJ"
        data-embed="default"
        class="video-js"
        controls
        id="brightcove-<?php echo get_the_ID(); ?>"
      ></video-js>
    </div>

    <?php
endwhile;
wp_reset_postdata();
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof videojs !== 'undefined') {
      const players = document.querySelectorAll('.video-js');
      players.forEach(function(playerEl) {
        const player = videojs(playerEl);
        player.on('loadedmetadata', function() {
          const duration = player.duration();
          const postId = playerEl.id.replace('brightcove-', '');
          console.log('Duration for post ' + postId + ':', duration);

          fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
              action: 'save_video_duration',
              post_id: postId,
              duration: duration
            })
          });
        });
      });
    } else {
      console.error('videojs is not defined');
    }
  });
</script>


<?php get_footer(); ?>