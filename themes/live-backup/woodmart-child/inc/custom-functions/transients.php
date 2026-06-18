<?php
function get_cached_latest_posts($limit = 20)
{
    $transient_key = 'latest_posts_' . $limit;

    // Check if the transient exists
    $latest_posts = get_transient($transient_key);

    if (false === $latest_posts) {
        // Query latest posts
        $query = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => $limit,
            'post_status'    => 'publish',
            'category__not_in' => 1716,
        ]);

        // Store posts in a transient for 12 hours
        $latest_posts = $query->have_posts() ? $query->posts : [];
        set_transient($transient_key, $latest_posts, 12 * HOUR_IN_SECONDS);
    }

    return $latest_posts;
}

function clear_all_transients()
{
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
}
add_action('publish_post', 'clear_all_transients');
add_action('save_post', 'clear_all_transients');

add_action('save_post', function () {
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache(); // For some hosting environments
    }
});


// API to clear cloudflare on post publish
function purge_cloudflare_cache_on_publish($post_id)
{
    if (wp_is_post_revision($post_id) || get_post_status($post_id) !== 'publish') {
        return;
    }

    $zone_id = 'ab1f3f3c99ff3c1b5be57c30d1e87817';
    $api_token = 'ys_4o4e6eeIz5Uzpd8ttPqdMWpp62NRv4x6GEjk7';

    $response = wp_remote_post("https://api.cloudflare.com/client/v4/zones/{$zone_id}/purge_cache", [
        'headers' => [
            'Authorization' => "Bearer $api_token",
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode(['purge_everything' => true]),
    ]);

    if (is_wp_error($response)) {
        error_log('Cloudflare purge failed: ' . $response->get_error_message());
    }
}
add_action('publish_post', 'purge_cloudflare_cache_on_publish');
