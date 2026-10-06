<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package herniau
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */




// CUSTOM POST ORDER
function wpse_custom_menu_order( $menu_ord ) {
    return array(
        'index.php',
        'upload.php',
        'separator1',
        'edit.php',
        'edit.php?post_type=page',
        'edit.php?post_type=video',
        'edit.php?post_type=lecture',
        'edit.php?post_type=podcast',
        'edit.php?post_type=ihs',
        'edit.php?post_type=instructor',
        'separator2',
        'learndash-lms',
        'ultimatemember',
        'edit.php?post_type=event',
        'separator-last',
        'themes.php',
        'plugins.php',
        'users.php',
        'tools.php',
        'options-general.php',
    );
}

function force_custom_menu_order_late() {
    add_filter( 'custom_menu_order', '__return_true' );
    add_filter( 'menu_order', 'wpse_custom_menu_order' );
}
add_action( 'admin_menu', 'force_custom_menu_order_late', 999 );



/**
 * Access controller for restricting certain pages and post types
 */
add_action('template_redirect', 'herniau_access_controller');

function herniau_access_controller() {
    if (is_user_logged_in()) {
        return;
    }

    $current_url = home_url( add_query_arg( null, null ) );

    // Restrict single custom post types
    if (is_singular('sfwd-courses')) {
        wp_redirect( add_query_arg('redirect_to', urlencode($current_url), home_url('/')) );
        exit;
    }

    // Restrict specific pages by slug
    if (is_page(array('my-courses'))) {
        wp_redirect( add_query_arg('redirect_to', urlencode($current_url), home_url('/')) );
        exit;
    }

    // Restrict archive pages for these CPTs
    if (is_post_type_archive('videotemp') || is_post_type_archive('')) {
        wp_redirect( add_query_arg('redirect_to', urlencode($current_url), home_url('/')) );
        exit;
    }
}

/**
 * Ultimate Member login redirect — return to attempted page if set
 */
// add_filter('um_browser_url_redirect_to__filter', function($url) {
//     if ( isset($_GET['redirect_to']) ) {
//         $return_url = esc_url_raw( wp_unslash($_GET['redirect_to']) );
//         if ( !empty($return_url) ) {
//             return $return_url;
//         }
//     }

//     // If logging in from a video or lecture page, stay there
//     if ( is_singular('video') || is_singular('lecture') ) {
//         return get_permalink();
//     }

//     // Default fallback to /welcome
//     return site_url('/welcome/');
// });


/**
 * Redirect logged-in users from front page to /welcome
 */
// add_action('template_redirect', 'redirect_logged_in_users_to_welcome');

// function redirect_logged_in_users_to_welcome() {
//     if (is_front_page() && is_user_logged_in()) {
//         $welcome_url = site_url('/welcome/');

//         if (!is_page('welcome')) {
//             wp_redirect($welcome_url);
//             exit;
//         }
//     }
// }

// add_filter('um_login_redirect_url', function($url, $user_id) {
//     return home_url('/');
// }, 10, 2);


//Add custom body classes for different blocks
add_filter('body_class', function($classes) {
    if (is_singular()) {
        global $post;
        if (has_blocks($post->post_content)) {
            $blocks = parse_blocks($post->post_content);
            foreach ($blocks as $block) {
                if ($block['blockName'] === 'acf/hero-carousel') {
                    $classes[] = 'hero-carousel';
                    break;
                }
            }
        }
    }
    return $classes;
});



// Disable support for comments and trackbacks in post types
function disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Close comments on the front-end
function disable_comments_status() {
    return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Hide existing comments
function disable_comments_hide_existing_comments($comments) {
    return array();
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Redirect any user trying to access comments page
function disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

// Remove comments links from admin bar
function disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'disable_comments_admin_bar');



//Remove Taxonomy Opening Text
add_filter( 'get_the_archive_title', function( $title ) {
    if ( is_category() || is_tag() || is_tax() ) {
        $title = single_term_title( '', false );
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    }
    return $title;
});


//UM Login Form Updates
function your_custom_content_after_login_button( $args ) {
    // Only on login form
    if ( $args['mode'] !== 'login' ) return;
    ?>
   <div class="custom-column">
        <a href="/register" class="register-btn wp-block-button__link">Register</a>
    </div>
    <?php
}
add_action( 'um_after_form', 'your_custom_content_after_login_button' );


function change_um_login_button_text( $button_text ) {
    return 'Sign In';
}
add_filter( 'um_login_form_button_one', 'change_um_login_button_text' );


// Re-enable Categories for Ultimate Member
add_filter('em_ct_categories', 'my_gutenberg_categories_fix');
add_filter('em_ct_tags', 'my_gutenberg_categories_fix');
function my_gutenberg_categories_fix($args) {
  $args['show_in_rest'] = true;
  return $args;
}



// Category Lookup Helper Function
function get_primary_term_html( $post_id = null, array $preferred = [] ) {
    $post = get_post( $post_id );
    if ( ! $post ) return '';

    $type = get_post_type( $post );

    // 1) Build candidate taxonomy list
    $candidates = [];
    if ( isset( $preferred[ $type ] ) ) {
        $candidates = (array) $preferred[ $type ];
    } else {
        // Prefer public, non-builtin taxonomies for this post type
        $tax_objects = get_object_taxonomies( $type, 'objects' );
        foreach ( $tax_objects as $tx ) {
            if ( $tx->public && empty( $tx->_builtin ) ) {
                $candidates[] = $tx->name;
            }
        }
        // Fallback to any taxonomy if none matched the above
        if ( empty( $candidates ) ) {
            $candidates = array_keys( get_object_taxonomies( $type ) );
        }
    }

    // 2) Find the first taxonomy that actually has a term on this post
    foreach ( $candidates as $tx ) {
        $terms = get_the_terms( $post, $tx );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            continue;
        }
        // Use the first term (or sort however you like)
        $term = array_shift( $terms );
        $link = get_term_link( $term );
        if ( ! is_wp_error( $link ) ) {
            return sprintf(
                '<a href="%s">%s</a>',
                esc_url( $link ),
                esc_html( $term->name )
            );
        }
        return esc_html( $term->name );
    }

    return '';
}


function format_video_duration($seconds) {
    if (!is_numeric($seconds)) {
        return $seconds; // return as-is if not valid number
    }

    $hours = floor($seconds / 3600);
    $mins = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;

    if ($hours > 0) {
        return sprintf('%d:%02d:%02d', $hours, $mins, $secs);
    } else {
        return sprintf('%d:%02d', $mins, $secs);
    }
}




function fix_podcasts_static_page_pagination() {
    add_rewrite_rule(
        '^podcasts/page/([0-9]+)/?$',
        'index.php?pagename=podcasts&paged=$matches[1]',
        'top'
    );
}
add_action('init', 'fix_podcasts_static_page_pagination');



/**
 * Limit search results to specific CPTs and exclude past events
 */
function herniau_custom_search_query( $query ) {
    if ( ! $query->is_search() || ! $query->is_main_query() || is_admin() ) {
        return;
    }

    // Allowed post types
    $allowed_post_types = array(
        'video',
        'lecture',
        'podcast',
        'page'
    );

    // Force only public content
    $query->set( 'post_status', array( 'publish' ) );
    $query->set( 'post_type', $allowed_post_types );

    // ✅ Exclude specific page IDs
    $exclude_ids = array( 44078, 1326,964,1118,1116,1122,1114,1110, ); 
    $query->set( 'post__not_in', $exclude_ids );
}
add_action( 'pre_get_posts', 'herniau_custom_search_query' );






/**
 * Auto-fill the ACF search_doctor_field based on the doctors Post Object field.
 */
function herniau_update_search_doctor_field( $post_id ) {

    if ( get_post_type( $post_id ) !== 'lecture' ) {
        return;
    }

    $doctors = get_field( 'doctors', $post_id );

    if ( empty( $doctors ) ) {
        update_field( 'search_doctor_field', '', $post_id );
        return;
    }

    $doctor_ids = is_array( $doctors ) ? $doctors : array( $doctors );

    $names = array();

    foreach ( $doctor_ids as $doc_id ) {
        $names[] = get_the_title( $doc_id );
    }

    $search_string = implode( ', ', $names );

    update_field( 'search_doctor_field', $search_string, $post_id );
}
add_action( 'acf/save_post', 'herniau_update_search_doctor_field', 20 );






/**
 * Course Profile Gate — require Hospital & Training Level before entering a course
 */
define( 'HERNIAU_PROFILE_GATE_SLUG', 'complete-profile' ); // update if your page slug differs
define( 'HERNIAU_GATED_COURSE_SLUGS', array( 'a-z-fundamentals-course-2026' ) ); // add more slugs later as needed

add_action( 'template_redirect', 'herniau_profile_gate_check' );
function herniau_profile_gate_check() {

    if ( ! is_user_logged_in() ) {
        return;
    }
    if ( ! is_singular( 'sfwd-courses' ) ) {
        return;
    }

    global $post;
    if ( ! in_array( $post->post_name, HERNIAU_GATED_COURSE_SLUGS, true ) ) {
        return;
    }
    if ( is_page( HERNIAU_PROFILE_GATE_SLUG ) ) {
        return;
    }

    $user_id        = get_current_user_id();
    $hospital       = get_user_meta( $user_id, 'hospital', true );
    $training_level = get_user_meta( $user_id, 'training_level', true );

    if ( empty( $hospital ) || empty( $training_level ) ) {
        $gate_page = get_page_by_path( HERNIAU_PROFILE_GATE_SLUG );
        if ( ! $gate_page ) {
            return;
        }

        $target = get_permalink( $post );
        set_transient( 'herniau_gate_redirect_' . $user_id, $target, HOUR_IN_SECONDS );

        $redirect = get_permalink( $gate_page );
        $redirect = add_query_arg( 'um_action', 'edit', $redirect );
        $redirect = add_query_arg( 'redirect_to', urlencode( $target ), $redirect );
        wp_redirect( $redirect );
        exit;
    }
}

add_action( 'wp_footer', 'herniau_profile_gate_redirect_script' );
function herniau_profile_gate_redirect_script() {
    if ( ! is_page( HERNIAU_PROFILE_GATE_SLUG ) || ! is_user_logged_in() ) {
        return;
    }

    $user_id     = get_current_user_id();
    $redirect_to = get_transient( 'herniau_gate_redirect_' . $user_id );

    if ( ! $redirect_to && isset( $_GET['redirect_to'] ) ) {
        $redirect_to = esc_url_raw( wp_unslash( $_GET['redirect_to'] ) );
    }
    if ( ! $redirect_to ) {
        return;
    }
    ?>
    <script>
    (function($){
        var redirectTo = <?php echo wp_json_encode( $redirect_to ); ?>;

        function checkComplete(){
            $.post(<?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>, {
                action: 'herniau_check_profile_complete',
                nonce: <?php echo wp_json_encode( wp_create_nonce( 'herniau_profile_gate' ) ); ?>
            }, function(response){
                if (response && response.success && response.data && response.data.complete) {
                    clearInterval(poll);
                    window.location.href = redirectTo;
                }
            });
        }

        checkComplete(); // run once immediately on load
        var poll = setInterval(checkComplete, 700);
    })(jQuery);
    </script>
    <?php
}

add_action( 'wp_ajax_herniau_check_profile_complete', 'herniau_check_profile_complete_ajax' );
function herniau_check_profile_complete_ajax() {
    check_ajax_referer( 'herniau_profile_gate', 'nonce' );
    $user_id  = get_current_user_id();
    $complete = ( ! empty( get_user_meta( $user_id, 'hospital', true ) ) && ! empty( get_user_meta( $user_id, 'training_level', true ) ) );
    if ( $complete ) {
        delete_transient( 'herniau_gate_redirect_' . $user_id );
    }
    wp_send_json_success( array( 'complete' => $complete ) );
}
// 

/**
 * TEMPORARY — one-time meta clear for testing. REMOVE AFTER USE.
 */
// add_action( 'init', function() {
//     $user = get_user_by( 'login', 'brettaiello' );
//     if ( $user ) {
//         delete_user_meta( $user->ID, 'hospital' );
//         delete_user_meta( $user->ID, 'training_level' );
//     }
// });
