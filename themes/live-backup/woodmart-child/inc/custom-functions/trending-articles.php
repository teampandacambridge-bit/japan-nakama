<?php

// Track post views with date
function track_post_views_with_date()
{
    if (is_single()) {
        global $post;

        $today = date('Y-m-d'); // store by day
        $meta_key = 'views_' . $today;

        // Increment daily view counter
        $views = (int) get_post_meta($post->ID, $meta_key, true);
        update_post_meta($post->ID, $meta_key, $views + 1);
    }
}
add_action('wp_head', 'track_post_views_with_date');

// Get total views from last X days
function get_post_views_last_days($post_id, $days = 30)
{
    $total_views = 0;

    for ($i = 0; $i < $days; $i++) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $meta_key = 'views_' . $date;
        $views = (int) get_post_meta($post_id, $meta_key, true);
        $total_views += $views;
    }

    return $total_views;
}
