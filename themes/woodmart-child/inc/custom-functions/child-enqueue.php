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
 * Cache-busting version for a theme asset, based on its CONTENT.
 *
 * A hash of the file changes whenever the file's contents change — so browsers
 * always fetch a fresh copy after an update. This is more reliable than
 * filemtime() on hosts where file modification times don't update predictably
 * (e.g. some deploy pipelines / cached filesystems).
 *
 * @param string $relative_path Path relative to the theme root, e.g. 'assets/css/main.min.css'.
 * @return string A short version string, or the theme version as a fallback.
 */
function jn_asset_version($relative_path)
{
    $file = get_stylesheet_directory() . '/' . ltrim($relative_path, '/');

    if (file_exists($file)) {
        // 8 chars of an MD5 of the file contents — changes on any edit.
        return substr(md5_file($file), 0, 8);
    }

    return wp_get_theme()->get('Version');
}

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
        jn_asset_version('assets/css/main.min.css') // auto cache-bust on change
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
        jn_asset_version('assets/js/main.js'), // auto cache-bust on change
        true
    );
}, 20);
