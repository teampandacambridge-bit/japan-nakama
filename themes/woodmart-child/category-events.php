<?php get_template_part('template-parts/headers/nakama-head'); ?>
<div class="container-medium">
    <section id="page-title">

        <h1>Japanese Events in London and the UK: What's On</h1>
        <p>Theatre, festivals, screenings, markets and gigs. See what is on now, when and where it is, and book in a couple of taps.</p>
    </section>

    <section id="cards_hero">
        <?php
        // ZONE 1 — MAIN CARD: the event manually flagged "Feature as main hero"
        // (newest wins if more than one is flagged). An ended event drops out
        // automatically, so the hero never shows a finished event.
        $main_query = new WP_Query([
            'post_type'           => 'post',
            'cat'                 => get_queried_object_id(),
            'posts_per_page'      => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
            'meta_query'          => [
                'relation' => 'AND',
                [
                    'key'   => JN_EVENT_HERO_META,
                    'value' => '1',
                ],
                // Not ended. Include posts with no status meta yet (NOT EXISTS)
                // so a flagged hero still shows before/without a status sync.
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

        $main_post = $main_query->have_posts() ? $main_query->posts[0] : null;
        $main_id   = $main_post ? $main_post->ID : 0;

        // ZONE 2 — 3 SIDE CARDS: the most time-critical events. Same sort as the
        // main grid (end date ascending — soonest ending first), excluding the
        // hero and anything that has ended. Top 3 of that list.
        $sides_query = new WP_Query([
            'post_type'           => 'post',
            'cat'                 => get_queried_object_id(),
            'posts_per_page'      => 3,
            'post__not_in'        => $main_id ? [$main_id] : [],
            'orderby'             => ['end_clause' => 'ASC'],
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
            'meta_query'          => [
                'relation'   => 'AND',
                'end_clause' => [
                    'key'     => JN_EVENT_END_META,
                    'compare' => 'EXISTS',
                ],
                [
                    'key'     => JN_EVENT_STATUS_META,
                    'value'   => 'past',
                    'compare' => '!=',
                ],
            ],
        ]);
        $side_posts = $sides_query->posts;

        if ($main_post) :
            $overview  = jn_get_event_overview($main_post);
            $dates     = jn_format_event_dates($overview);
            $permalink = get_permalink($main_post);
        ?>

            <!-- Left 50%: one large featured event card, spans all rows -->
            <article class="hero-main-card">
                <a class="hero-main-card__link" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr(get_the_title($main_post)); ?>">
                    <span class="hero-main-card__image">
                        <?php echo get_the_post_thumbnail($main_post, 'large'); ?>
                    </span>
                    <span class="hero-main-card__gradient" aria-hidden="true"></span>

                    <?php $status_label = jn_event_status_label($overview['eventStatus']); ?>
                    <?php if ($status_label || ! empty($overview['isFree']) || ! empty($overview['eventVenue'])) : ?>
                        <span class="card-badges card-badges--left">
                            <?php if ($status_label) : ?>
                                <span class="event-status-badge event-status-badge--<?php echo esc_attr($overview['eventStatus']); ?>"><?php echo esc_html($status_label); ?></span>
                            <?php endif; ?>
                            <?php if (! empty($overview['isFree'])) : ?>
                                <span class="event-free-badge"><?php esc_html_e('Free', 'woodmart'); ?></span>
                            <?php endif; ?>
                            <?php if (! empty($overview['eventVenue'])) : ?>
                                <span class="event-venue-badge"><?php echo esc_html($overview['eventVenue']); ?></span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>

                    <?php if (! empty($overview['isSponsored'])) : ?>
                        <span class="event-sponsored-badge"><?php esc_html_e('Sponsored', 'woodmart'); ?></span>
                    <?php endif; ?>
                </a>

                <div class="hero-main-card__body">
                    <?php jn_render_event_tags($main_post); ?>

                    <h2 class="hero-main-card__heading">
                        <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html(get_the_title($main_post)); ?></a>
                    </h2>

                    <?php jn_render_event_meta($overview, $dates); ?>

                    <?php $desc = get_the_excerpt($main_post); ?>
                    <?php if ($desc) : ?>
                        <p class="hero-main-card__desc"><?php echo esc_html($desc); ?></p>
                    <?php endif; ?>

                    <div class="hero-main-card__actions">
                        <?php if (! empty($overview['cta']['url']) && ! empty($overview['cta']['text'])) : ?>
                            <a class="hero-main-card__cta" href="<?php echo esc_url($overview['cta']['url']); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html($overview['cta']['text']); ?>
                            </a>
                        <?php endif; ?>

                        <a class="hero-main-card__read-more" href="<?php echo esc_url($permalink); ?>">
                            <?php esc_html_e('Read more', 'woodmart'); ?>
                        </a>
                    </div>
                </div>
            </article>

        <?php endif; // main_post 
        ?>

        <?php if ($side_posts) : ?>
            <!-- Right 50%: three stacked single event cards -->
            <div class="hero-single-cards">
                <?php foreach ($side_posts as $single_post) :
                    $single_link     = get_permalink($single_post);
                    $single_overview = jn_get_event_overview($single_post);
                    $single_dates    = jn_format_event_dates($single_overview);
                ?>
                    <article class="hero-single-card">
                        <a class="hero-single-card__image" href="<?php echo esc_url($single_link); ?>">
                            <?php echo get_the_post_thumbnail($single_post, 'medium'); ?>

                            <?php $single_status_label = jn_event_status_label($single_overview['eventStatus']); ?>
                            <?php if ($single_status_label || ! empty($single_overview['isFree']) || ! empty($single_overview['eventVenue'])) : ?>
                                <span class="card-badges card-badges--left">
                                    <?php if ($single_status_label) : ?>
                                        <span class="event-status-badge event-status-badge--<?php echo esc_attr($single_overview['eventStatus']); ?>"><?php echo esc_html($single_status_label); ?></span>
                                    <?php endif; ?>
                                    <?php if (! empty($single_overview['isFree'])) : ?>
                                        <span class="event-free-badge"><?php esc_html_e('Free', 'woodmart'); ?></span>
                                    <?php endif; ?>
                                    <?php if (! empty($single_overview['eventVenue'])) : ?>
                                        <span class="event-venue-badge"><?php echo esc_html($single_overview['eventVenue']); ?></span>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>

                            <?php if (! empty($single_overview['isSponsored'])) : ?>
                                <span class="event-sponsored-badge"><?php esc_html_e('Sponsored', 'woodmart'); ?></span>
                            <?php endif; ?>
                        </a>

                        <div class="hero-single-card__body">
                            <?php jn_render_event_tags($single_post); ?>

                            <h3 class="hero-single-card__heading">
                                <a href="<?php echo esc_url($single_link); ?>"><?php echo esc_html(get_the_title($single_post)); ?></a>
                            </h3>

                            <?php
                            // Single hero cards show date + cost only — no address.
                            $single_meta = $single_overview;
                            $single_meta['address'] = '';
                            jn_render_event_meta($single_meta, $single_dates);
                            ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; // side_posts 
        ?>

        <?php wp_reset_postdata(); ?>
    </section>

    <section id="advert_full-width" class="events-advert">
        <?php if (function_exists('nakama_advert')) : ?>
            <div class="events-advert__slot"><?php nakama_advert('horizontal'); ?></div>
        <?php endif; ?>
    </section>
</div>


</header>




<main id="events-archive" class="container-medium">

    <!-- ===== UPCOMING: content (left) + sidebar (right) ===== -->
    <div class="events-top">

        <div class="events-content">


            <header class="events-heading">
                <h2>Japanese Cultural Events:
                    Festivals, Markets, Exhibitions and</h2>
            </header>

            <div class="events-desc">
                <p>Japanese Cultural Events:
                    Festivals, Markets, Exhibitions and More</p>
            </div>

            <div class="events-filter" role="group" aria-label="<?php esc_attr_e('Filter events', 'woodmart'); ?>">
                <button type="button" class="events-filter__pill is-active" data-filter="all" aria-pressed="true">
                    <?php esc_html_e('All', 'woodmart'); ?>
                </button>
                <button type="button" class="events-filter__pill" data-filter="free" aria-pressed="false">
                    <?php esc_html_e('Free Events', 'woodmart'); ?>
                </button>
                <button type="button" class="events-filter__pill" data-filter="paid" aria-pressed="false">
                    <?php esc_html_e('Paid Events', 'woodmart'); ?>
                </button>
            </div>


            <div class="events-cards events-cards--upcoming" aria-live="polite">
                <?php
                // Initial render uses the same helper as the AJAX filter so the
                // "All" state is identical before and after any interaction.
                $upcoming_query = jn_query_upcoming_events('all', get_queried_object_id());
                jn_render_upcoming_cards($upcoming_query, 'all');
                ?>
            </div>

        </div><!-- .events-content -->

        <aside class="events-sidebar">

            <!-- 1. Featured image card (event flagged "Feature in sidebar") -->
            <?php
            $featured_query = new WP_Query([
                'post_type'           => 'post',
                'cat'                 => get_queried_object_id(),
                'posts_per_page'      => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
                'meta_query'          => [
                    [
                        'key'   => JN_EVENT_SIDEBAR_META,
                        'value' => '1',
                    ],
                ],
            ]);

            if ($featured_query->have_posts()) :
                $featured_post     = $featured_query->posts[0];
                $featured_link     = get_permalink($featured_post);
                $featured_overview = jn_get_event_overview($featured_post);
                $featured_dates    = jn_format_event_dates($featured_overview);
            ?>
                <section class="sidebar-section sidebar-featured">
                    <div class="sidebar-featured__card">
                        <a class="sidebar-featured__image" href="<?php echo esc_url($featured_link); ?>">
                            <?php echo get_the_post_thumbnail($featured_post, 'medium'); ?>
                        </a>

                        <div class="sidebar-featured__body">
                            <span class="sidebar-featured__tag"><?php esc_html_e('Featured Event', 'woodmart'); ?></span>

                            <h3 class="sidebar-featured__heading">
                                <a href="<?php echo esc_url($featured_link); ?>"><?php echo esc_html(get_the_title($featured_post)); ?></a>
                            </h3>

                            <?php jn_render_event_meta($featured_overview, $featured_dates); ?>

                            <a class="sidebar-featured__cta" href="<?php echo esc_url($featured_link); ?>">
                                <?php esc_html_e('View Event', 'woodmart'); ?>
                            </a>
                        </div>
                    </div>
                </section>
            <?php
                wp_reset_postdata();
            endif;
            ?>

            <!-- 2. What's On list: on-now OR starting in the next 3 months -->
            <?php
            $window_start = date('Ymd');                          // today
            $window_end   = date('Ymd', strtotime('+3 months'));  // today + 3 months
            $whats_on_query = new WP_Query([
                'post_type'      => 'post',
                'cat'            => get_queried_object_id(),
                'posts_per_page' => 5,
                'orderby'        => ['start_clause' => 'ASC'],
                'meta_query'     => [
                    'relation' => 'AND',
                    'start_clause' => [
                        'key'     => JN_EVENT_START_META,
                        'compare' => 'EXISTS',
                    ],
                    // On now, OR starting within the next 3 months.
                    [
                        'relation' => 'OR',
                        [
                            'key'   => JN_EVENT_STATUS_META,
                            'value' => 'on-now',
                        ],
                        [
                            'key'     => JN_EVENT_START_META,
                            'value'   => [$window_start, $window_end],
                            'compare' => 'BETWEEN',
                            'type'    => 'NUMERIC',
                        ],
                    ],
                    // Never include past events.
                    [
                        'key'     => JN_EVENT_STATUS_META,
                        'value'   => 'past',
                        'compare' => '!=',
                    ],
                ],
            ]);
            ?>
            <section class="sidebar-section sidebar-whats-on">
                <p class="eyebrow"><?php esc_html_e('On Now & Coming Up', 'woodmart'); ?></p>

                <?php if ($whats_on_query->have_posts()) : ?>
                    <ol class="sidebar-whats-on__list">
                        <?php while ($whats_on_query->have_posts()) : $whats_on_query->the_post();
                            $wo_overview = jn_get_event_overview(get_post());
                            $wo_status   = jn_event_status_label($wo_overview['eventStatus']);
                            $wo_dates    = jn_format_event_dates($wo_overview);
                        ?>
                            <li class="sidebar-whats-on__item">
                                <a href="<?php the_permalink(); ?>">
                                    <span class="sidebar-whats-on__number" aria-hidden="true"></span>

                                    <div class="sidebar-whats-on__content">
                                        <h4 class="sidebar-whats-on__heading">
                                            <?php echo esc_html(get_the_title()); ?>
                                        </h4>
                                        <div class="sidebar-whats-on__meta">
                                            <?php if ($wo_status) : ?>
                                                <span class="event-status-badge event-status-badge--<?php echo esc_attr($wo_overview['eventStatus']); ?>"><?php echo esc_html($wo_status); ?></span>
                                            <?php endif; ?>
                                            <?php if ($wo_dates) : ?>
                                                <span class="sidebar-whats-on__date">
                                                    <?php echo jn_event_meta_icon('date'); // shared date icon 
                                                    ?>
                                                    <span><?php echo wp_kses_post($wo_dates); ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ol>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="sidebar-whats-on__empty"><?php esc_html_e('Nothing on right now — check back soon.', 'woodmart'); ?></p>
                <?php endif; ?>
            </section>

            <!-- 3. Advert -->
            <section class="sidebar-section sidebar-ad">
                <?php if (function_exists('nakama_advert')) : ?>
                    <div class="sidebar-ad__slot"><?php nakama_advert('vertical'); ?></div>
                <?php endif; ?>
            </section>

            <!-- 4. Event signup CTA -->
            <section class="sidebar-section sidebar-signup event-signup-cta">
                <p class="eyebrow"><?php esc_html_e('Got an event?', 'woodmart'); ?></p>
                <h3 class="event-signup-cta__heading"><?php esc_html_e('List it on the What\'s On hub', 'woodmart'); ?></h3>
                <p class="event-signup-cta__desc"><?php esc_html_e('Screening, market, gig or exhibition? Tell us and it could feature here and in the newsletter.', 'woodmart'); ?></p>
                <a class="event-signup-cta__cta" href="#">
                    <?php esc_html_e('Submit an event', 'woodmart'); ?> &rsaquo;
                </a>
            </section>

        </aside>

    </div><!-- .events-top -->

    <!-- ===== FULL-WIDTH advert (bottom — its own slot) ===== -->
    <div class="events-advert">
        <?php if (function_exists('nakama_advert')) : ?>
            <div class="events-advert__slot"><?php nakama_advert('horizontal-bottom'); ?></div>
        <?php endif; ?>
    </div>

    <!-- ===== PAST EVENTS (full width) ===== -->
    <header class="events-heading events-heading--past">

        <h2>Past Events</h2>
    </header>

    <div class="events-cards events-cards--past">
        <?php
        // Latest 3 ended events, by end date descending (most recently finished
        // first) — the mirror of the grid's end-date-ascending sort.
        $past_query = new WP_Query([
            'post_type'      => 'post',
            'cat'            => get_queried_object_id(),
            'posts_per_page' => 3,
            'orderby'        => ['end_clause' => 'DESC'],
            'meta_query'     => [
                'relation'   => 'AND',
                'end_clause' => [
                    'key'     => JN_EVENT_END_META,
                    'compare' => 'EXISTS',
                ],
                [
                    'key'   => JN_EVENT_STATUS_META,
                    'value' => 'past',
                ],
            ],
        ]);

        if ($past_query->have_posts()) :
            while ($past_query->have_posts()) : $past_query->the_post();
                get_template_part('template-parts/content/card-event', null, ['post' => get_post()]);
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

    <?php
    // Link to the full Past Events archive. Found by its page template, so it
    // works whatever slug the page is given (empty if the page isn't created).
    $past_pages = get_pages([
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-past-events.php',
        'number'     => 1,
    ]);
    if (! empty($past_pages)) :
    ?>
        <div class="events-past-more">
            <a class="events-past-more__link" href="<?php echo esc_url(get_permalink($past_pages[0]->ID)); ?>">
                <?php esc_html_e('View all past events', 'woodmart'); ?> &rarr;
            </a>
        </div>
    <?php endif; ?>

    <!-- ===== CTA CARDS: submit event + newsletter (50/50) ===== -->
    <section class="events-cta">

        <div class="events-cta__card events-cta__card--submit event-signup-cta">
            <p class="eyebrow"><?php esc_html_e('Got an event?', 'woodmart'); ?></p>
            <h3 class="event-signup-cta__heading"><?php esc_html_e('List it on the What\'s On hub', 'woodmart'); ?></h3>
            <p class="event-signup-cta__desc"><?php esc_html_e('Screening, market, gig or exhibition? Tell us and it could feature here and in the newsletter.', 'woodmart'); ?></p>
            <a class="event-signup-cta__cta" href="#">
                <?php esc_html_e('Submit an event', 'woodmart'); ?> &rsaquo;
            </a>
        </div>

        <div class="events-cta__card events-cta__card--newsletter event-signup-cta event-signup-cta--newsletter">
            <p class="eyebrow"><?php esc_html_e("What's On newsletter", 'woodmart'); ?></p>
            <h3 class="event-signup-cta__heading"><?php esc_html_e('Never miss a Japanese event in the UK', 'woodmart'); ?></h3>
            <p class="event-signup-cta__desc"><?php esc_html_e('A focused, weekly What\'s On email: on now, this week, and upcoming. Separate from our general list.', 'woodmart'); ?></p>

            <div class="event-signup-cta__form">
                <div class="klaviyo-form-RCvnrW"></div>
            </div>

            <p class="event-signup-cta__smallprint">
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

    </section>

</main>

<?php get_template_part('template-parts/footers/main-footer'); ?>