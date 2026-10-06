<?php
$paged = max(1, get_query_var('paged') ?: get_query_var('page'));


$args = array(
    'post_status'     => 'publish',
    'post_type'       => array('podcast'),
    'posts_per_page'  => 6,
    'orderby'         => 'menu_order',
    'order'           => 'ASC',
    'paged'           => $paged,
);
$podcast_query = new WP_Query($args);
?>

<?php if ($podcast_query->have_posts()) : ?>

    <div class="main-podcast-feed">

        <?php 
        $player_index = 0;
        $audio_list = [];
        ?>

        <?php while ($podcast_query->have_posts()) : $podcast_query->the_post(); ?>
            <?php 
                $pod_id = get_the_ID();
                $audio_file = get_field('audio_file', $pod_id); 
                $thumbnail = get_field('thumbnail', $pod_id);
                $description = get_field('description', $pod_id);
                $title = get_the_title($pod_id);
                $more_info = get_field('additional_podcast_information',$pod_id);
                $podcaster = get_field('podcaster_names',$pod_id);
                $gated = get_field('gated',$pod_id);

                $container_id = 'podcast-player-' . $player_index;

                $audio_list[] = array(
                    'id' => $container_id,
                    'title' => esc_js($title),
                    'src' => esc_url($audio_file),
                    'cover' => esc_url($thumbnail['sizes']['medium']),
                    'podcaster' => $podcaster,
                );

                $player_index++;
            ?>

            <div class="podcast-item">

            <?php if($gated && !is_user_logged_in()): ?>

            <div class="gated-overlay">
                This content is restricted for non-members
            </div>

            <?php endif; ?>

                <div id="<?php echo esc_attr($container_id); ?>" class="podcast-player-container"></div>
            </div>

        <?php endwhile; ?>

    </div>

    <!-- Pagination -->
<div class="pagination">
    <?php
    echo paginate_links(array(
        'base'      => add_query_arg('paged', '%#%'),
        'format'    => '',
        'current'   => $paged,
        'total'     => $podcast_query->max_num_pages,
        'prev_next' => false, 
        'type'      => 'list'
    ));
    ?>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const audioList = <?php echo json_encode($audio_list); ?>;
            const players = [];

            audioList.forEach(function(audioItem) {
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

                players.push(player);
            });

            players.forEach(function(currentPlayer) {
                currentPlayer.audio.onplay = function() {
                    players.forEach(function(otherPlayer) {
                        if (otherPlayer !== currentPlayer) {
                            otherPlayer.audio.pause();
                        }
                    });
                };
            });
        });
    </script>

<?php endif; ?>

<?php wp_reset_postdata(); ?>
