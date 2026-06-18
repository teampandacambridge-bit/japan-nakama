<?php
$current_category = get_queried_object();
?>

<div class="short-list">
    <ul>
        <h2>Trending Articles</h2>
        <?php
        $args = array(
            'tag'            => 'jetpac-esim', // Filter by tag slug
            'posts_per_page' => 5,
            'orderby'        => 'meta_value_num', // Order by custom field (post views)
            'meta_key'       => 'post_views_count', // The meta key used for views
            'order'          => 'DESC', // Order from highest to lowest views
        );

        $query = new WP_Query($args);
        ?>


        <?php if ($query->have_posts()) : ?>
            <ul class="short-list">
                <?php $dot_num = 1; ?>
                <?php $trend_post = 0; ?>

                <?php while ($query->have_posts() && $dot_num <= 5) : $query->the_post(); ?>
                    <li>
                        <div class="dot-wrap">
                            <div class="dot">
                                <p><?php echo $dot_num; ?></p>
                            </div>
                        </div>

                        <a href="<?php the_permalink() ?>">
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </li>
                    <?php $dot_num++; ?>
                    <?php $trend_post++; ?>
                <?php endwhile; ?>
            </ul>

        <?php endif;
        wp_reset_postdata(); ?>
    </ul>
</div>