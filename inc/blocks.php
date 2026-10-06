<?php

function herniau_block_category( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'herniau-blocks',
        'title' => __( 'HerniaU Blocks', 'herniau-blocks' ),
      ),
    )
  );
}
add_filter( 'block_categories_all', 'herniau_block_category', 10, 2);


add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {

    if( function_exists('acf_register_block_type') ) {


        acf_register_block_type(array(
            'name'              => 'login-block',
            'title'             => __('Login Block'),
            'description'       => __('A block where users can login or click to register'),
            'render_template'   => get_template_directory() . '/inc/blocks/login.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'login', 'register', 'log', 'herniau'),
        ));


        acf_register_block_type(array(
            'name'              => 'podcast-feed',
            'title'             => __('List of Podcasts'),
            'description'       => __('A block that displays all the latest podcasts'),
            'render_template'   => get_template_directory() . '/inc/blocks/podcast-feed.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'podcast', 'audio', 'feed', 'herniau'),
        ));

        acf_register_block_type(array(
            'name'              => 'content-carousel',
            'title'             => __('Content Carousel'),
            'description'       => __('A carousel feed from different types of content'),
            'render_template'   => get_template_directory() . '/inc/blocks/content-carousel.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'carousel', 'feed', 'content', 'herniau'),
        ));

        acf_register_block_type(array(
            'name'              => 'content-grid',
            'title'             => __('Content Grid'),
            'description'       => __('A grid of item from different types of content'),
            'render_template'   => get_template_directory() . '/inc/blocks/content-grid.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'grid', 'feed', 'content', 'herniau'),
        ));


        acf_register_block_type(array(
            'name'              => 'instructor-card-simple',
            'title'             => __('Instructor Card Simple'),
            'description'       => __('A block to show an short instructor card/snippet'),
            'render_template'   => get_template_directory() . '/inc/blocks/instructor-card-simple.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'instructor', 'feed', 'content', 'herniau'),
        ));

        acf_register_block_type(array(
            'name'              => 'Accordion',
            'title'             => __('Accordion for FAQs'),
            'description'       => __(''),
            'render_template'   => get_template_directory() . '/inc/blocks/accordion.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'accordion', 'faq', 'content', 'herniau'),
        ));


        acf_register_block_type(array(
            'name'              => 'Hero Carousel',
            'title'             => __('Hero Carousel'),
            'description'       => __(''),
            'render_template'   => get_template_directory() . '/inc/blocks/hero-carousel.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'carousel', 'hero', 'content', 'herniau'),
        ));


        acf_register_block_type(array(
            'name'              => 'CTA Button',
            'title'             => __('CTA Button'),
            'description'       => __(''),
            'render_template'   => get_template_directory() . '/inc/blocks/cta-button.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'button', 'cta', 'content', 'herniau'),
        ));

        acf_register_block_type(array(
            'name'              => 'Alert Bar',
            'title'             => __('Alert Bar'),
            'description'       => __(''),
            'render_template'   => get_template_directory() . '/inc/blocks/alert-bar.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'alert', 'bar', 'banner', 'herniau'),
        ));

        acf_register_block_type(array(
            'name'              => 'Featured Item',
            'title'             => __('Featured Item'),
            'description'       => __(''),
            'render_template'   => get_template_directory() . '/inc/blocks/featured-item.php',
            'category'          => 'herniau-blocks',
            'icon'              => 'grid-view',
            'keywords'          => array( 'featured', 'bar', 'banner', 'herniau'),
        ));

    }
  }