<?php
// Without a valid category, 'cat' => 0 would drop the restriction entirely and
// pull the newest posts site-wide, so bail rather than render wrong cards.
$takeover_cat = get_category_by_slug('events');

if (! $takeover_cat) {
    return;
}

$takeover_query = new WP_Query([
    'post_type'           => 'post',
    'cat'                 => (int) $takeover_cat->term_id,
    'posts_per_page'      => 6,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
    // Everything except events that have ended. Posts with no status meta yet
    // are kept, so an event still shows before its first meta sync.
    'meta_query'          => [
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
    ],
]);

// Editable copy — Nakama Settings → Homepage Events.
$takeover_ribbon  = nakama_get_homepage_events_copy('nakama_events_ribbon');
$takeover_heading = nakama_get_homepage_events_copy('nakama_events_heading');
$takeover_subcopy = nakama_get_homepage_events_copy('nakama_events_subcopy');
?>

<section class="events-takeover bg-black">
    <div class="container-medium event-grid">
        <div class="ribbon-strap">
            <p><span class="pulse-dot" aria-hidden="true"></span><?php echo esc_html($takeover_ribbon); ?></p>
        </div>
        <div class="event-heading">
            <p class="kicker">
                What's On
            </p>
            <h2>
                <?php echo esc_html($takeover_heading); ?>
            </h2>
            <?php if ($takeover_subcopy) : ?>
                <p>
                    <?php echo esc_html($takeover_subcopy); ?>
                </p>
            <?php endif; ?>
            <a class="" href="<?php echo esc_url(home_url('/events')); ?>">See all events</a>
            <a class="submit-event" href="<?php echo esc_url(home_url('/contact-us/')); ?>">Submit an event</a>
        </div>
        <div class="newsletter-cta">
            <p class="kicker">
                Updated Weekly
            </p>
            <h2><?php esc_html_e('Never miss a Japanese event in the UK', 'woodmart'); ?></h2>
            <p><?php esc_html_e('A focused, weekly What\'s On email: on now, this week, and upcoming. Separate from our general list.', 'woodmart'); ?></p>

            <div class="event-signup-cta__form">
                <div class="klaviyo-form-RCvnrW"></div>
            </div>

            <p class="">
                <?php
                printf(
                    /* translators: %1$s: Privacy Policy link, %2$s: Terms of Service link */
                    esc_html__('By subscribing you agree to our %1$s and %2$s.', 'woodmart'),
                    '<a href="' . esc_url(home_url('/privacy-policy/')) . '">' . esc_html__('Privacy Policy', 'woodmart') . '</a>',
                    '<a href="' . esc_url(home_url('/terms-and-conditions/')) . '">' . esc_html__('Terms of Service', 'woodmart') . '</a>'
                );
                ?>
            </p>
        </div>
        <div class="event-cards">
            <?php if ($takeover_query->have_posts()) : ?>
                <?php while ($takeover_query->have_posts()) :
                    $takeover_query->the_post();
                    $to_post     = get_post();
                    $to_overview = jn_get_event_overview($to_post);
                    $to_dates    = jn_format_event_dates($to_overview);
                    $to_status   = jn_event_status_label($to_overview['eventStatus']);
                ?>
                    <article class="event-card">
                        <a class="event-card__image<?php echo has_post_thumbnail($to_post) ? '' : ' event-card__image--placeholder'; ?>" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail($to_post)) : ?>
                                <?php echo get_the_post_thumbnail($to_post, 'medium'); ?>
                            <?php endif; ?>

                            <?php if ($to_status) : ?>
                                <span class="card-badges card-badges--left">
                                    <span class="event-status-badge event-status-badge--<?php echo esc_attr($to_overview['eventStatus']); ?>"><?php echo esc_html($to_status); ?></span>
                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="event-card__body">
                            <h3 class="event-card__heading">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                            </h3>

                            <div class="card-meta-list">
                                <?php if ($to_dates) : ?>
                                    <p class="card-meta card-meta--date">
                                        <?php echo jn_event_meta_icon('date'); ?>
                                        <span><?php echo wp_kses_post($to_dates); ?></span>
                                    </p>
                                <?php endif; ?>
                                <?php if (! empty($to_overview['address'])) : ?>
                                    <p class="card-meta card-meta--address">
                                        <?php echo jn_event_meta_icon('address'); ?>
                                        <span><?php echo esc_html($to_overview['address']); ?></span>
                                    </p>
                                <?php endif; ?>
                            </div>


                            <a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html('Read More'); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="event-cards__empty"><?php esc_html_e('No upcoming events at the moment.', 'woodmart'); ?></p>
            <?php endif; ?>
        </div>

    </div>

</section>