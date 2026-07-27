<?php

/**
 * Events archive functionality.
 *
 * Data for event cards comes from the `create-block/event-overview` Gutenberg
 * block, whose attributes are serialised into the post content. For display we
 * read them by parsing the blocks; for querying/filtering we mirror the
 * queryable ones (status, free) to post meta on save so WP_Query can use them.
 *
 * @see wp-content/plugins/nakama-blocks/build/event-overview/block.json
 */

if (! defined('ABSPATH')) {
    exit;
}

// Meta keys the block attributes are mirrored to (for querying/filtering).
const JN_EVENT_STATUS_META   = '_jn_event_status';
const JN_EVENT_IS_FREE_META  = '_jn_event_is_free';
const JN_EVENT_HERO_META     = '_jn_event_hero_main';
const JN_EVENT_SIDEBAR_META  = '_jn_event_sidebar_featured';
const JN_EVENT_START_META    = '_jn_event_start'; // 'Ymd' — sortable start date
const JN_EVENT_END_META      = '_jn_event_end';   // 'Ymd' — sortable end date

// Stored in the end-date meta when an event has no dates at all, so a plain
// "end date ascending" sort pushes those events to the bottom of the grid.
const JN_EVENT_NO_END_SENTINEL = '99999999';

/**
 * Compute an event's status from its start/end dates.
 *
 * Evaluated in order, first match wins:
 *   past        — end date is before today
 *   last-chance — has started AND ends within the next 7 days
 *   on-now      — has started AND ends more than 7 days from today
 *   upcoming    — not yet started AND starts within the next 30 days
 *   later       — not yet started AND starts more than 30 days away
 *
 * Falls back to an empty string when there aren't enough dates to decide.
 * An event with only a start date is treated as a single-day event.
 *
 * @param string $start Start date ('Y-m-d' or 'Ymd'); may be empty.
 * @param string $end   End date ('Y-m-d' or 'Ymd'); may be empty.
 * @return string One of 'past'|'last-chance'|'on-now'|'upcoming'|'later', or ''.
 */
function jn_compute_event_status($start, $end)
{
    if (empty($start) && empty($end)) {
        return '';
    }

    // Normalise to midnight timestamps so comparisons are whole-day based.
    $today      = strtotime('today');
    $start_ts   = $start ? strtotime('today', strtotime($start)) : null;
    // No end date → treat as a single-day event ending on the start date.
    $end_ts     = $end ? strtotime('today', strtotime($end)) : $start_ts;

    if ($start_ts === null) {
        $start_ts = $end_ts; // only an end date known
    }

    // 1. Past — end date is before today.
    if ($end_ts < $today) {
        return 'past';
    }

    $has_started = $start_ts <= $today;
    $days_to_end = (int) floor(($end_ts - $today) / DAY_IN_SECONDS);

    if ($has_started) {
        // 2. Last chance — ends within the next 7 days.
        // 3. On now — ends more than 7 days away.
        return $days_to_end <= 7 ? 'last-chance' : 'on-now';
    }

    $days_to_start = (int) floor(($start_ts - $today) / DAY_IN_SECONDS);

    // 4. Upcoming — starts within the next 30 days.
    // 5. Later — starts more than 30 days away.
    return $days_to_start <= 30 ? 'upcoming' : 'later';
}

/**
 * The status to use for a post: the manual override if set, else computed.
 *
 * @param array $overview Result of jn_get_event_overview().
 * @return string Status slug, or '' when undeterminable.
 */
function jn_effective_event_status($overview)
{
    // jn_get_event_overview() already resolves this: manual override if set,
    // else computed from the dates.
    return $overview['eventStatus'] ?? '';
}

/**
 * Sync queryable event-overview attributes to post meta on save.
 *
 * Block attributes can't be used in a meta_query/orderby, so we mirror the
 * queryable ones — status, free flag, hero-main flag, and a sortable start
 * date — to post meta. Runs for any post (events are category posts, not a
 * CPT); a post without the block simply clears the meta.
 *
 * @param int $post_id
 */
function jn_sync_event_meta($post_id)
{
    // Skip autosaves/revisions — the real save fires separately.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (wp_is_post_revision($post_id)) {
        return;
    }

    $overview = jn_get_event_overview($post_id);

    if (! $overview['found']) {
        delete_post_meta($post_id, JN_EVENT_STATUS_META);
        delete_post_meta($post_id, JN_EVENT_IS_FREE_META);
        delete_post_meta($post_id, JN_EVENT_HERO_META);
        delete_post_meta($post_id, JN_EVENT_SIDEBAR_META);
        delete_post_meta($post_id, JN_EVENT_START_META);
        delete_post_meta($post_id, JN_EVENT_END_META);
        return;
    }

    // Store the EFFECTIVE status (manual override, else computed from dates)
    // so queries match what the cards display. Recomputed nightly by cron.
    update_post_meta($post_id, JN_EVENT_STATUS_META, sanitize_key(jn_effective_event_status($overview)));
    update_post_meta($post_id, JN_EVENT_IS_FREE_META, $overview['isFree'] ? '1' : '0');
    update_post_meta($post_id, JN_EVENT_HERO_META, $overview['isHeroMain'] ? '1' : '0');
    update_post_meta($post_id, JN_EVENT_SIDEBAR_META, $overview['isSidebarFeatured'] ? '1' : '0');

    // Sortable dates as Ymd (e.g. 20260712).
    $start = $overview['startDate']['date'] ?? '';
    $end   = $overview['endDate']['date'] ?? '';

    update_post_meta($post_id, JN_EVENT_START_META, $start ? date('Ymd', strtotime($start)) : '');

    // The grid sorts by end date ascending. Events with no end date must sort
    // LAST, so store a far-future sentinel rather than an empty value (which
    // would sort first). Falls back to the start date for single-day events.
    if ($end) {
        $end_sortable = date('Ymd', strtotime($end));
    } elseif ($start) {
        $end_sortable = date('Ymd', strtotime($start)); // single-day event
    } else {
        $end_sortable = JN_EVENT_NO_END_SENTINEL;
    }
    update_post_meta($post_id, JN_EVENT_END_META, $end_sortable);
}

/**
 * Nightly re-sync: recompute event status meta for all event posts.
 *
 * Status is derived from dates, so it changes as time passes even when nobody
 * edits the post. This keeps the queryable meta in step with what the computed
 * badge shows, without requiring a re-save.
 */
function jn_cron_resync_event_status()
{
    $ids = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'meta_query'     => [
            ['key' => JN_EVENT_START_META, 'compare' => 'EXISTS'],
        ],
    ]);

    foreach ($ids as $id) {
        $overview = jn_get_event_overview($id);
        if ($overview['found']) {
            update_post_meta($id, JN_EVENT_STATUS_META, sanitize_key(jn_effective_event_status($overview)));
        }
    }
}
add_action('jn_daily_event_status_resync', 'jn_cron_resync_event_status');

/**
 * Schedule the nightly status re-sync.
 */
function jn_schedule_event_status_resync()
{
    if (! wp_next_scheduled('jn_daily_event_status_resync')) {
        // Just after midnight, so statuses flip on the right day.
        wp_schedule_event(strtotime('tomorrow 00:05'), 'daily', 'jn_daily_event_status_resync');
    }
}
add_action('init', 'jn_schedule_event_status_resync');

/**
 * Purge caches for the events archive when an event post is saved.
 *
 * The archive's card placement is driven by post meta (status, start date,
 * hero/sidebar flags), so a change to a published event must invalidate the
 * archive page — not just the post. The theme's existing publish-only
 * Cloudflare purge doesn't cover edits to already-published posts, so we do a
 * targeted purge of the archive + post URLs on every event save.
 *
 * @param int $post_id
 */
function jn_purge_events_archive_cache($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (wp_is_post_revision($post_id)) {
        return;
    }
    // Only for posts in the events category.
    if (! has_category('events', $post_id)) {
        return;
    }

    // Local caches (page cache / object cache) — mirrors transients.php.
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }

    // URLs whose cached HTML is now stale.
    $urls = array_filter([
        get_permalink($post_id),
        get_term_link('events', 'category'),
    ], 'is_string');

    if (empty($urls)) {
        return;
    }

    // Cloudflare targeted purge. Token/zone come from constants if defined
    // (preferred — see DEVELOPMENT.md), else fall back to the theme's existing
    // hardcoded values so behaviour is unchanged on current deploys.
    $zone_id   = defined('JN_CF_ZONE_ID') ? JN_CF_ZONE_ID : 'ab1f3f3c99ff3c1b5be57c30d1e87817';
    $api_token = defined('JN_CF_API_TOKEN') ? JN_CF_API_TOKEN : 'ys_4o4e6eeIz5Uzpd8ttPqdMWpp62NRv4x6GEjk7';

    $response = wp_remote_post("https://api.cloudflare.com/client/v4/zones/{$zone_id}/purge_cache", [
        'headers' => [
            'Authorization' => "Bearer {$api_token}",
            'Content-Type'  => 'application/json',
        ],
        'body' => wp_json_encode(['files' => array_values($urls)]),
    ]);

    if (is_wp_error($response)) {
        error_log('JN events archive Cloudflare purge failed: ' . $response->get_error_message());
    }
}
add_action('save_post', 'jn_purge_events_archive_cache');

/**
 * One-shot admin backfill: sync event meta for ALL posts.
 *
 * For environments without WP-CLI/SSH. Visit, while logged in as an admin:
 *   /?jn_backfill_events=1
 * Runs jn_sync_event_meta() on every post and reports counts, then stops.
 * Safe to re-run. Requires manage_options.
 */
function jn_maybe_backfill_event_meta()
{
    if (! current_user_can('manage_options')) {
        return;
    }

    // --- Backfill: /?jn_backfill_events=1 ---
    if (isset($_GET['jn_backfill_events'])) {
        $ids = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]);

        $with = 0;
        foreach ($ids as $id) {
            jn_sync_event_meta($id);
            if (jn_get_event_overview($id)['found']) {
                $with++;
            }
        }

        wp_die(
            esc_html(sprintf(
                'Event meta backfill complete. Posts processed: %d. With event block: %d. You can remove ?jn_backfill_events now.',
                count($ids),
                $with
            )),
            'Event meta backfill',
            ['response' => 200]
        );
    }

    // --- Diagnostic: /events/?jn_events_debug=1 (run ON the events archive) ---
    if (isset($_GET['jn_events_debug'])) {
        $cat = get_queried_object_id();
        $out = "queried cat id: {$cat}\n";
        $out .= 'today (Ymd): ' . date('Ymd') . "\n\n";

        $upcoming = jn_query_upcoming_events('all', $cat);
        $out .= 'UPCOMING (all): ' . $upcoming->post_count . " posts\n";
        foreach ($upcoming->posts as $p) {
            $out .= sprintf(
                "  #%d %s | start=%s status=%s free=%s\n",
                $p->ID,
                get_the_title($p),
                get_post_meta($p->ID, JN_EVENT_START_META, true) ?: '(none)',
                get_post_meta($p->ID, JN_EVENT_STATUS_META, true) ?: '(none)',
                get_post_meta($p->ID, JN_EVENT_IS_FREE_META, true) ?: '(none)'
            );
        }
        wp_reset_postdata();

        // For contrast: every post in this category, raw meta.
        $all = get_posts(['post_type' => 'post', 'cat' => $cat, 'posts_per_page' => -1, 'post_status' => 'publish']);
        $out .= "\nALL POSTS IN CATEGORY: " . count($all) . "\n";
        foreach ($all as $p) {
            $out .= sprintf(
                "  #%d %s | start=%s status=%s\n",
                $p->ID,
                get_the_title($p),
                get_post_meta($p->ID, JN_EVENT_START_META, true) ?: '(none)',
                get_post_meta($p->ID, JN_EVENT_STATUS_META, true) ?: '(none)'
            );
        }

        wp_die('<pre>' . esc_html($out) . '</pre>', 'Events debug', ['response' => 200]);
    }
}
add_action('template_redirect', 'jn_maybe_backfill_event_meta');
add_action('save_post', 'jn_sync_event_meta');

/**
 * Pull the event-overview block attributes for a given post.
 *
 * Returns a normalised array of the fields the cards need. Missing fields come
 * back as empty strings / empty arrays so templates can echo safely.
 *
 * @param int|WP_Post|null $post Post to read (defaults to current post).
 * @return array{
 *   heading:string, cost:string, address:string,
 *   startDate:array{date:string,time:string},
 *   endDate:array{date:string,time:string},
 *   cta:array{text:string,url:string},
 *   found:bool
 * }
 */
function jn_get_event_overview($post = null)
{
    $empty = [
        'heading'     => '',
        'cost'        => '',
        'isHeroMain'        => false,
        'isSidebarFeatured' => false,
        'isFree'            => false,
        'isSponsored'       => false,
        'eventStatus' => '',
        'eventVenue'  => '',
        'address'     => '',
        'startDate' => ['date' => '', 'time' => ''],
        'endDate'   => ['date' => '', 'time' => ''],
        'cta'       => ['text' => '', 'url' => ''],
        'found'     => false,
    ];

    $post = get_post($post);
    if (! $post || empty($post->post_content) || ! has_blocks($post->post_content)) {
        return $empty;
    }

    foreach (parse_blocks($post->post_content) as $block) {
        if (($block['blockName'] ?? '') !== 'create-block/event-overview') {
            continue;
        }

        $attrs = $block['attrs'] ?? [];

        $data = [
            'heading'     => $attrs['heading'] ?? '',
            'cost'        => $attrs['cost'] ?? '',
            'isHeroMain'        => ! empty($attrs['isHeroMain']),
            'isSidebarFeatured' => ! empty($attrs['isSidebarFeatured']),
            'isFree'            => ! empty($attrs['isFree']),
            'isSponsored'       => ! empty($attrs['isSponsored']),
            'eventVenue'  => $attrs['eventVenue'] ?? '',
            'address'     => $attrs['address'] ?? '',
            'startDate' => wp_parse_args($attrs['startDate'] ?? [], ['date' => '', 'time' => '']),
            'endDate'   => wp_parse_args($attrs['endDate'] ?? [], ['date' => '', 'time' => '']),
            'cta'       => wp_parse_args($attrs['cta'] ?? [], ['text' => '', 'url' => '']),
            'found'     => true,
        ];

        // The raw block value is the editor's manual override ('' = automatic).
        $data['eventStatusOverride'] = $attrs['eventStatus'] ?? '';

        // `eventStatus` is the EFFECTIVE status everything should use: the
        // manual override if set, else computed from the dates.
        $data['eventStatus'] = $data['eventStatusOverride'] !== ''
            ? $data['eventStatusOverride']
            : jn_compute_event_status($data['startDate']['date'], $data['endDate']['date']);

        return $data;
    }

    return $empty;
}

/**
 * Map an event-status slug to its display label.
 *
 * @param string $status Stored slug ('upcoming'|'on-now'|'last-chance'|'past').
 * @return string Human-readable label, or '' if empty/unknown.
 */
function jn_event_status_label($status)
{
    $labels = [
        'last-chance' => __('Last Chance', 'woodmart'),
        'on-now'      => __('On Now', 'woodmart'),
        'upcoming'    => __('Upcoming', 'woodmart'),
        'later'       => __('Later', 'woodmart'),
        'past'        => __('Past', 'woodmart'),
    ];

    return $labels[$status] ?? '';
}

/**
 * Render an event card's native post tags as a pill list.
 *
 * Display-only content indicator (not used for filtering/AJAX). Shared by every
 * card type on the events archive so tag markup stays identical everywhere.
 *
 * @param int|WP_Post|null $post Post to read tags from (defaults to current).
 * @param bool             $echo Echo the markup (default) or return it.
 * @return string Tag list markup, or '' if the post has no tags.
 */
function jn_render_event_tags($post = null, $echo = true)
{
    $post = get_post($post);
    $tags = $post ? get_the_tags($post->ID) : [];

    if (empty($tags)) {
        if (! $echo) {
            return '';
        }
        return '';
    }

    ob_start();
    ?>
    <ul class="card-tags">
        <?php foreach ($tags as $tag) : ?>
            <li class="tag"><?php echo esc_html($tag->name); ?></li>
        <?php endforeach; ?>
    </ul>
    <?php
    $html = ob_get_clean();

    if ($echo) {
        echo $html; // Escaped above.
    }

    return $html;
}

/**
 * The inline SVG for an event meta icon (date | address | cost).
 *
 * @param string $name 'date' | 'address' | 'cost'.
 * @return string SVG markup, or '' for an unknown name.
 */
function jn_event_meta_icon($name)
{
    $open  = '<svg class="card-meta__icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">';
    $close = '</svg>';

    $paths = [
        'date'    => '<rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" />',
        'address' => '<path d="M12 21s-6-5.686-6-10a6 6 0 1 1 12 0c0 4.314-6 10-6 10Z" /><circle cx="12" cy="11" r="2.5" />',
        'cost'    => '<path d="M20.6 12.6 12.4 4.4A2 2 0 0 0 11 4H5a1 1 0 0 0-1 1v6a2 2 0 0 0 .6 1.4l8.2 8.2a2 2 0 0 0 2.8 0l5-5a2 2 0 0 0 0-2.8Z" /><circle cx="8" cy="8" r="1.2" />',
    ];

    return isset($paths[$name]) ? $open . $paths[$name] . $close : '';
}

/**
 * Render the event meta list (date, address, cost) with leading icons.
 *
 * Shared by every event card so the icon + line treatment is identical.
 * Each line is only output when its value is present.
 *
 * @param array  $overview Result of jn_get_event_overview().
 * @param string $dates    Pre-formatted date string (from jn_format_event_dates()).
 * @param bool   $echo     Echo (default) or return the markup.
 * @return string
 */
function jn_render_event_meta($overview, $dates, $echo = true)
{
    $address = $overview['address'] ?? '';
    $cost    = $overview['cost'] ?? '';

    if (empty($dates) && empty($address) && empty($cost)) {
        if (! $echo) {
            return '';
        }
        return '';
    }

    ob_start();
    ?>
    <div class="card-meta-list">
        <?php if ($dates) : ?>
            <p class="card-meta card-meta--date">
                <?php echo jn_event_meta_icon('date'); // safe static SVG ?>
                <span><?php echo wp_kses_post($dates); ?></span>
            </p>
        <?php endif; ?>
        <?php if ($address) : ?>
            <p class="card-meta card-meta--address">
                <?php echo jn_event_meta_icon('address'); ?>
                <span><?php echo esc_html($address); ?></span>
            </p>
        <?php endif; ?>
        <?php if ($cost) : ?>
            <p class="card-meta card-meta--cost">
                <?php echo jn_event_meta_icon('cost'); ?>
                <span><?php echo esc_html($cost); ?></span>
            </p>
        <?php endif; ?>
    </div>
    <?php
    $html = ob_get_clean();

    if ($echo) {
        echo $html; // SVGs are static; text is escaped above.
    }

    return $html;
}

/**
 * Format an event date range for display, e.g. "12 Jul 2026 – 14 Jul 2026".
 *
 * Tolerant of partial data: if only one of start/end has a date, that single
 * date is shown. Returns '' only when neither has a date.
 *
 * @param array $overview Result of jn_get_event_overview().
 * @return string Human-readable date range (empty if no dates at all).
 */
function jn_format_event_dates($overview)
{
    $start = $overview['startDate']['date'] ?? '';
    $end   = $overview['endDate']['date'] ?? '';

    // No dates at all → nothing to show.
    if (empty($start) && empty($end)) {
        return '';
    }

    // Only one date present → show whichever we have.
    if (empty($start)) {
        return date_i18n('j M Y', strtotime($end));
    }
    if (empty($end)) {
        return date_i18n('j M Y', strtotime($start));
    }

    // Both present: single date if identical, otherwise a range.
    if ($end === $start) {
        return date_i18n('j M Y', strtotime($start));
    }

    return date_i18n('j M Y', strtotime($start)) . ' &ndash; ' . date_i18n('j M Y', strtotime($end));
}

/**
 * Query the upcoming events grid.
 *
 * Shared by the initial template render and the AJAX filter so both produce
 * identical results. All events except those tagged 'past', ordered by event
 * start date (soonest first); optionally limited by cost.
 *
 * @param string $filter 'all' | 'free' | 'paid'.
 * @param int    $cat_id Category term ID to query.
 * @return WP_Query
 */
function jn_query_upcoming_events($filter, $cat_id)
{
    $meta_query = [
        'relation'   => 'AND',
        // Sort key: end date ascending (soonest ending first). Events with no
        // dates carry a far-future sentinel so they sort last.
        'end_clause' => [
            'key'     => JN_EVENT_END_META,
            'compare' => 'EXISTS',
        ],
        // Everything except events that have ended.
        [
            'relation' => 'OR',
            [
                'key'     => JN_EVENT_STATUS_META,
                'value'   => 'past',
                'compare' => '!=',
            ],
            [
                'key'     => JN_EVENT_STATUS_META,
                'compare' => 'NOT EXISTS',
            ],
        ],
    ];

    if ($filter === 'free') {
        // Only events explicitly flagged free.
        $meta_query[] = [
            'key'   => JN_EVENT_IS_FREE_META,
            'value' => '1',
        ];
    } elseif ($filter === 'paid') {
        // Everything NOT flagged free — includes '0' and no meta at all.
        $meta_query[] = [
            'relation' => 'OR',
            [
                'key'     => JN_EVENT_IS_FREE_META,
                'value'   => '1',
                'compare' => '!=',
            ],
            [
                'key'     => JN_EVENT_IS_FREE_META,
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    return new WP_Query([
        'post_type'      => 'post',
        'cat'            => $cat_id,
        'posts_per_page' => -1,
        'orderby'        => ['end_clause' => 'ASC'], // soonest ending first
        'meta_query'     => $meta_query,
    ]);
}

/**
 * Normalise a filter value to one of the allowed keys.
 *
 * @param string $filter
 * @return string 'all' | 'free' | 'paid'.
 */
function jn_normalize_event_filter($filter)
{
    return in_array($filter, ['free', 'paid'], true) ? $filter : 'all';
}

/**
 * Render the upcoming event cards for a query (or an empty-state message).
 *
 * @param WP_Query $query
 * @param string   $filter Used to tailor the empty-state message.
 */
function jn_render_upcoming_cards($query, $filter)
{
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content/card-event', null, ['post' => get_post()]);
        }
        wp_reset_postdata();
        return;
    }

    $messages = [
        'free' => __('No free events at the moment.', 'woodmart'),
        'paid' => __('No paid events at the moment.', 'woodmart'),
        'all'  => __('No upcoming events at the moment.', 'woodmart'),
    ];
    $message = $messages[$filter] ?? $messages['all'];

    echo '<p class="events-cards__empty">' . esc_html($message) . '</p>';
}

/**
 * AJAX: return the filtered upcoming cards markup.
 */
function jn_ajax_filter_events()
{
    check_ajax_referer('jn_events_filter', 'nonce');

    $filter = jn_normalize_event_filter($_POST['filter'] ?? 'all');
    $cat_id = isset($_POST['cat']) ? absint($_POST['cat']) : 0;

    $query = jn_query_upcoming_events($filter, $cat_id);

    ob_start();
    jn_render_upcoming_cards($query, $filter);
    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_jn_filter_events', 'jn_ajax_filter_events');
add_action('wp_ajax_nopriv_jn_filter_events', 'jn_ajax_filter_events');

/**
 * Enqueue the events filter script only on the events category archive.
 */
function jn_enqueue_event_filter()
{
    if (! is_category('events')) {
        return;
    }

    $src = get_stylesheet_directory() . '/assets/js/event-filter.js';

    wp_enqueue_script(
        'jn-event-filter',
        get_stylesheet_directory_uri() . '/assets/js/event-filter.js',
        [],
        file_exists($src) ? filemtime($src) : '1.0',
        true
    );

    wp_localize_script('jn-event-filter', 'jnEventsFilter', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('jn_events_filter'),
        'catId'   => get_queried_object_id(),
    ]);
}
add_action('wp_enqueue_scripts', 'jn_enqueue_event_filter');
