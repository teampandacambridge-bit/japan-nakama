<?php

/**
 * Template Name: Past Events
 * Template Post Type: page
 *
 * A paginated, compact archive of every past event (events whose end date has
 * passed). "Past" is a computed status synced to _jn_event_status, so no
 * manual tagging is needed — events appear here automatically once they end.
 */

get_template_part('template-parts/headers/nakama-head');

$events_cat = get_category_by_slug('events');
$events_cat_id = $events_cat ? (int) $events_cat->term_id : 0;

$paged = max(1, get_query_var('paged'), get_query_var('page'));

$past_query = new WP_Query([
    'post_type'      => 'post',
    'cat'            => $events_cat_id,
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => ['end_clause' => 'DESC'], // most recently finished first
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
?>

<div class="container-medium">
    <section id="page-title">
        <p class="eyebrow"><?php esc_html_e('Archive', 'woodmart'); ?></p>
        <h1><?php echo esc_html(get_the_title()); ?></h1>
        <?php if (get_the_content()) : ?>
            <div class="past-events__intro"><?php the_content(); ?></div>
        <?php endif; ?>
    </section>
</div>

<main id="past-events" class="container-medium">
    <?php if ($past_query->have_posts()) : ?>
        <ol class="past-events__list">
            <?php while ($past_query->have_posts()) : $past_query->the_post();
                $pe_overview = jn_get_event_overview(get_post());
                $pe_dates    = jn_format_event_dates($pe_overview);
            ?>
                <li class="past-events__item">
                    <a class="past-events__link" href="<?php the_permalink(); ?>">
                        <h2 class="past-events__heading"><?php echo esc_html(get_the_title()); ?></h2>
                        <?php if ($pe_dates) : ?>
                            <span class="past-events__date">
                                <?php echo jn_event_meta_icon('date'); // shared date icon ?>
                                <span><?php echo wp_kses_post($pe_dates); ?></span>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ol>

        <?php
        $pagination = paginate_links([
            'total'     => $past_query->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'prev_text' => __('&larr; Newer', 'woodmart'),
            'next_text' => __('Older &rarr;', 'woodmart'),
            'type'      => 'list',
        ]);
        if ($pagination) :
        ?>
            <nav class="past-events__pagination" aria-label="<?php esc_attr_e('Past events pages', 'woodmart'); ?>">
                <?php echo $pagination; // paginate_links() output is safe ?>
            </nav>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="past-events__empty"><?php esc_html_e('No past events yet.', 'woodmart'); ?></p>
    <?php endif; ?>
</main>

<?php get_template_part('template-parts/footers/main-footer'); ?>
