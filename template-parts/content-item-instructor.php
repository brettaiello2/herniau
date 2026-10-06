<article <?php post_class("content-item"); ?> id="post-<?php the_ID(); ?>">

<?php
$post_id = get_the_ID();

$first_name      = get_field('first_name', $post_id);
$last_name       = get_field('last_name', $post_id);
$med_credentials = get_field('med_credentials', $post_id);
$intro           = get_field('short_bio', $post_id);
$intro_trimmed   = wp_trim_words( wp_strip_all_tags($intro), 20, '...' );
$headshot        = get_field('photo', $post_id);

// Fallback image if no headshot
if ($headshot && isset($headshot['sizes']['medium'])) {
    $headshot_url = $headshot['sizes']['medium'];
} else {
    $headshot_url = '/wp-content/uploads/2025/08/Coming-Soon-HU.png';
}

?>

    <div class="thumb">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($headshot_url); ?>" alt="<?php echo esc_attr(trim("$first_name $last_name $med_credentials")); ?>" />
        </a>
    </div>

    <div class="body">
        <h3 class="post-title">
            <a href="<?php the_permalink(); ?>">
                <?php echo esc_html(get_the_title()); ?> <?php echo esc_html($med_credentials); ?>
            </a>
        </h3>
        <?php //echo $intro_trimmed; ?>
    </div>

</article>

