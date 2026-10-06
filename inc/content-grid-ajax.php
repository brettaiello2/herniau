<?php
/**
 * AJAX Load More Posts Handler
 *
 * Handles "Load More" button AJAX requests for any post type,
 * and includes full sorting logic (published_date, recorded_on, menu_order),
 * plus the event-specific override.
 */

function mytheme_ajax_loadmore_posts() {

    // Incoming values
    $paged          = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $post_type      = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 10;

    // NEW: incoming sort_by, sent from the Load More button
    $sort_by        = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'menu_order';

    // Optional taxonomy filters
    $taxonomy       = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : '';
    $term           = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';

    // Base query args
    $args = array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
    );

    // Taxonomy filtering (if any)
    if ($taxonomy && $term) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $term,
            ),
        );
    }

    /**
     * ---------------------------
     * Sorting Logic (Matches Main Grid)
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
     * Always overrides any sorting above.
     * ---------------------------
     */
    if ($post_type === "event") {
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

    /**
     * ---------------------------
     * Run Query
     * ---------------------------
     */
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ob_start();

        while ($query->have_posts()) : $query->the_post();

            // Template selection based on post type
            if ($post_type === "event") {
                include get_template_directory() . '/template-parts/content-item-event.php';

            } elseif ($post_type === "instructor") {
                include get_template_directory() . '/template-parts/content-item-instructor.php';

            } elseif ($post_type === "ihs") {
                include get_template_directory() . '/template-parts/content-item-ihs.php';

            } else {
                include get_template_directory() . '/template-parts/content-item-general.php';
            }

        endwhile;

        echo ob_get_clean();
    endif;

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_loadmore_posts', 'mytheme_ajax_loadmore_posts');
add_action('wp_ajax_nopriv_loadmore_posts', 'mytheme_ajax_loadmore_posts');
