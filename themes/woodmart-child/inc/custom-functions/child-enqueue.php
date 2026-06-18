<?php

/**
 * Inline template-specific Critical CSS in <head>
 * - Home: assets/css/critical-home.min.css
 * - Single post: assets/css/critical-post.min.css
 * Fallback: assets/css/critical.min.css (optional)
 */
add_action('wp_head', function () {

    // Choose file by template
    $file = 'critical.min.css'; // fallback (optional)

    if (is_front_page() || is_home()) {
        $file = 'critical-home.min.css';
    } elseif (is_single() && get_post_type() === 'post') {
        $file = 'critical-post.min.css';
    }

    $path = get_stylesheet_directory() . '/assets/css/' . $file;

    if (file_exists($path)) {
        echo "<style id='jn-critical-css'>\n";
        echo file_get_contents($path);
        echo "\n</style>\n";
    }
}, 1);


/**
 * Enqueue CSS/JS
 */
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        '5.3.3'
    );

    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0'
    );

    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/assets/css/main.min.css',
        ['bootstrap-css', 'swiper-css'],
        '1.0.3'
    );

    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0',
        true
    );

    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.3',
        true
    );

    wp_enqueue_script(
        'main-js',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        [],
        filemtime(get_stylesheet_directory() . '/assets/js/main.js'),
        true
    );
}, 20);
