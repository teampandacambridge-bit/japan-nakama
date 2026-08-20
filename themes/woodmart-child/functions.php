<?php

require_once get_stylesheet_directory() . '/inc/custom-functions/child-enqueue.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/child-dequeue.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/transients.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/homepage-slider.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/navs.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/old-funcs.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/adverts.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/trending-articles.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/nakama-settings.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/custom-posts.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/breadlinks.php';
require_once get_stylesheet_directory() . '/inc/custom-functions/events.php';

// Noindex + canonical for WooCommerce filtered/parameter category URLs

function jn_has_query_params()
{
    $exact_params = [
        'filter_colour',
        'filter_size',
        'filter_brands',
        'filter_collections',
        'filter_shop-by',
        'orderby',
        'per_page',
        'yith_wcan',
        'currency'
    ];
    foreach ($_GET as $key => $value) {
        if (strpos($key, 'filter_') === 0) return true;
        if (strpos($key, 'attribute_') === 0) return true;
        if (in_array($key, $exact_params)) return true;
    }
    return false;
}

// Single combined noindex filter
add_filter('wpseo_robots', function ($robots) {
    // Paginated archive pages (page 2+)
    if (is_paged()) {
        return 'noindex, follow';
    }
    // Filtered/parameter category URLs
    if (is_product_category() && jn_has_query_params()) {
        return 'noindex, follow';
    }
    return $robots;
});
// Set canonical to base category URL via Yoast
add_filter('wpseo_canonical', function ($canonical) {
    if (is_product_category() && jn_has_query_params()) {
        return get_term_link(get_queried_object());
    }
    return $canonical;
});
