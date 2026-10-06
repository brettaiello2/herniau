<?php
/**
 * herniau functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package herniau
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function herniau_setup() {


		//Enable Shortcodes Everywhere
		add_filter('the_title', 'do_shortcode');
		add_filter('widget_title', 'do_shortcode');
		add_filter('acf/format_value/type=textarea', 'do_shortcode');
		add_filter('acf/format_value/type=text', 'do_shortcode');
		add_filter('acf/format_value/type=wysiwyg', 'do_shortcode');
		add_filter( 'the_title', 'do_shortcode' );
		add_filter( 'single_post_title', 'do_shortcode' );
		add_filter( 'wpseo_title', 'do_shortcode' );
		add_filter( 'wpseo_metadesc', 'do_shortcode' );
		add_filter( 'wpseo_opengraph_title', 'do_shortcode' );
		add_filter( 'wpseo_opengraph_desc', 'do_shortcode' );
		add_filter( 'wpseo_opengraph_site_name', 'do_shortcode' );
		add_filter( 'wpseo_twitter_title', 'do_shortcode' );
		add_filter( 'wpseo_twitter_description', 'do_shortcode' );
		add_filter( 'the_excerpt', 'do_shortcode' );


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	add_theme_support('core-block-patterns');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main-nav' => esc_html__( 'Main Nav', 'herniau' ),
			'menu-1' => esc_html__( 'Primary', 'herniau' ),
			'footer-1' => esc_html__( 'Footer 1', 'herniau' ),
			'footer-2' => esc_html__( 'Footer 2', 'herniau' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);


}
add_action( 'after_setup_theme', 'herniau_setup' );


//ALLOW SVGS
   function add_file_types_to_uploads($file_types){
        $new_filetypes = array();
        $new_filetypes['svg'] = 'image/svg+xml';
        $file_types = array_merge($file_types, $new_filetypes );
        return $file_types;
    }
    add_action('upload_mimes', 'add_file_types_to_uploads');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function herniau_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'herniau' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'herniau' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'herniau_widgets_init' );

add_action( 'init', function() {
    add_post_type_support( 'page', 'excerpt' );
});


/**
 * Enqueue scripts and styles.
 */
// include custom jQuery
function herniau_jquery() {

	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js', array(), '');

}
add_action('wp_enqueue_scripts', 'herniau_jquery');

function herniau_scripts() {
    // Enqueue styles
    wp_enqueue_style( 'bootstrap-css', '//cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css', [], '5.3.6');
    wp_enqueue_style( 'swiper-css', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0' );
    wp_enqueue_style( 'shikwasa-css', 'https://cdn.jsdelivr.net/npm/shikwasa@2.2.1/dist/style.min.css', [], '2.2.1' );
    wp_enqueue_style( 'os-css', get_template_directory_uri() . '/assets/css/global.css', [], filemtime(get_template_directory() . '/assets/css/global.css') );
    // wp_enqueue_style( 'custom-um-css', get_template_directory_uri() . '/assets/css/custom-um.css', [], filemtime(get_template_directory() . '/assets/css/custom-um.css') );

    // Enqueue scripts
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], '5.1.3', true );
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true );
    wp_enqueue_script( 'shikwasa-js', 'https://cdn.jsdelivr.net/npm/shikwasa@2.2.1/dist/shikwasa.min.js', [], '2.2.1', true );
    wp_enqueue_script( 'brightcove', 'https://players.brightcove.net/81909694001/rxDeY9XEJ_default/index.min.js', [], '2.2.1', true );
    
    wp_enqueue_script( 'global-js', get_template_directory_uri() . '/assets/js/global.js', [ 'jquery' ], filemtime(get_template_directory() . '/assets/js/global.js'), true );  

    // Localize ajax params for global.js
    wp_localize_script( 'global-js', 'ajax_loadmore_params', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
}
add_action( 'wp_enqueue_scripts', 'herniau_scripts' );




add_action( 'wp_print_styles', function () {
    wp_dequeue_style( 'learndash-front-css' );
    wp_deregister_style( 'learndash-front-css' );
}, 9999 );


function admin_scripts() {
  wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/assets/css/admin.css', [], filemtime(get_template_directory() . '/assets/css/admin.css') );
}
add_action('admin_enqueue_scripts', 'admin_scripts');



add_filter( 'learndash_use_block_editor_for_course', '__return_false' );

require get_template_directory() . '/inc/blocks.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/content-grid-ajax.php';
require get_template_directory() . '/inc/weekly-reporting.php';
require get_template_directory() . '/inc/template-functions.php';


function herniau_legacy_styles() {
    if ( is_single(44134) || is_single(44133) || is_single(44132)) {
        wp_enqueue_style( 'legacy-css', get_template_directory_uri() . '/assets/css/legacy.css', [], filemtime(get_template_directory() . '/assets/css/legacy.css') );
    }
}
add_action( 'wp_enqueue_scripts', 'herniau_legacy_styles' );

function aggressively_remove_fusion_shortcodes($content) {
    // Remove all [fusion.../]
    $content = preg_replace('/\[fusion[^\]]*\/\]/s', '', $content);

    // Remove all [fusion...]...[/fusion...]
    $content = preg_replace('/\[fusion[^\]]*\](.*?)\[\/fusion[^\]]*\]/s', '$1', $content);

    // Remove any leftover opening or closing tags (sometimes partial)
    $content = preg_replace('/\[\/?fusion[^\]]*\]/s', '', $content);

    return $content;
}


// add_action('wp_ajax_save_video_duration', 'save_video_duration');
// function save_video_duration() {
//     $post_id = $_POST['post_id'];
//     $duration = $_POST['duration'];

//     if ($post_id && $duration) {
//         update_field('duration', $duration, $post_id); // Assumes ACF field key is 'duration'
//         wp_send_json_success('Duration saved.');
//     } else {
//         wp_send_json_error('Missing post ID or duration.');
//     }

//     wp_die();
// }






// function clean_fusion_shortcodes_in_post($post_id) {
//     $post = get_post($post_id);

//     if (!$post) {
//         echo "Post not found.";
//         return;
//     }

//     $content = $post->post_content;

//     $clean_content = aggressively_remove_fusion_shortcodes($content);

//     // Optional: trim or further cleanup
//     $clean_content = trim($clean_content);

//     // Update
//     wp_update_post(array(
//         'ID'           => $post->ID,
//         'post_content' => $clean_content,
//     ));

//     echo "Post ID {$post_id} cleaned with aggressive regex.";
// }

// // Run on post ID 5912
// clean_fusion_shortcodes_in_post(12596);








