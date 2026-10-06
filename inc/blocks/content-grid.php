<?php
$title = get_field("title");

// Check for different post types
$post_type = get_field("post_type") ?: "post";

// Get optional block classes
$addClass = array_key_exists('className', $block) ? $block['className'] : "";
?>

<section class="content-grid grid-<?php echo esc_attr($post_type); ?>">

<?php
$paged = 1;
$posts_to_show = get_field("posts_to_show") ?: 10;
$sort_by       = get_field("sort_by") ?: 'menu_order';

// Base query args
$args = array(
    'post_type'      => $post_type,
    'post_status'    => 'publish',
    'posts_per_page' => (int) $posts_to_show,
    'paged'          => $paged,
);

/**
 * ---------------------------
 * Sorting Logic (Matches AJAX)
 * ---------------------------
 */
switch ($sort_by) {

    case 'published_date':
        $args['orderby'] = 'date';
        $args['order']   = 'DESC';
        break;

    case 'recorded_on': // ACF date picker (stored as Ymd)

        // Include posts WITH or WITHOUT this field
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key'     => 'recorded_on',
                'compare' => 'EXISTS',
            ),
            array(
                'key'     => 'recorded_on',
                'compare' => 'NOT EXISTS',
            ),
        );

        $args['meta_key'] = 'recorded_on';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC'; // newest → oldest
        break;

    case 'menu_order':
    default:
        $args['orderby'] = 'menu_order';
        $args['order']   = 'ASC';
        break;
}

/**
 * ---------------------------
 * Event Override Logic
 * Always overrides ANY sorting above.
 * ---------------------------
 */
if ($post_type == "event") {
    $args['meta_query'] = array(
        array(
            'key'     => '_event_start_date',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE',
        ),
    );
    $args['meta_key'] = '_event_start_date';
    $args['orderby']  = 'meta_value';
    $args['order']    = 'ASC';
}

$grid_query = new WP_Query($args);

if ($grid_query->have_posts()) : ?>

    <div class="grid-posts">
        <?php while ($grid_query->have_posts()) : $grid_query->the_post();

            if ($post_type == "event") {
                include get_template_directory() . '/template-parts/content-item-event.php';

            } elseif ($post_type == "instructor") {
                include get_template_directory() . '/template-parts/content-item-instructor.php';

            } elseif ($post_type == "ihs") {
                include get_template_directory() . '/template-parts/content-item-ihs.php';

            } else {
                include get_template_directory() . '/template-parts/content-item-general.php';
            }

        endwhile; ?>
    </div>

    <?php if ($grid_query->max_num_pages > 1) : ?>
        <div class="load-more-cont">
            <button 
                class="load-more"
                data-current-page="1"
                data-max-pages="<?php echo $grid_query->max_num_pages; ?>"
                data-post-type="<?php echo esc_attr($post_type); ?>"
                data-posts-per-page="<?php echo (int) $posts_to_show; ?>"
                data-sort="<?php echo esc_attr($sort_by); ?>" 
            >Load More</button>
        </div>
    <?php endif; ?>

<?php else : ?>

    <div class="no-results">No <?php echo esc_html($post_type); ?> entries found.</div>

<?php endif;

wp_reset_postdata();
?>

</section>

<?php wp_reset_postdata(); ?>
