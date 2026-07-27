<?php

/**
 * One-off backfill: mirror event-overview block attributes to post meta for all
 * existing event posts, so they're queryable before each post is next saved.
 *
 * Run via WP-CLI from the theme directory:
 *   wp eval-file backfill-event-meta.php
 *
 * Safe to re-run; it just re-writes the same meta.
 */

if (! defined('WP_CLI')) {
    return;
}

if (! function_exists('jn_get_event_overview')) {
    WP_CLI::error('jn_get_event_overview() not available — is the woodmart-child theme active?');
}

$query = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'fields'         => 'ids',
    'no_found_rows'  => true,
]);

$updated = 0;
$cleared = 0;

foreach ($query->posts as $post_id) {
    $overview = jn_get_event_overview($post_id);

    if ($overview['found']) {
        update_post_meta($post_id, JN_EVENT_STATUS_META, sanitize_key($overview['eventStatus']));
        update_post_meta($post_id, JN_EVENT_IS_FREE_META, $overview['isFree'] ? '1' : '0');
        update_post_meta($post_id, JN_EVENT_HERO_META, $overview['isHeroMain'] ? '1' : '0');

        $start = $overview['startDate']['date'] ?? '';
        update_post_meta($post_id, JN_EVENT_START_META, $start ? date('Ymd', strtotime($start)) : '');
        $updated++;
    } else {
        delete_post_meta($post_id, JN_EVENT_STATUS_META);
        delete_post_meta($post_id, JN_EVENT_IS_FREE_META);
        delete_post_meta($post_id, JN_EVENT_HERO_META);
        delete_post_meta($post_id, JN_EVENT_START_META);
        $cleared++;
    }
}

WP_CLI::success("Event meta backfill complete. With block: {$updated}. Without: {$cleared}.");
