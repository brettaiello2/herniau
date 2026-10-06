<?php

function shortcode_render_login_block($atts = []) {
    $atts = shortcode_atts([], $atts);

    $block = [
        'id' => 'acf-block-' . uniqid(),
        'name' => 'acf/login-block',
        'title' => 'Login Block',
        'align' => '',
        'mode' => 'preview',
        'data' => [],
    ];

    ob_start();
    include get_template_directory() . '/inc/blocks/login.php';
    return ob_get_clean();
}
add_shortcode('acf_login_block', 'shortcode_render_login_block');



