<?php

/**
 * Event card partial.
 *
 * Shared by the upcoming and past event grids (and any future event card list).
 * Pass the post via args:
 *   get_template_part('template-parts/content/card-event', null, ['post' => $post]);
 *
 * @var array $args {
 *   @type int|WP_Post $post The event post to render.
 * }
 */

$card_post = $args['post'] ?? get_post();
$card_post = get_post($card_post);

if (! $card_post) {
    return;
}

$card_link     = get_permalink($card_post);
$card_overview = jn_get_event_overview($card_post);
$card_dates    = jn_format_event_dates($card_overview);
$card_status   = jn_event_status_label($card_overview['eventStatus']);
?>

<article class="event-card">
    <a class="event-card__image" href="<?php echo esc_url($card_link); ?>">
        <?php echo get_the_post_thumbnail($card_post, 'medium'); ?>

        <?php if ($card_status || ! empty($card_overview['isFree']) || ! empty($card_overview['eventVenue'])) : ?>
            <span class="card-badges card-badges--left">
                <?php if ($card_status) : ?>
                    <span class="event-status-badge event-status-badge--<?php echo esc_attr($card_overview['eventStatus']); ?>"><?php echo esc_html($card_status); ?></span>
                <?php endif; ?>
                <?php if (! empty($card_overview['isFree'])) : ?>
                    <span class="event-free-badge"><?php esc_html_e('Free', 'woodmart'); ?></span>
                <?php endif; ?>
                <?php if (! empty($card_overview['eventVenue'])) : ?>
                    <span class="event-venue-badge"><?php echo esc_html($card_overview['eventVenue']); ?></span>
                <?php endif; ?>
            </span>
        <?php endif; ?>

        <?php if (! empty($card_overview['isSponsored'])) : ?>
            <span class="event-sponsored-badge"><?php esc_html_e('Sponsored', 'woodmart'); ?></span>
        <?php endif; ?>
    </a>

    <div class="event-card__body">
        <?php jn_render_event_tags($card_post); ?>

        <h3 class="event-card__heading">
            <a href="<?php echo esc_url($card_link); ?>"><?php echo esc_html(get_the_title($card_post)); ?></a>
        </h3>

        <?php jn_render_event_meta($card_overview, $card_dates); ?>

        <div class="event-card__actions">
            <?php if (! empty($card_overview['cta']['url']) && ! empty($card_overview['cta']['text']) && $card_overview['eventStatus'] !== 'past') : ?>
                <a class="event-card__cta" href="<?php echo esc_url($card_overview['cta']['url']); ?>" target="_blank" rel="noopener">
                    <?php echo esc_html($card_overview['cta']['text']); ?>
                </a>
            <?php endif; ?>

            <a class="event-card__read-more" href="<?php echo esc_url($card_link); ?>">
                <?php esc_html_e('Read more', 'woodmart'); ?>
            </a>
        </div>
    </div>
</article>